<?php
/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/21
 * Time: 15:50
 */

function createTablePagesIndex($totalRow, $onePageRow, $displayPageCount, $curPage, $url)
{
    //$totalRow = 1000;
    //$onePageRow = 10;
    //$displayPageCount = 10;
    //$curPage = 18;
    $curPage = isset($_GET['page']) ? $_GET['page'] : $curPage;
    $first = ($curPage -1) / $displayPageCount;
    $first = (int)$first;
    $first = $first * $displayPageCount + 1;
    $end = $first + $displayPageCount - 1;
    $maxend = ceil($totalRow / $onePageRow);
    if ($maxend < $end)
    {
        $end = $maxend;
    }
    if ($first > $displayPageCount)
    {
        echo "<a href=".$url."?page=".($first - 1).">prev</a>";
    }
    for ($i = $first; $i <= $end; ++$i) {
        ?>
        <a href=<?php echo $url.'?page='.(string)$i ?>><?php echo ($i == $curPage) ? "<strong>".$i."</strong>" : $i; ?></a>
        <?php
    }
    if ($end < $maxend)
    {
        echo "<a href=".$url."?page=".($end + 1).">next</a>";
    }
}