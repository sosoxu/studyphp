<?php
//解决中文乱码，html编码设置为utf-8
header("Content-type:text/html;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/20
 * Time: 19:51
 */
define("FJUSER", 'fjuser');
define("FJSUCNO", 'sucNo');
define("FJRATE", 'fjrate');
define("FJSTOCK", 'stock');
define("FJREASON", 'reason');
define("FJTIME", 'time');
define("FJPRICE", 'fjprice');
define("FJCURPRICE", 'curprice');
define("FJFUDU", 'fudu');
define("FJZTNO", 'ztno');
define("FJZTDATE", 'ztdate');

class FjItem
{
    var $uid;
    var $user;
    var $sucNo;
    var $rate;
    var $stock;
    var $reason;
    var $time;
    var $fjprice;
    var $curprice;
    var $fudu;
    var $ztno;
    var $ztdate;
    public function __construct($data = array())
    {
        $this->uid = 0;
        $this->user = isset($data[FJUSER]) ? $data[FJUSER] : 'test';
        $this->sucNo = isset($data[FJSUCNO]) ? $data[FJSUCNO] : 0;
        $this->rate = isset($data[FJRATE]) ? $data[FJRATE] : 0;
        $this->stock = isset($data[FJSTOCK]) ? $data[FJSTOCK] : 'test';
        $this->reason = isset($data[FJREASON]) ? $data[FJREASON] : 'test';
        $this->time = isset($data[FJTIME]) ? $data[FJTIME] : '';
        $this->fjprice = isset($data[FJPRICE]) ? $data[FJPRICE] : 0;
        $this->curprice = isset($data[FJCURPRICE]) ? $data[FJCURPRICE] : 0;
        $this->fudu = isset($data[FJFUDU]) ? $data[FJFUDU] : 0;
        $this->ztno = isset($data[FJZTNO]) ? $data[FJZTNO] : 0;
        $this->ztdate = isset($data[FJZTDATE]) ? $data[FJZTDATE] : '';
    }

    public function buildItem($data = array())
    {
        $cnt = count($data);
        if ($cnt == 12)
        {
            $i = 0;
            $this->user = $data[++$i];
            $this->sucNo = (int)$data[++$i];
            $this->rate = (float)$data[++$i];
            $this->stock = $data[++$i];
            $this->reason = $data[++$i];
            $this->time = $data[++$i];
            $this->fjprice = $data[++$i];
            $this->curprice = $data[++$i];
            $this->fudu = $data[++$i];
            $this->ztno = (int)$data[++$i];
            $this->ztdate = $data[++$i];
        }
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->user.":".$this->stock.":".$this->reason;
    }

}

class FjItemDBOper
{
    var $mysqli;
    public function __construct($dbconfig)
    {
        $host = isset($dbconfig['host']) ? $dbconfig['host'] : 'localhost';
        $user = isset($dbconfig['user']) ? $dbconfig['user'] : 'root';
        $pwd = isset($dbconfig['password']) ? $dbconfig['password'] : 'root';
        $db = isset($dbconfig['database']) ? $dbconfig['database'] : 'guhai';
        $this->mysqli = mysqli_connect($host, $user, $pwd, $db);
        if (mysqli_connect_errno())
        {
            //error handle
            echo mysqli_connect_error();
            return;
        }
        //解决中文乱码，数据库编码utf8
        mysqli_set_charset($this->mysqli, "utf8");
        //mysqli_query($this->mysqli, 'SET NAMES UTF8');
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        mysqli_close($this->mysqli);
    }

    public function query($sql)
    {
        $items = array();
        $results = mysqli_query($this->mysqli, 'SHOW TABLES');
        //$row = mysqli_fetch_row($results);
        $results = mysqli_query($this->mysqli, $sql);
        //$num = mysqli_num_rows($results);
        //$result = mysqli_use_result($this->mysqli);
        if ($results) {
            while ($row = mysqli_fetch_row($results)) {
                //echo count($row);
                //echo $row[0].":".$row[1].$row[FJUSER];
                //$item = new FjItem();
                //$item->buildItem($row);
                //echo $item;
                //echo "<br>";
                //$items[] = $item;
                $items[] = $row;
            }
            mysqli_free_result($results);
        }
        /*
        {
            $res = mysqli_use_result($this->mysqli);
            while ($row = mysqli_fetch_row($res))
            {
               echo $row[0];
            }
        }
        */
        return $items;
    }

    public function queryFullItem()
    {
        $selectsql = "select * from fjzt limit 10;";
        $rows = $this->query($selectsql);
        $items = array();
        foreach($rows as $row)
        {
            $fjitem = new FjItem();
            $fjitem->buildItem($row);
            $items[] = $fjitem;
        }
        return $items;
    }

    public function queryTotalCount()
    {
        $sql = "SELECT count(*) FROM fjzt;";
        $result = mysqli_query($this->mysqli, $sql);
        $row = mysqli_fetch_row($result);
        return $row;
    }

    public function queryRangeItem($start, $end)
    {
        $selectsql = "select * from fjzt where id>=$start and id<=$end;";
        echo $selectsql;
        $rows = $this->query($selectsql);
        $items = array();
        foreach($rows as $row)
        {
            $fjitem = new FjItem();
            $fjitem->buildItem($row);
            $items[] = $fjitem;
        }
        return $items;
    }
}

function testfjzt()
{
    $fjdboper = new FjItemDBOper(array());
    $selectsql = "select * from fjzt limit 10;";
    $fjdboper->query($selectsql);
    $fjdboper->queryTotalCount();
    echo count($fjdboper->queryRangeItem(2, 5));
}
//testfjzt();
