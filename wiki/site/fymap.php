<?php
function get_url($url){
    $headerArray =array("Content-type:application/json;","Accept:application/json","Accept-Encoding: gzip");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
    $output = curl_exec($ch);
    curl_close($ch);
    //$output = json_decode($output,true);
    return $output;
}

function post_url($url,$data){
    $data  = json_encode($data);    
    $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    //return json_decode($output，true);
    return $output;
}

function write_file($filename,$data){
    $fn = fopen($filename, "w");
    ftruncate($fn,0);
    fwrite($fn, $data);
    fclose($fn);
}

function get_fymap(){
    $filename = "data/sina_fymap_" . date('YmdHis') . ".json.gz";
    $data = get_url("https://interface.sina.cn/news/wap/fymap2020_data.d.json");
    write_file($filename, $data);

    return $filename;
}

ignore_user_abort(true);
set_time_limit(0);
date_default_timezone_set('PRC'); 

$lockfile = "fymap.lock";
$runningfile = "fymap.running";
$interval = 3600;

$lockfile_fn = fopen($lockfile, "w") or die("Unable to open file!");
if( flock($lockfile_fn, LOCK_EX | LOCK_NB) ){
    $now = time();
    $start_at = $now;
    get_fymap();

    $next_time = $now - $now % $interval + $interval + 1; //delay 1s
    echo "next time: " . date('YmdHis',$next_time) . "<br/>";
    
    $i=0;
    while( file_exists($runningfile) && $i < 10000 ){
        echo '.';

        $now = time();
        if( $now > $next_time ){
            $i++;
            get_fymap();
            $next_time = $now - $now % $interval + $interval + 15; //delay 15s
            echo "next time: " . date('YmdHis',$next_time) . "<br/>";
        }
        
        $content = date('YmdHis',$start_at) . "-" . date('YmdHis',$now) ."-" . $i;
        fseek($lockfile_fn,0,SEEK_SET);
        ftruncate($lockfile_fn,0);
        fwrite($lockfile_fn, $content);

        usleep(1000*1000*1); // sleep 1s
    }
    fclose($lockfile_fn);
    unlink($lockfile);
}else{
    fclose($lockfile_fn);
    echo 'locked by another process.<br/>';
}

?>

