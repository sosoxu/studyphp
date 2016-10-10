<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 16/9/19
 * Time: 21:30
 */

$user = $_COOKIE['username'];
$umd5 = md5($user);
$ckumd5 = $_COOKIE['md5'];
if (isset($user) && isset($ckumd5) && $ckumd5 == $umd5)
{
    echo "<p>"."user has logined"."</p>";
}
else{
    echo "<p>"."failed to get cookies"."</p>";
}

if (isset($testval))
{
    $testval += 1;
    echo $testval;
}
else
{
    $testval = 0;
    echo $testval;
}
