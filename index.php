<?php

use c\core\C;
use c\core\Connect;
use c\classes\UserAuth;
use c\classes\App;

session_start();
require_once ( __DIR__. '/c/bootstrap.php' );


//Установим заголовки.
header( "HTTP/1.1 200" );
header( "Status: 200 OK" );
header( 'Content-Type: text/html;  charset=utf-8' );

UserAuth::loadDefaultPolicy();

$app = new App();

// Флаг для отключения системы.
if( CLOSED ) $app->goHeader( 'closed.html' );

$app->init();
$app->execute( C::getStr( 'cmd','indexPage' ) );
$app->render();

exit;
