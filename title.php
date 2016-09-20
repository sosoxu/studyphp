<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/20
 * Time: 11:01
 */
//获取登录信息
$islogin = false;
$user = 'aaa';
/*
if ($islogin)
{
    echo "<a href=\"userinfo.php\" id=\"userinfo\" class=\"userinfo\">".$user."</a>";
}
else
{
    echo "<div id=\"userlogin\">";
    echo "<form class=\"login\" method=\"post\" action=\"logincheck.php\">";
    echo "name:<input type=\"text\" name=\"username\">";
    echo "password:<input type=\"password\" name=\"password\">";
    echo "<input type=\"submit\" name=\"submit\" value=\"login\">";
    echo "<a href=\"register.php\">register</a>";
    echo "</form>";
    echo "</div>";
}
*/
?>

<img src="img/MAMP-PRO-Logo.png">
<?php if($islogin): ?>
<a href="userinfo.php" id="userinfo" class="userinfo"><?php echo $user ?></a>
<?php else: ?>
<div id="userlogin">
    <form class="login" method="post" action="logincheck.php">
        name:<input type="text" name="username">
        <br>
        password:<input type="password" name="password">
        <br>
        <input type="submit" name="submit" value="login">
        <a href="register.php">register</a>
    </form>
</div>
<?php endif;?>