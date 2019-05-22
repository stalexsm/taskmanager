<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">
    <h3>Пользователи</h3>
    <form method="POST" action="">
        <table class="table">
            <?php if($users ): ?>
            <?php foreach( $users as $user ):?>
                <tr>
                    <td>
                        <div><?php echo $user['username'] ?></div>
                    </td>
                    <td>
                        <div style="float: right">
                            <a class="btn btn-default" href="/?cmd=_editUsers&active=policy&id=<?php echo $user['id'] ?>" role="button">Политика</a>
                            <a class="btn btn-default" href="/?cmd=_editUsers&active=edit&id=<?php echo $user['id'] ?>">Изменить</a>
                            <a class="btn btn-default" href="/?cmd=_editUsers&active=delete&id=<?php echo $user['id'] ?>">Удалить</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </form>
</div>
<?php require_once 'footer.tpl'; ?>