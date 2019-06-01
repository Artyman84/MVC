<?php
use core\Session;

$isAdmin = Session::inst()->getVar('is_admin');
$arrow = '<span class="glyphicon glyphicon-chevron-' . ($direction == 'asc' ? 'up' : 'down') . '"></span>';
$newDirection = $direction == 'asc' ? 'desc' : 'asc';
?>
<div class="row">
    <div class="col-md-10"><h1>Tasks table</h1></div>
    <div class="col-md-2 text-right"><h4><a href="/main/create" class="success js-create"><span class="glyphicon glyphicon-plus"></span> Create task</a></h4></div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th class="text-nowrap"><a href="/main/index?order=name&direction=<?php echo $order == 'name' ? $newDirection : 'asc'?>&page_num=<?php echo $pageNum?>">Name <?php echo $order == 'name' ? $arrow : ''?></a></th>
                <th class="text-nowrap"><a href="/main/index?order=email&direction=<?php echo $order == 'email' ? $newDirection : 'asc'?>&page_num=<?php echo $pageNum?>">Email <?php echo $order == 'email' ? $arrow : ''?></a></th>
                <th>Task</th>
                <th class="text-center text-nowrap"><a href="/main/index?order=status&direction=<?php echo $order == 'status' ? $newDirection : 'asc'?>&page_num=<?php echo $pageNum?>">Status <?php echo $order == 'status' ? $arrow : ''?></a></th>
                <?php if ( $isAdmin ) {?>
                    <th class="text-right text-nowrap"></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php if( !empty($tasks) ) {
                foreach ($tasks as $i => $task) {?>
                    <tr>
                        <td><?php echo ($i+1);?></td>
                        <td><?php echo htmlspecialchars($task['name'])?></td>
                        <td><?php echo htmlspecialchars($task['email'])?></td>
                        <td><?php echo nl2br(htmlspecialchars($task['text']))?></td>
                        <td class="text-center"><?php echo $task['status'] ? '<span class="glyphicon glyphicon-ok-sign text-success" title="Completed"></span>' : ''?></td>
                        <?php if ( $isAdmin ) {?>
                            <td class="text-right"><a href="/main/edit?id=<?php echo $task['id']?>"><span class="glyphicon glyphicon-edit text-warning" title="Edit"></span></a></td>
                        <?php } ?>
                    </tr>
                <?php }
            } else {?>
                <td colspan="<?php echo $isAdmin ? '6' : '5'?>" class="text-center"><p>Task list is empty</p></td>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<?php if( $totalCount > $limit ) {
    $basePageUrl = '/main/index?order=' . $order . '&direction=' . $direction;
?>
    <div class="row">
        <div class="col-md-12 text-right">
            <nav>
                <ul class="pagination">
                    <li class="page-item <?php echo $pageNum == 1 ? 'disabled' : ''?>">
                        <a class="page-link" href="<?php echo $pageNum == 1 ? 'javascript://' : $basePageUrl . '&page_num=1'?>">
                            First
                        </a>
                    </li>
                    <li class="page-item <?php echo $pageNum == 1 ? 'disabled' : ''?>">
                        <a class="page-link" href="<?php echo $pageNum == 1 ? 'javascript://' : $basePageUrl . '&page_num=' . ($pageNum - 1)?>">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                    <?php

                    $startPage = $pageNum;
                    if( $pageCount - $pageNum < 2 ){
                        if( $pageCount - 2 <= 0) {
                            $startPage = 1;
                        } else {
                            $startPage = $pageCount - 2;
                        }
                    } else if( $pageNum > 1) {
                        $startPage = $pageNum - 1;
                    }

                    $endPage = $startPage + 2;
                    if( $endPage > $pageCount ) {
                        $endPage = $pageCount;
                    }

                    for ($i=$startPage; $i<=$endPage; $i++) {?>
                        <li class="page-item <?php echo $i == $pageNum ? 'active' : ''?>">
                            <a class="page-link" href="<?php echo $i == $pageNum ? 'javascript://' : $basePageUrl . '&page_num=' . $i;?>"><?php echo $i?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php echo $pageNum == $pageCount ? 'disabled' : ''?>">
                        <a class="page-link" href="<?php echo $pageNum == $pageCount ? 'javascript://' : $basePageUrl . '&page_num=' . ($pageNum + 1)?>">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                    <li class="page-item <?php echo $pageNum == $pageCount ? 'disabled' : ''?>">
                        <a class="page-link" href="<?php echo $pageNum == $pageCount ? 'javascript://' : $basePageUrl . '&page_num=' . $pageCount?>">
                            Last
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php } ?>