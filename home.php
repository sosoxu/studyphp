<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/13
 * Time: 15:13
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