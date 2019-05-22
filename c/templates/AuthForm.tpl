<?php require_once 'header.tpl'; ?>

<div class="col-md-12" id="content">
    <h3 class="text-center">Авторизация</h3>
    <p class="text-center">(Регистрация возможна только через менеджера)</p>
    <p class="text-center alert-text"><?php if(isset($alertText)) echo $alertText; ?></p>
    <div class="col-md-12 b-auth ">
        <form class="form-horizontal" action="" method="POST">
            <div class="form-group">
                <label class="col-sm-2 control-label">Логин/email:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="email" placeholder="Введите email">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Пароль</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" placeholder="Введите пароль">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="cmd" value="_login">
                    <button type="submit" class="btn btn-default">Войти</button>
                    <button type="button" class="btn btn-default" onclick=" window.location = '/?cmd=registerPage'">Регистрация</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.tpl'; ?>

