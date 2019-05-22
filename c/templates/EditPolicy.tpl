<?php require_once 'header.tpl'; ?>

<?php require_once 'menu.tpl'; ?>

<div class="col-md-12" id="content">
    <h3>Пользователи</h3>
    <form method="POST" action="">
        <table class="table">
            <?php if( $item ): ?>
            <tr>
                <td>
                    <div>Политика доступа => <?php echo $item['username'] ?></div>
                </td>
                <td>
                    <input class="form-control" type="text" name="policy" value="<?php echo $item['group_policy'] ?>">
                </td>
                <td>
                    <button type="submit" class="btn btn-default">Подтвердить</button>
                    <button type="button" class="btn btn-default" onclick="window.location = '/?cmd=_editUsers'">Назад</button>
                </td>
            </tr>
            <?php endif; ?>
        </table>
    </form>
</div>
<?php require_once 'footer.tpl'; ?>