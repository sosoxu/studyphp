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
    $fjItems = $fjdboper->queryFullItem();
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
    $rowcnt = 1000;
    $apagerow = 10;
    $dispages = 10;
    $curIndex = 18;
    require 'tablepages.php';
    $url = $_SERVER['PHP_SELF'];
    createTablePagesIndex(1000, 10, 10, 1, (string)$url);
    ?>
</div>
