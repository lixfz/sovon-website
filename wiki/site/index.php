<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"/>
<meta name="Keywords" content="machine learning, deep learning, linux,wiki">
<title>SOVON.NET</title>
</head>

<body>

<?php

if( array_key_exists('HTTP_ACCEPT_LANGUAGE',$_SERVER) ){
    $accept_lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    if( stripos($accept_lang,"zh") !== false ){
        include 'body-go.php';
    } else {
        include 'body-na.php';
    }
} else {
    include 'body-na.php';
}
/*
 */
?>

<pre>

<?php include 'dump.php';?>
 
</pre>

<hr/>
<?php include 'fymap.php';?>

<hr/>

<?php include 'footer.php';?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>