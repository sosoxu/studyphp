<?php
$user = $_COOKIE['username'];
$password = $_COOKIE['password'];
if (isset($user) && isset($password))
{
    echo "auto login : ".$user;
}
else
{
    echo "<form action=\"logincheck.php\" method=\"post\">";
    echo "User:<input type=\"text\" name=\"username\" value=\"$user\" />";
    echo "<br>";
    echo "Password:<input type=\"password\" name=\"password\" value=\"$password\"/>";
    echo "<br>";
    echo "<input type=\"submit\" name=\"submit\" value=\"login\"/>";
    echo "<a href=\"register.php\">register</a>";
    echo "</form>";
}
