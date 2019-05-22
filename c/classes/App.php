<?php
namespace c\classes;

use c\core\C;
use c\core\DB;
use c\core\File;
use c\core\Mailer;
use c\core\Parameters;
use c\core\User;

class App extends Prototype
{

    /**
     * @return bool|void
     */
    public function indexPage()
    {
        // Если авторизованы - отрабатываем интерфейсное состояние по-умолчанию
        if ( User::granted( AP_showMain ) ) return $this->execute( 'showMain' );
        // Если авторизованы под минимальной политикой - выводим сообщение
        if ( User::granted( UP_TV ) ) {
            $this->setTemplate( "ResultPage.tpl" );
            $this->setData( 'answer', 'Регистрация прошла успешно' );
            $this->setData( 'text', 'Обратитесь к администратору starovoitov85@yandex.ru для установки привелений.' );

            return true;
        }
        // иначе отрабатываем форму авторизации
        $this->setTemplate( "AuthForm.tpl" );

        return true;
    }

    /**
     *  Метод для отображения формы регистрации.
     */
    public function registerPage()
    {
        $this->setTemplate( 'RegForm.tpl' );
        $this->setData( 'render', 1 );
    }

    /**
     * Метод для авторизации.
     */
    public function _login()
    {
        if ( !UserAuth::auth( C::getStr( 'email' ), C::getStr( 'password' ) ) )
            $this->setData( 'alertText', 'Пара логин и пароль не подходят.' );

        $this->execute( 'indexPage' );
    }

    /**
     * Метод для выхода из авторизации.
     */
    function _logout()
    {
        UserAuth::logout();
        $this->execute( 'indexPage' );
    }

    public function _register()
    {
        $user = UserAuth::getTaskManagerUserByLogin( C::getStr( 'email' ) );
        if ( $user and isset( $user[ 'id' ] ) and User::getPolicy() < UP_SYS ) {
            $alertText = 'Логин/email ' . htmlspecialchars( C::getStr( 'email' ) ) . ' уже существует. Для смены пароля обратитесь к администратору.';
            $this->setData( 'alertText', $alertText );

            return $this->execute( 'registerPage' );
        } else {
            if ( C::getStr( 'pass', '#67' ) != C::getStr( 'pass_replay', '********' ) ) {
                $alertText = 'Извините, но пароли не совпадают. Попробуем еще.';
                $this->setData( 'alertText', $alertText );

                return $this->execute( 'registerPage' );
            }
            UserAuth::addUserTaskManager( C::getStr( 'email' ), C::getStr( 'pass' ) );
            $this->setData( 'answer', 'Регистрация прошла успешно' );
            $this->setData( 'text', 'Обратитесь к администратору starovoitov85@yandex.ru для установки привелегий.' );
            $this->setTemplate( 'ResultPage.tpl' );
        }
    }

    public function showMain()
    {
        /** @var  $page */
        $page = C::getStr( 'page', 1 );
        /** @var  $id */
        $id = C::getInt( 'id' );
        if ( isset( $id ) && $id !== 0 ) {
            $this->setTemplate( 'DetailWork.tpl' );
            /** @var  $object */
            $object = [ ];
            $menu = new ModuleMenu();
            $this->setData( 'menuModule', $menu->data );

            /** @var  array() $comments комментарии */
            $comments = [];

            if ( User::granted( UP_SPECIALIST ) ) {
                $object = TaskApi::getObjectById( $id );
                $comments = TaskApi::getCommentsID( $id );
            }

            if ( $object ) $this->setData( 'object', $object );
            if ( $comments ) $this->setData( 'comments', $comments );

        } else {

            /** @var  $menu */
            $menu = new ModuleMenu();
            $this->setData( 'menuModule', $menu->data );

            $objects = TaskApi::getObjects( $page, PERPAGE );

            /** @var  $count */
            $count = TaskApi::countTask();
            $page_count = ceil( $count / (int)PERPAGE );

            // Сделаем защиту от несуществующих страниц.
            if ( $page < 1 ) $page = 1;
            if ( $page > $page_count ) $page = $page_count;

            /** @var  $pagination */
            $pagination = [
                'page_count' => $page_count,
                'page' => (int)$page,
            ];

            if ( $objects ) $this->setData( 'objects', $objects );
            if ( $count ) $this->setData( 'count', $count );
            if ( $pagination ) $this->setData( 'pagination', $pagination );
        }
        $this->setData( 'user', $_SESSION[ UserAuth::$userData ][ 'username' ] );
    }

