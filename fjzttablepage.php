<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/22
 * Time: 17:05
 */
?>
<div id="pages">
    <?php
    //查询数量，一页20行，页数显示10
    require 'tablepages.php';
    $url = $_SERVER['PHP_SELF'];
    createTablePagesIndex($rowcnt, $apagerow, $dispages, $curIndex, (string)$url);
    ?>
<?php
$memcache = memcache_connect('localhost', 11211);
//$memcache = memcache_connect('dota2', 11211);
if ($memcache)
{
    $vp = $memcache->get('vp');
    if (!$vp)
    {
        $vp = 1;
        $memcache->set('vp', $vp);
    }
    else
    {
        $vp += 1;
        $memcache->set('vp', $vp);
    }
    echo "<br>";
    echo "vp:".$vp;
    echo "<br>";

    //$memcache->set('str_key', 'test string');
    //$memcache->set('num_key', 123);

    //echo $memcache->get('str_key');
    //echo "<br>";
    //echo $memcache->get('num_key');
}
else
{
    echo "Failed to connect memcache";
}
?>
</div>
