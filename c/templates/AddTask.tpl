<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">
    <h3>Создание Задачи</h3>
    <form method="POST" action="" class="form-addTask-js" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <th>Тема:</th>
                <td>
                    <input class="form-control" type="text" name="title">
                </td>
            </tr>
            <?php if( isset( $items['status'] )): ?>
            <tr>
                <th>Статус:</th>
                <td>
                    <select class="form-control" name="status">
                        <?php foreach( $items['status'] as $id => $status ): ?>
                            <option value="<?php echo $id; ?>"><?php echo $status; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>Исполнитель:</th>
                <td>
                    <select class="form-control" name="performer">
                        <option value="0">Без исполнителя</option>
                        <?php foreach( $items['performer'] as $id => $performer ): ?>
                        <option value="<?php echo $id; ?>"><?php echo $performer; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Тип задачи:</th>
                <td>
                    <select class="form-control" name="type">
                        <?php foreach( $items['type'] as $id => $type ): ?>
                        <option value="<?php echo $id; ?>"><?php echo $type; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Приоритет:</th>
                <td>
                    <select class="form-control" name="priority">
                        <?php foreach( $items['priority'] as $id => $priority ): ?>
                        <option value="<?php echo $id; ?>"><?php echo $priority; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Ссылка Fl.ru:</th>
                <td><input type="text" class="form-control" name="links_fl" ></td>
            </tr>
            <tr>
                <th>Ссылка на переписку Fl.ru:</th>
                <td><input type="text" class="form-control" name="correspondence_fl"></textarea></td>
            </tr>
            <tr>
                <th>Тестовая площадка:</th>
                <td><input type="text" class="form-control" name="test_platform"></td>
            </tr>
            <tr>
                <th>Ссылка на проект ( сайт ):</th>
                <td><input type="text" class="form-control" name="links_project"></td>
            </tr>
            <tr>
                <th>Ссылка Backup:</th>
                <td><input type="text" class="form-control" name="links_backup"></td>
            </tr>
            <tr>
                <th>Описание:</th>
                <td><textarea class="form-control" name="description" rows="10" cols="50"></textarea></td>
            </tr>
            <tr>
                <th>Загрузить файл (multi):</th>
                <td><input multiple="true" type="file" name="file[]"> </td>
            </tr>
            <tr>
                <input type="hidden" name="cmd" value="_addNewTask">
                <input type="hidden" name="act" value="add">
                <td><button type="submit" class="btn btn-default">Создать</button></td>
            </tr>
        </table>
    </form>
</div>
<script src="/c/libs/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
<?php require_once 'footer.tpl'; ?>