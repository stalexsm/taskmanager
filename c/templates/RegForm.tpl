<?php require_once 'header.tpl'; ?>

<div class="col-md-12" id="content">
    <h3>Регистрация</h3>
    <form method="POST" action="" class="form-registration-js">
        <?php if(isset( $alertText )): ?><p class="text-danger text-center"><?= $alertText ?></p><?php endif ?>
        <table class="table">
            <tr>
                <th>Логин/email:</th>
                <td>
                    <input class="form-control" type="text" name="email" placeholder="Введите email">
                </td>
            </tr>
            <tr>
                <th>Имя:</th>
                <td>
                    <input class="form-control" type="text" name="firstname" placeholder="Введите имя ">
                </td>
            </tr>
            <tr>
                <th>Фамилия:</th>
                <td>
                    <input class="form-control" type="text" name="lastname" placeholder="Введите Фамилию ">
                </td>
            </tr>
            <tr>
                <th>Пароль:</th>
                <td>
                    <input class="form-control" type="password" name="pass" placeholder="Введите пароль">
                </td>
            </tr>
            <tr>
                <th>Повторите пароль:</th>
                <td>
                    <input class="form-control" type="password" name="pass_replay" placeholder="Введите пароль">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="cmd" value="_register">
                    <button type="submit" class="btn btn-default" >Отправить</button>
                    <button type="button" class="btn btn-default" onclick="window.location='/'">Назад</button>
                </td>
            </tr>

        </table>
    </form>
</div>

<?php require_once 'footer.tpl'; ?>