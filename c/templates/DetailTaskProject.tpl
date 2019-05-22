<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">
    <?php if(isset($object)): ?>
    <?php if(  $object['id']  ): ?>
    <h3>Задача # <?php echo $object['id']; ?></h3>
    <?php endif; ?>
    <table class="table">
        <tr>
            <?php if( $object['title'] ): ?>
            <th>Тема:</th>
            <td><?php echo $object['title'];?></td>
            <?php endif; ?>
            <?php if( $object['performer'] ): ?>
            <th>Исполнитель:</th>
            <td><?php echo $object['performer']; ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['status'] ): ?>
            <th>Статус:</th>
            <td><?php echo $object['status'];?></td>
            <?php endif; ?>
            <?php if( $object['type'] ): ?>
            <th>Тип задачи:</th>
            <td><?php echo $object['type'];?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['assessment'] ): ?>
            <th>Время оценки:</th>
            <td><?php echo $object['assessment'];?> ч.</td>
            <?php endif; ?>
            <?php if( $object['lead_time'] ): ?>
            <th>Затраченное время:</th>
            <td><?php echo $object['lead_time'];?> ч.</td>
            <?php endif; ?>
        </tr>
        <?php if( c\core\User::granted( UP_MANAGER ) ): ?>
        <tr>
            <?php if( $object['links_fl'] ): ?>
            <th>Ссылка Fl.ru:</th>
            <td><a target="_blank" href="<?php echo $object['links_fl'] ?>">Ссылка на fl.ru</a></td>
            <?php endif; ?>
            <?php if( $object['correspondence_fl'] ): ?>
            <th>Ссылка на переписку Fl.ru:</th>
            <td><a target="_blank" href="<?php echo $object['correspondence_fl'] ?>">Ссылка на переписку</a></td>
            <?php endif; ?>
        </tr>
        <?php endif;?>
        <tr>
            <?php if( $object['test_platform'] ): ?>
            <th>Тестовая площадка:</th>
            <td><a target="_blank" href="<?php echo $object['test_platform'] ?>">Ссылка на пощадку</a></td>
            <?php endif; ?>
            <?php if( $object['links_backup'] ): ?>
            <th>Ссылка на backup:</th>
            <td><a target="_blank" href="<?php echo $object['links_backup'] ?>">Ссылка на backup</a></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['links_project'] ): ?>
            <th>Ссылка на проект:</th>
            <td><a target="_blank" href="<?php echo $object['links_project'] ?>">Ссылка на проект</a></td>
            <?php endif; ?>
            <?php if( $object['end_date'] ): ?>
            <th>Дата закрытия:</th>
            <td><?php echo date("d-m-Y | H:i", strtotime($object['end_date'])) ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['files'] ): ?>
            <th>Файлы:</th>
            <td>
                <?php foreach( $object['files'] as $key => $url): ?>
                <a download="" href="<?php echo $url ?>"><?php echo 'file_'.$key ?></a> |
                <?php endforeach; ?>
            </td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['description'] ): ?>
            <th colspan="1">Описание:</th>
            <td style="width: 300px" colspan="3">
                <?php echo $object['description']; ?>
            </td>
            <?php endif; ?>

        </tr>
    </table>
    <?php if( isset($comments) ): ?>
    <h4>Комментарии к задаче:</h4>
    <table class="table table-comments">
        <?php foreach( $comments as $comment ): ?>
        <tr>
            <td>
                <p>Написал: <?php echo $comment['author']; ?></p>
                <p style="font-size: 80%">Дата: <?php echo $comment['date']; ?></p>
            </td>
        </tr>
        <tr>
            <td><?php echo $comment['comment'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <?php if( !$object['closed'] ): ?>
    <table class="table">
        <tr>
            <td>
                <button type="button" class="btn btn-default" rel="" data-toggle="tooltip" title="Обновить" onclick="window.location='/?cmd=getUserTask&id=<?=$object["id"]?>&act=edit'" ><span class="glyphicon glyphicon-pencil"></span></button>
                <button type="button" class="btn btn-default" rel="" data-toggle="tooltip" title="назад" onclick="window.location='/?cmd=allProjects'"><span class="glyphicon glyphicon-arrow-left"></span></button>
                <?php if( c\core\User::granted( UP_MANAGER ) ): ?>
                <button type="button" class="btn btn-default button-delete" rel="" data-toggle="tooltip" title="удалить" onclick=" if( confirm('Вы уверены ?') ) window.location='/?cmd=getUserTask&id=<?=$object["id"]?>&act=del'"><span class="glyphicon glyphicon-remove"></span></button>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <?php else: ?>
    <table class="table">
        <tr>
            <td>
                <button type="button" class="btn btn-default" rel="" title="назад" onclick="window.location='/?cmd=allProjects&act=closed'"><span class="glyphicon glyphicon-arrow-left"></span></button>
            </td>
        </tr>
    </table>
    <?php endif; ?>
    <?php else: ?>
    <h1 class="text-center">ПО ЭТОЙ ЗАДАЧЕ НЕТ ДАННЫХ.</h1>
    <?php endif; ?>
</div>
<?php require_once 'footer.tpl'; ?>