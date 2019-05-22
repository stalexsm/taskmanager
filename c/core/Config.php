<?php

//параметрф для подключения ДБ.
define( 'HOST_DB', 'mysql:host=localhost;dbname=task_manager_db;charset=UTF8' );
define( 'USER_DB', 'root' );
define( 'PASSWD_DB', '' );

// Данные
if ( !isSet( $_SERVER[ 'HTTP_HOST' ] ) ) $_SERVER[ 'HTTP_HOST' ] = '';
define( 'WEBROOTPATH', $_SERVER[ 'HTTP_HOST' ] . '/' );

// Email для отправки писем.
define( 'NOREPLAY_EMAIL', 'no-reply@' . str_replace( '/', '', WEBROOTPATH ) );
//Email Администратора, разработчик.
define( 'ADM_EMAIL', 'starovoitov85@yandex.ru' );

// количество выводимых задач на странице.
define( 'PERPAGE', 20 );

// Выключение системы
define( 'CLOSED', false );
