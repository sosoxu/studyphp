<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/20
 * Time: 11:01
 */
//获取登录信息
$islogin = false;
if ($islogin)
{
    echo "<a href=\"userinfo.php\" id=\"userinfo\" class=\"userinfo\">".$user."</a>";
}
else
{
    echo "<form class=\"login\" method=\"post\" action=\"logincheck.php\">";
    echo "<div id=\"userlogin\">";
    echo "name:<input type=\"text\" name=\"username\">";
    echo "password:<input type=\"password\" name=\"password\">";
    echo "<input type=\"submit\" name=\"submit\" value=\"login\">";
    echo "<a href=\"register.php\">register</a>";
    echo "</div>";
    echo "</form>";
}