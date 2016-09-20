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
        $row = mysqli_fetch_row($results);
        $results = mysqli_query($this->mysqli, $sql);
        $num = mysqli_num_rows($results);
        //$result = mysqli_use_result($this->mysqli);
        if ($results) {
            while ($row = mysqli_fetch_row($results)) {
                echo count($row);
                echo $row[0].":".$row[1];
                echo "<br>";
            }
        }
        echo $result ? "true" : "false";
        /*
        {
            $res = mysqli_use_result($this->mysqli);
            while ($row = mysqli_fetch_row($res))
            {
               echo $row[0];
            }
        }
        */
    }
}

$fjdboper = new FjItemDBOper(array());
$selectsql = "select user,stock from fjzt limit 10;";
$fjdboper->query($selectsql);
