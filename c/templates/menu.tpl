<div class="col-md-12" id="nav">

    <?php if(isset($menuModule)) :?>
    <ul class="nav nav-pills">
        <?php foreach($menuModule as $menu): ?>
        <?php if(c\core\User::granted($menu['policy'])) : ?>
            <?php if( $menu['items'] ): ?>
                <li class="dropdown">
                    <a href="<?=$menu['href'];?>" class="btn btn-default dropdown-toggle" data-toggle="dropdown"  role="button"><?=$menu['title'];?> <span class="caret"></span> </a>
                    <ul class="dropdown-menu">
                        <?php foreach( $menu['items'] as $submenu ): ?>
                            <?php if(c\core\User::granted($submenu['policy'])) : ?>
                                <li>
                                    <a href="<?php echo $submenu['href'] ?>"><?php echo $submenu['title'] ?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </li>

            <?php else: ?>
                <li>
                    <a href="<?=$menu['href'];?>" class="btn btn-default"><?=$menu['title'];?></a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <?php endif ;?>



    <div class='helloAuth'>
        <?php if(isset($user)): ?>
            <span>Здравствуйте, <b><?php echo $user ?></b> </span>&nbsp;
            <a class="btn btn-default" href="/?cmd=_logout" data-toggle="tooltip" title="выход" role="button"><span class="glyphicon glyphicon-off"></span></a>
        <?php endif; ?>
    </div>
</div>