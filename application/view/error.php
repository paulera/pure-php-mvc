<html><body>
<h1>Oh no! A server error!</h1>
 
<pre>
<?php var_dump($exception); ?>

<b>XDEBUG Output:</b>

<?php 
if (isset($exception->xdebug_message)) {
    echo $exception->xdebug_message;
}
?>

</pre>