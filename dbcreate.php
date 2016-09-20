<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 16/9/19
 * Time: 21:54
 */
//$mysqli = mysqli_connect('localhost', 'root', 'root', 'studyphp');

$mysqli = mysqli_connect('localhost', 'root', 'admin', 'studyphp');
if (mysqli_connect_errno($mysqli))
{
    echo "Failed to connect to MySQL: ".mysqli_connect_error();
}
$showdbs = "SHOW DATABASES";
$results = mysqli_query($mysqli, $showdbs);
echo $results;
