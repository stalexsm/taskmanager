<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">
<?php if(isset($object)): ?>
    <?php if( isset( $object['id'] ) ): ?>
        <h3>Задача # <?php echo $object['id']; ?></h3>
        <span class="pId" pid="<?php echo $object['id']; ?>"></span>
    <?php endif; ?>
    <table class="table">
        <tr>
            <?php if( isset($object['title']) ): ?>
                <th>Тема:</th>
                <td><?php echo $object['title'];?></td>
            <?php endif; ?>
            <?php if( isset($object['manager']) ): ?>
                <th>Менеджер:</th>
                <td><?php echo $object['manager']; ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( isset($object['status']) ): ?>
                <th>Статус:</th>
                <td><?php echo $object['status'];?></td>
            <?php endif; ?>
            <?php if( isset($object['type']) ): ?>
                <th>Тип задачи:</th>
                <td><?php echo $object['type'];?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['links_project'] ): ?>
                <th>Ссылка на проект:</th>
                <td><a target="_blank" href="<?php echo $object['links_project'] ?>">Ссылка на проект</a></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( isset($object['description']) ): ?>
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
        <table class="table">
        <tr>
            <td>&nbsp;</td>
            <td>
                <div>
                    <button type="submit" class="btn btn-default confirm-js" rel="approve" data-toggle="tooltip" title="Забрать проект"><span class="glyphicon glyphicon-download-alt"></span></button>
                    <button type="button" class="btn btn-default confirm-js" rel="" data-toggle="tooltip" title="Вернуться к списку" onclick="window.location='/'"><span class="glyphicon glyphicon-arrow-left"></span></button>
                </div>
            </td>
        </tr>
    </table>
<?php else: ?>
    <h1 class="text-center">ПО ЭТОЙ ЗАДАЧЕ НЕТ ДАННЫХ.</h1>
<?php endif; ?>
</div>
<?php require_once 'footer.tpl'; ?>