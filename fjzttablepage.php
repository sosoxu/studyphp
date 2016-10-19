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
//try

    //windows下使用的是memcache,mac下使用的是redis
    /*
    if (function_exists("memcache_connect"))
    {
        $memcache = memcache_connect('localhost', 11211);
        if ($memcache) {
            $vp = $memcache->get('vp');
            if (!$vp) {
                $vp = 1;
                $memcache->set('vp', $vp);
            } else {
                $vp += 1;
                $memcache->set('vp', $vp);
            }
            echo "<br>";
            echo "vp:" . $vp;
            echo "<br>";

            //$memcache->set('str_key', 'test string');
            //$memcache->set('num_key', 123);

            //echo $memcache->get('str_key');
            //echo "<br>";
            //echo $memcache->get('num_key');
            exit;
        }
        else{
            echo "Failed to connect to memcache";
        }
    }
    */

    try
    {
        $redis = new Redis();
        $redis->connect('localhost', 6379);
        echo "connect to server redis successfully";
        $pv = 1;
        if (!$redis->exists('pv'))
        {
            //echo "aaaa";
            $redis->set('pv', $pv);
        }
        else
        {
            $pv = (int)$redis->get('pv');
            $pv += 1;
            $redis->set('pv', $pv);
        }
        echo "pv : ".$pv;

    }
    catch(Exception $e)
    {
        echo "Failed to connect redis".$e;
    }


//catch (Exception $e)
//    {
//        echo "Failed to connect memcache";
//    }
?>
</div>
