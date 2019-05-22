<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">
    <?php if( $objects ): ?>
    <h3>Все задачи менеджера ( <?php echo $count; ?> ) </h3>
    <table class="project-sort">
        <tr>
            <td><b>Сортировать: </b></td>
            <?php foreach( $showSort as $sort): ?>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td><a href="<?php echo $sort['href']; ?>" title="<?php echo $sort['title']; ?>"><span class="<?php echo $sort['span']; ?>"></span></a></td>
            <?php endforeach; ?>
        </tr>
    </table>
    <table class="filter-table">
        <tr>
            <td><a href="" data-toggle="modal" data-target=".filter-modal" ><span class="glyphicon glyphicon-filter"></span> </a></td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <th>#</th>
            <th>Проект</th>
            <th>Статус</th>
            <th>Тип задачи</th>
            <th>Приоритет</th>
            <th>Исполнитель</th>
            <th>Дата добавления</th>
        </tr>
        <?php foreach($objects as $object): ?>
        <tr>
            <td><a href="/?cmd=allProjects&id=<?php echo $object['id']; ?>" >#<?php echo $object['id']; ?><a></a></td>
            <td><a href="/?cmd=allProjects&id=<?php echo $object['id']; ?>" ><?php echo $object['title']; ?></a></td>
            <td><?php echo $object['status']; ?></td>
            <td><?php echo $object['type']; ?></td>
            <td><?php echo $object['priority']; ?></td>
            <td><?php echo $object['performer']; ?></td>
            <td><?php echo date("d-m-Y | H:i", strtotime($object['begin_date'])); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr></tr>
    </table>
    <hr>
    <p>Всего добавленных задач: <b><?php echo $count; ?></b></p>

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
<h1 class="text-center"> <?php echo $text ?></h1>
<?php endif; ?>
<?php require_once 'footer.tpl'; ?>

<div class="modal fade filter-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content filter-content">
            <div class="filter">
                <h2 class="text-center">Фильтр</h2>
                <div>
                    <h4>Тип задачи:</h4>
                    <?php foreach( $types as $id => $type ): ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="type" value="<?php echo $id ?>"> <?php echo $type ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="btn btn-default" type="button" id="filter-js">Фильтр</button>
                </div>
            </div>
        </div>
    </div>
</div>
