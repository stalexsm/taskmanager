<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">
    <?php if(isset($objects)): ?>
    <h3>Новые задачи без исполнителей ( <?php echo $count; ?> ) </h3>
    <table class="table">
        <tr>
            <th>#</th>
            <th>Проект</th>
            <th>Статус</th>
            <th>Тип задачи</th>
            <th>Приоритет</th>
            <th>Менеджер</th>
            <th>Дата добавления</th>
        </tr>
        <?php foreach($objects as $object): ?>
        <tr>
            <td><a href="/?cmd=showMain&id=<?php echo $object['id']; ?>" >#<?php echo $object['id']; ?></a></td>
            <td><a href="/?cmd=showMain&id=<?php echo $object['id']; ?>" ><?php echo $object['title']; ?></a></td>
            <td><?php echo $object['status']; ?></td>
            <td><?php echo $object['type']; ?></td>
            <td><?php echo $object['priority']; ?></td>
            <td><?php echo $object['manager']; ?></td>
            <td><?php echo date("d-m-Y", strtotime($object['begin_date'])); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr></tr>
    </table>
    <hr>
    <p>Всего новых задач: <b><?php echo $count; ?></b></p>

</div>

<?php if( $pagination['page_count'] > 1 ): ?>

<div id="pagination">
    <ul class="pagination">
        <li><a href="/?page=1">&laquo;</a></li>
        <?php if($pagination['page'] > 1): ?>
        <li><a href="/?page=<?php echo $pagination['page'] - 1;?>"><?php echo $pagination['page'] - 1;?></a></li>
        <?php endif; ?>
        <li class="active"><a href="#"><?php echo $pagination['page'];?></a></li>
        <?php if($pagination['page'] < $pagination['page_count']): ?>
        <li><a href="/?page=<?php echo $pagination['page'] + 1;?>"><?php echo $pagination['page'] + 1;?></a></li>
        <?php endif ?>
        <li><a href="/?page=<?php echo $pagination['page_count']?>">&raquo;</a></li>
    </ul>
</div>

<?php endif; ?>
<?php else: ?>
<h1 class="text-center"> НА ДАННЫЙ НЕТ НОВЫХ ЗАДАЧ.</h1>
<?php endif; ?>
<?php require_once 'footer.tpl'; ?>