    /**
     * Метод для работы с зарезервироваными задачами за пользователем.
     */
    public function getUserTask()
    {
        /** @var  $page */
        $page = C::getStr( 'page', 1 );
        /** @var  $id */
        $id = C::getInt( 'id' );
        $menu = new ModuleMenu();
        $this->setData( 'menuModule', $menu->data );

        $status = Parameters::getStatus();

        // todo временный способ ограничить специалиста статусами.
        if( User::granted( UP_SPECIALIST, UP_MANAGER ) )
        {
            $statusSpecialist = [];
            foreach( Parameters::$allowedSpecialist as $key )
            {
                if( array_key_exists( $key, $status ) ) $statusSpecialist[$key] = $status[$key];
            }
            $status = $statusSpecialist;
        }

        $items = [
            'status' => $status,
            'type' => Parameters::getType(),
            'priority' => Parameters::getPriority(),
            'performer' => Parameters::getPerformer(),
        ];

        $files = File::getFilesId( $id );

        if ( isset( $id ) && $id !== 0 ) {
            /** @var  $act */
            $act = C::getStr( 'act' );

            /** @var  $object */
            $object = TaskApi::getObjectById( $id );

            switch ( $act ) {

                case 'edit':
                    /** @var  $template string шаблон */
                    $this->setTemplate( 'EditUserTask.tpl' );
                    $menu = new ModuleMenu();
                    $this->setData( 'menuModule', $menu->data );
                    $this->setData( 'items', $items );
                    if( $files )
                        $object['files'] = $files;
                    if ( $object ) $this->setData( 'object', $object );

                    break;

                case 'save':

                    $title = C::getStr( 'title' );
                    $performer = C::getInt( 'performer' );
                    $type = C::getInt( 'type' );
                    $priority = C::getInt( 'priority' );
                    $linksFl = C::getStr( 'links_fl' );
                    $linkProject = C::getStr( 'correspondence_fl' );
                    $correspondenceFl = C::getStr( 'links_project' );
                    $testPlatform = C::getStr( 'test_platform' );
                    $linksBackup = C::getStr( 'links_backup' );
                    $description = C::getStr( 'description' );
                    $status = C::getInt( 'status' );
                    $assessment = C::getInt( 'assessment' );
                    $comment = C::getStr( 'comment' );

                    if ( User::granted( UP_SPECIALIST, UP_MANAGER ) ) {
                        TaskApi::detailUpdateTask( $id, $status, $assessment, $performer, $comment );
                    }

                    if ( User::granted( UP_MANAGER ) )
                    {

                        $tmpFiles = File::uploadFile( $id, $_FILES[ 'file' ] );
                        // #todo временное обновление файлов к задаче, нужно оптимизировать ( сделать по человечески ).
                        if( $tmpFiles )
                        {
                            foreach( $tmpFiles as $file )
                            {
                                if( $files )
                                {
                                    $files[] = $file;
                                    File::updateFilesTask( $id, $files );
                                } else {
                                    $files[] = $file;
                                    File::setFilesTask( $id, $files );
                                }
                            }

                        }

                        TaskApi::detailUpdateTaskManager(
                            $id,
                            $title,
                            $performer,
                            $type,
                            $priority,
                            $linksFl,
                            $correspondenceFl,
                            $linkProject,
                            $testPlatform,
                            $linksBackup,
                            $description,
                            $status,
                            $assessment,
                            $comment );

                        if ( $performer && $performer != 0 ) {
                            $email = UserAuth::getEmailById( $performer );
                            $title = strip_tags( $title );
                            $description = strip_tags( $description );

                            $subject = 'За вами закреплена задача.';
                            $msg = "За вами закреплена в системе Task Manager задача.\r\n\r\nЗадача № {$id}.\r\nТема: {$title}\r\nОписание:\r\n{$description}";
                            $mailer = new Mailer();
                            $mailer->sendMail( $email, NOREPLAY_EMAIL, $subject, $msg );

                        }
                    }

                    $email = UserAuth::getEmailById( $object['manager_id'] );
                    $title = strip_tags( $title );
                    $description = strip_tags( $description );

                    $subject = 'Изменение задачи.';
                    $msg = "Была изменина созданная вами задача.\r\nЗадача № {$id}.\r\nТема: {$title}\r\nОписание:\r\n{$description}";
                    $mailer = new Mailer();
                    $mailer->sendMail( $email, NOREPLAY_EMAIL, $subject, $msg );

                    $act = 'view';
                    break;

                case'del':
                    TaskApi::deleteTask( $id );
                    $this->goHeader( '?cmd=allProjects' );
                    break;
            }

            switch ( $act ) {
                case 'view':
                    /** @var  $template string шаблон */
                    $this->setTemplate( 'DetailTask.tpl' );
                    $menu = new ModuleMenu();
                    $this->setData( 'menuModule', $menu->data );

                    $object = TaskApi::getObjectById( $id );
                    $comments = TaskApi::getCommentsID( $id );

                    //докиним файлы в объект
                    if( $files )
                        $object['files'] = $files;

                    if ( $object ) $this->setData( 'object', $object );
                    if ( $comments ) $this->setData( 'comments', $comments );
                    break;
            }
        } else {
            /** @var  $template string  шаблон */
            $this->setTemplate( 'Work.tpl' );

            $objects = TaskApi::getObjects( $page, PERPAGE, $_SESSION[ UserAuth::$userData ][ 'id' ] );

            /** @var  $count */
            $count = TaskApi::countTask( $_SESSION[ UserAuth::$userData ][ 'id' ] );
            $page_count = ceil( $count / (int)PERPAGE );

            // Сделаем защиту от несуществующих страниц.
            if ( $page < 1 ) $page = 1;
            if ( $page > $page_count ) $page = $page_count;

            /** @var  $pagination */
            $pagination = [
                'page_count' => $page_count,
                'page' => (int)$page,
            ];

            if ( $objects ) $this->setData( 'objects', $objects );
            if ( $count ) $this->setData( 'count', $count );
            if ( $pagination ) $this->setData( 'pagination', $pagination );
        }
        $this->setData( 'user', $_SESSION[ UserAuth::$userData ][ 'username' ] );
    }

