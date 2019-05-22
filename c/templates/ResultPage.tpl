<?php require_once 'header.tpl'; ?>

    <div class="col-md-12" id="content">
        <div class="text-center"><h1><?= $answer ?></h1></div>
        <div class="text-center"><?php if(isset($text)): ?><p><?= $text ?></p><?php endif ?></divp>
        <div class="text-center"><?php if(isset( $alertText )): ?><p class="text-danger"><?= $alertText ?></p><?php endif ?></div>
        <button style="margin-bottom: 15px" type="button" class="btn btn-default" onclick='window.location ="/"'>Назад</button>
    </div>

<?php require_once 'footer.tpl'; ?>