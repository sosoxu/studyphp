<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 16/10/20
 * Time: 19:16
 */
header("charset", "utf-8");
$dirmv = "/mv/";
echo $dirmv;
echo "<br>";
echo file_exists("/mv/1.mp4") ? "true" : "false";
echo "<br>";
$path = file_get_contents('http://dota2.org:8888/mv/mvpath.php');
echo $path;

function fileinfo($path)
{
    if (!is_dir($path))
        return false;
    $files = scandir($path);
    foreach($files as $file)
    {
        if($file == "." || $file == "..")
            continue;
        $arr[] = $file;//iconv('gbk', 'utf-8', $file);
    }
    return $arr;
}

$files = fileinfo($path);
foreach ($files as $file)
{
    echo "<a href=\"$dirmv".$file."\">$file</a>"."<br>";
}