    /**
     * Метод для работы с вкладкой Проеты.
     */
    public function allProjects()
    {
        /** @var  $page */
        $page = C::getStr( 'page', 1 );
        $id = C::getInt( 'id' );

        $this->setTemplate( 'Projects.tpl' );
        $menu = new ModuleMenu();
        $this->setData( 'menuModule', $menu->data );

        if ( isset( $id ) && $id !== 0 ) {
            $this->setTemplate( 'DetailTaskProject.tpl' );
            $object = TaskApi::getObjectByIdPerformer( $id );
            $comments = TaskApi::getCommentsID( $id );
            $files = File::getFilesId( $id );

            if ( is_null($object[ 'performer' ] ) ) $object[ 'performer' ] = 'Нет исполнителя';
            // todo Мне не очень нравится, но приведем к целому числу, для проверки есть дата или нет.
            if ( !(int)$object[ 'end_date' ] ) unset( $object[ 'end_date' ] );

            // добавим файлы в объект
            if( $files )
                $object[ 'files' ] =  $files;

            $this->setData( 'object', $object );
            if ( $comments ) $this->setData( 'comments', $comments );

        } else {

            $order = C::getStr( 'order', 'priority_id' );
            $act = C::getStr( 'act' );
            $showSort = SortApi::$showSort;

            if( $act ) {
                $objects = TaskApi::getAllObjectsManager( $page, PERPAGE, $_SESSION[ UserAuth::$userData ][ 'id' ], $order, 1 );

                $showSort = SortApi::addParamUrl( 'act', 'closed' );

                $text = 'У ВАС НЕТ ЗАКРЫТЫХ ЗАДАЧ ';
                $count = TaskApi::countTaskManager( $_SESSION[ UserAuth::$userData ][ 'id' ], 1 );

            } else {

                $objects = TaskApi::getAllObjectsManager( $page, PERPAGE, $_SESSION[ UserAuth::$userData ][ 'id' ], $order );

                $text = 'ВЫ НЕ ДОБАВИЛИ НЕ ОДНОЙ ЗАДАЧИ.';
                $count = TaskApi::countTaskManager( $_SESSION[ UserAuth::$userData ][ 'id' ] );
            }

            if ( $objects ) {
                foreach ( $objects as &$object ) {
                    if ( is_null($object[ 'performer' ] ) ) $object[ 'performer' ] = 'Нет исполнителя';
                }
            }

            if( $count ) $this->setData( 'count', $count );
            $this->setData( 'showSort', $showSort );
            $this->setData( 'types', Parameters::getType() );
            $this->setData( 'text', $text );
            $this->setData( 'objects', $objects );
            $this->setData( 'user', $_SESSION[ UserAuth::$userData ][ 'username' ] );
        }
    }

