<?php
if (isset($_POST['submit']) && $_POST['submit'] == "login")
{
    $user = $_POST['username'];
    $pwd = $_POST['password'];
    if (empty($user) || empty($pwd))
    {
        echo "<script>alert(\"Please input user or password\");history.go(-1);</script>";
    }
    else
    {
        $mysqli = mysqli_connect('localhost', 'root', 'root', 'studyphp');
        //mysqli_select_db('studyphp');
        //mysqli_query("set names 'utf-8'");
        $sql = "SELECT username,password FROM user WHERE username='$user' AND password='$pwd'";
        $result = mysqli_query($mysqli, $sql);
        //echo $result;
        $num = mysqli_num_rows($result);
        if ($num > 0)
        {
            $row = mysqli_fetch_array($result);

            //$_SESSION[]
            $usermd5 = md5($user);
            setcookie('username', $user);
            setcookie('md5', $usermd5);
            //setcookie('password', $pwd);
            //echo $row[0];
            //echo $_COOKIE['login'];
            mysqli_free_result($result);
            echo "<a href=\"home.php\">home</a>";

        }
        else{
            echo "<script>alert('Error found in username or password');history.go(-1);</script>";
        }
    }
}
else{
    echo "<script>alert('Failed to login');history.go(-1);</script>";
}