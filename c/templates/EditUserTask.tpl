<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">

    <?php if( isset( $object['id'] ) ): ?>
        <h3>Задача # <?php echo $object['id']; ?></h3>
    <?php endif; ?>
    <table class="table">
        <tr>
            <?php if( $object['title'] ): ?>
            <th>Тема:</th>
            <td><?php echo $object['title'];?></td>
            <?php endif; ?>
            <?php if( $object['manager'] ): ?>
            <th>Менеджер:</th>
            <td><?php echo $object['manager']; ?></td>
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
        <tr>
            <?php if( $object['links_fl'] ): ?>
            <th>Ссылка Fl.ru:</th>
            <td><a target="_blank" href="<?php echo $object['links_fl'] ?>">Ссылка на проект</a></td>
            <?php endif; ?>
            <?php if( $object['correspondence_fl'] ): ?>
            <th>Ссылка на переписку Fl.ru:</th>
            <td><a target="_blank" href="<?php echo $object['correspondence_fl'] ?>">Ссылка на проект</a></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['test_platform'] ): ?>
            <th>Тестовая площадка:</th>
            <td><a target="_blank" href="<?php echo $object['test_platform'] ?>">Ссылка на проект</a></td>
            <?php endif; ?>
            <?php if( $object['links_backup'] ): ?>
            <th>Ссылка на backup:</th>
            <td><a target="_blank" href="<?php echo $object['links_backup'] ?>">Ссылка на проект</a></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if( $object['priority'] ): ?>
            <th>Приоритет:</th>
            <td><?php echo $object['priority']; ?></td>
            <?php endif; ?>

            <?php if( $object['links_project'] ): ?>
            <th>Ссылка на проект:</th>
            <td><a target="_blank" href="<?php echo $object['links_project'] ?>">Ссылка на проект</a></td>
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
    <hr class="hr">
    <h4>Редактирование задачи</h4>
    <form method="POST" action="" class="form-updateTask-js" enctype="multipart/form-data">
        <table class="table">

            <tr>
                <th>Исполнитель:</th>
                <td>
                    <select class="form-control" name="performer">

                        <?php if( c\core\User::granted( UP_MANAGER ) ): ?>
                            <option value="0">Без исполнителя</option>
                        <?php endif; ?>

                        <?php foreach( $items['performer'] as $id => $performer ): ?>
                        <option <?php if( $object['performer'] == $id ):?>selected<?php endif; ?> value="<?php echo $id; ?>" ><?php echo $performer ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php if(isset($items['status'])): ?>
            <tr>
                <th>Статус:</th>
                <td>
                    <select class="form-control" name="status">
                        <?php foreach( $items['status'] as $id => $status):?>
                        <option <?php if( $object['status'] == $status ):?>selected<?php endif; ?> value="<?php echo $id; ?>" ><?php echo $status ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <?php endif; ?>

            <?php if(c\core\User::granted( UP_MANAGER )): ?>

            <tr>
                <th>Тема:</th>
                <td>
                    <input class="form-control" type="text" name="title" value="<?php if( isset( $object['title'] ) ) echo $object['title']  ?>">
                </td>
            </tr>
            <tr>
                <th>Тип задачи:</th>
                <td>
                    <select class="form-control" name="type">
                        <?php foreach( $items['type'] as $id => $type ): ?>
                        <option <?php if( $object['type'] == $type ):?>selected<?php endif; ?> value="<?php echo $id; ?>" ><?php echo $type ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Приоритет:</th>
                <td>
                    <select class="form-control" name="priority">
                        <?php foreach( $items['priority'] as $id => $priority ): ?>
                        <option <?php if( $object['priority'] == $priority ):?>selected<?php endif; ?> value="<?php echo $id; ?>" ><?php echo $priority ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Ссылка Fl.ru:</th>
                <td><input type="text" class="form-control" name="links_fl" value="<?php if( isset( $object['links_fl'] ) ) echo $object['links_fl']  ?>" ></td>
            </tr>
            <tr>
                <th>Ссылка на переписку Fl.ru:</th>
                <td><input type="text" class="form-control" name="correspondence_fl" value="<?php if( isset( $object['correspondence_fl'] ) ) echo $object['correspondence_fl'] ?>" ></td>
            </tr>
            <tr>
                <th>Тестовая площадка:</th>
                <td><input type="text" class="form-control" name="test_platform" value="<?php if( isset( $object['test_platform'] ) ) echo $object['test_platform'] ?>" ></td>
            </tr>
            <tr>
                <th>Ссылка backup:</th>
                <td><input type="text" class="form-control" name="links_backup" value="<?php if( isset( $object['links_backup'] ) ) echo $object['links_backup'] ?>" ></td>
            </tr>
            <tr>
                <th>Ссылка на проект:</th>
                <td><input type="text" class="form-control" name="links_project" value="<?php if( isset( $object['links_project'] ) ) echo $object['links_project'] ?>" ></td>
            </tr>
            <tr>
                <th>Загрузить файл (multi):</th>
                <td><input multiple="true" type="file" name="file[]"> </td>
            </tr>

            <tr>
                <th>Описание:</th>
                <td><textarea class="form-control" name="description" rows="10" cols="50"> <?php if( isset( $object['description'] ) ) echo $object['description'] ?> </textarea></td>

            </tr>

            <?php endif; ?>

            <tr>
                <th>Время оценки (ч.):</th>
                <td><input class="form-control" type="text" name="assessment" value="<?php if( $object['assessment'] ) echo $object['assessment']; ?>"></td>
            </tr>
            <tr>
                <th>Комментарий:</th>
                <td><textarea class="form-control" name="comment"></textarea></td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="cmd" value="getUserTask">
                    <input type="hidden" name="act" value="save">
                    <button type="submit" class="btn btn-default" data-toggle="tooltip" title="отправить"><span class="glyphicon glyphicon-send"></span></button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" title="назад" onclick="history.back()"><span class="glyphicon glyphicon-arrow-left"></span></button>
                </td>
            </tr>
        </table>
    </form>
</div>
<script src="/c/libs/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('comment');

    var desc = $("textarea[name='description']");
    if(  desc && desc.val() !== undefined )
        CKEDITOR.replace( 'description' );
</script>
<?php require_once 'footer.tpl'; ?>