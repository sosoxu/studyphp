<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>testphp</title>
 <style>
  .error{color:#FF0000;}
 </style>
</head>
<body>
 <?php
  $name = $email = $gender = $comment = $website = "";
  $nameErr = $emailErr = $genderErr = $websiteErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
      if (empty($_POST["name"]))
      {
          $nameErr = "名字是必须的";
      }
      else
      {
          $name = test_input($_POST["name"]);
          if (!preg_match("/^[a-zA-Z ]*$/", $name))
          {
              $nameErr = "只允许字母和数字";
          }
      }

      if (empty($_POST["email"]))
      {
          $emailErr = "邮箱是必须的";
      }
      else
      {
          $email = test_input($_POST["email"]);
          if (!preg_match("/([\w\-]+\@[\w\-]+[\w\-]+)/", $email))
          {
              $emailErr = "非法邮箱格式";
          }
      }

      if (empty($_POST["website"]))
      {
          $website = "";
      }
      else
      {
          $website = test_input($_POST["website"]);
          if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website))
          {
              $websiteErr = "非法的URL";
          }
      }

      if (empty($_POST["comment"]))
      {
          $comment = "";
      }
      else
      {
          $comment = test_input($_POST["comment"]);
      }

      if (empty($_POST["gender"]))
      {
          $genderErr = "性别是必须滴";
      }
      else
      {
          $gender = test_input($_POST["gender"]);
      }
  }

  function test_input($data)
  {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
 ?>
 <h2>form test</h2>
 <p><span class="error">* 必须字段</span></p>
 <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <!--form method="post" action="test.php"-->
 Name:<input type="text" name="name" value="<?php echo $name;?>">
 <span class="error">*<?php echo $nameErr; ?></span>
 <br><br>
 Email:<input type="text" name="email" value="<?php echo $email; ?>">
 <span class="error">*<?php echo $emailErr; ?></span>
 <br><br>
 Website:<input type="text" name="website" value="<?php echo $website; ?>">
 <span class="error"><?php echo $websiteErr; ?></span>
 <br><br>
 Note:<textarea name="comment" rows="5" cols="40"><?php echo $comment; ?></textarea>
 <br><br>
 Sex:<input type="radio" name="gender" <?php
  if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">Female
     <input type="radio" name="gender" <?php
  if (isset($gender) && $gender == "male")  echo "checked"; ?> value="male">Male
 <span class="error">*<?php echo $genderErr; ?></span>
 <br><br>
 <input type="submit" name="submit" value="Submit">
 </form>
</body>
</html>
