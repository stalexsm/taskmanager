<?php

/// Уровни пользователей
//// User Policy

define('UP_PUBLIC',             10);    // Неавторизованный пользователь
define('UP_TV',                 100);   // Телевизор общего пользования
define('UP_SPECIALIST',         201);   // Специалист
define('UP_MANAGER',            301);   // Менеджер
define('UP_DEP_MANAGER',        401);   // Руководитель менеджеров
define('UP_DIRECTOR',           701);   // Руководитель предприятия
define('UP_SYS',                1009);  // Супер пользователь

//// Уровни действий
//// Action Policy

//// App

// Действия
define('AP__login',                     UP_PUBLIC);
define('AP__logout',                    UP_PUBLIC);
define('AP__register',                  UP_PUBLIC);
define('AP__approve',                   UP_SPECIALIST);
define('AP__getDataFilter',             UP_SPECIALIST);
define('AP__editDetailTaskWork',        UP_SPECIALIST);
define('AP__addNewTask',                UP_MANAGER);
define('AP__editUsers',                 UP_SYS);

// Чтение
define('AP_indexPage',                  UP_PUBLIC);
define('AP_registerPage',               UP_PUBLIC);
define('AP_showMain',                   UP_SPECIALIST);
define('AP_allProjects',                UP_SPECIALIST);
define('AP_getUserTask',                UP_SPECIALIST);


