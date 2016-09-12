<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'register')
{
    $user = $_POST['username'];
    $pwd = $_POST['password'];
    $cpwd = $_POST['confirm'];
    if (empty($user) || empty($pwd) || empty($cpwd))
    {
        echo "<script>alert('Please input full message.');history.go(-1);</script>";
    }
    else
    {
        if ($pwd == $cpwd)
        {
            $mysqli = mysqli_connect('localhost', 'root', 'root', 'studyphp');
            $sql = "SELECT username FROM user where username='$user'";
            $result = mysqli_query($mysqli, $sql);
            $num = mysqli_num_rows($result);
            if ($num)
            {
                echo "<script>alert('User has been existed.');history.go(-1);</script>";
            }
            else
            {
                $insertsql = "INSERT INTO user(username, password) VALUES('$user', '$pwd');";
                $insert_res = mysqli_query($mysqli, $insertsql);
                if ($insertsql)
                {
                    echo "<script>alert('Success');</script>";
                }
                else
                {
                    echo "<script>alert('Server is busy.');history.go(-1);</script>";
                }
            }
        }
        else
        {
            echo "<script>alert('password is not same');history.go(-1);</script>";
        }
    }
}
else
{
    echo "<script>alert('Failed to commit data');history.go(-1);</script>";
}
