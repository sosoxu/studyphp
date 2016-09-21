<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/21
 * Time: 9:37
 */
require 'fjzt.php';
?>
<table id="fjzt" border="1">
    <tr>
        <td>stock</td>
        <td>reason</td>
        <td>user</td>
    </tr>
    <?php
    $fjdboper = new FjItemDBOper(array());
    $rowcnt = $fjdboper->queryTotalCount();
    $rowcnt = (int)$rowcnt[0];
    $apagerow = 10;
    $dispages = 10;
    $curIndex = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($curIndex - 1) * $apagerow + 1;
    $end = $curIndex * $apagerow > $rowcnt ? $rowcnt : $curIndex * $apagerow;
    $fjItems = $fjdboper->queryRangeItem($start, $end);
    foreach ($fjItems as $item)
    {
    ?>
        <tr>
            <td><?php echo $item->stock; ?></td>
            <td><?php echo $item->reason; ?></td>
            <td><?php echo $item->user; ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<div id="pages">
    <?php
    //查询数量，一页20行，页数显示10
    require 'tablepages.php';
    $url = $_SERVER['PHP_SELF'];
    createTablePagesIndex($rowcnt, $apagerow, $dispages, $curIndex, (string)$url);
    ?>
</div>