    public function _addNewTask()
    {
        $act = C::getStr( 'act' );
        switch ( $act ) {
            case'add':

                $title = C::getStr( 'title' );
                $status = C::getInt( 'status' );
                $performer = C::getInt( 'performer' );
                $type = C::getInt( 'type' );
                $priority = C::getInt( 'priority' );
                $linkFl = C::getStr( 'links_fl' );
                $correspondenceFl = C::getStr( 'correspondence_fl' );
                $linksProject = C::getStr( 'links_project' );
                $testPlatform = C::getStr( 'test_platform' );
                $linksBackup = C::getStr( 'links_backup' );
                $description = C::getStr( 'description' );

                $id = TaskApi::addTask( $title,
                        $status,
                        $performer,
                        $type,
                        $priority,
                        $linkFl,
                        $correspondenceFl,
                        $linksProject,
                        $testPlatform,
                        $linksBackup,
                        $description
                );

                $files = File::uploadFile( $id, $_FILES['file'] );

                // запишем в БД файлы.
                File::setFilesTask( $id, $files );


                if( $performer && $performer != 0 )
                {
                    $email = UserAuth::getEmailById( $performer );
                    $title = strip_tags( $title );
                    $description = strip_tags( $description );

                    $subject = 'За вами закреплена задача.';
                    $msg = "За вами закреплена в системе Task Manager задача.\r\n\r\nЗадача № {$id}.\r\nТема: {$title}\r\nОписание:\r\n{$description}";
                    $mailer = new Mailer();
                    $mailer->sendMail( $email, NOREPLAY_EMAIL, $subject, $msg );

                }

                $this->goHeader( '/' );
                break;
            case'view':
            default:

                $this->setTemplate( 'AddTask.tpl' );
                $menu = new ModuleMenu();

                $items = [
                    'status' => Parameters::getStatus(),
                    'type' => Parameters::getType(),
                    'priority' => Parameters::getPriority(),
                    'performer' => Parameters::getPerformer(),
                ];

                $this->setData( 'menuModule', $menu->data );
                $this->setData( 'items', $items );
                $this->setData( 'user', $_SESSION[ UserAuth::$userData ][ 'username' ] );

                break;
        }
    }

    public function _editUsers()
    {
        $menu = new ModuleMenu();
        $this->setData( 'menuModule', $menu->data );

        $id = C::getInt( 'id' );

        switch ( C::getStr( 'active' ) ) {

            case 'policy':

                $this->setTemplate( 'EditPolicy.tpl' );
                $user = UserAuth::getUserId( $id );
                $this->setData( 'item', $user );

                break;

            case 'edit':
                break;
            case 'delete':
                break;
            case 'view':
            default:
                $this->setTemplate( 'EditUsers.tpl' );
                $users = UserAuth::getAllUsers();
                $this->setData( 'users', $users );
                break;
        }
        $this->setData( 'user', $_SESSION[ UserAuth::$userData ][ 'username' ] );
    }


    /**
     * Метод для Подтверждения задач по ajax.
     */
    public function _approve()
    {
        $uId = $_SESSION[ UserAuth::$userData ][ 'id' ];
        $pId = C::getInt( 'pId' );

        $cmd = C::getStr( 'act' );
        if ( isset( $cmd ) ) {
            switch ( $cmd ) {
                case 'approve':
                    if ( isset( $uId ) && isset( $pId ) ) {
                        $object = TaskApi::getObjectIssetById( $pId );
                        if ( $object ) {
                            // Массивы с данными.
                            $fields = [
                                'performer',
                            ];
                            $values = [
                                $uId,
                            ];
                            $res = TaskApi::updateTask( $pId, $fields, $values );
                            // Мыло пользователю.
                            $subject = 'Вы закрепили за собой задачу.';
                            $login = $_SESSION[ UserAuth::$userData ][ 'email' ];
                            $msg = C::getStr( 'username' ) . "Вы закрепили  в системе Task Manager за собой задачу\r\nЗадача № {$pId}.";
                            $mailer = new Mailer();
                            $mailer->sendMail( $login, NOREPLAY_EMAIL, $subject, $msg );
                            if ( $res )
                                echo 1;
                            else
                                echo 0;
                        }
                    }
                    break;
                default:
                    break;
            }
        }
    }

    public function _getDataFilter(){}
}