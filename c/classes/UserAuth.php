<?php

namespace c\classes;

use c\core\C;
use c\core\DB;
use c\core\Mailer;
use c\core\User;

class UserAuth
{

    public static $userData = 'currentUserData';
    public static $userPolicy = 'currentUserPolicy';

    /**
     * @param $login
     * @param $password
     * @return bool
     * @throws \Exception
     * Метод авторизации.
     */
    public static function auth( $login, $password )
    {

        $login = mb_strtolower( $login, 'utf8' );
        $arg = [ 'login' => $login ];
        $user = DB::connect()
            ->select()
            ->fields( '*' )
            ->from( 'user' )
            ->where( 'email', ':login' )
            ->getOne( $arg );

        if ( $user and $user[ 'password' ] == self::hashPass( $user[ 'email' ], $password ) ) {
            User::setPolicy( (int)$user[ 'group_policy' ] );
            $_SESSION[ self::$userPolicy ] = (int)$user[ 'group_policy' ];

            // #todo вытащим только имя для отображения на панели приветствия.
            $tmp = '';
            if( $user ) $tmp = explode(' ', $user['username']);
            $user['username'] = $tmp[0];

            $_SESSION[ self::$userData ] = $user;

            return true;
        }
    }

    /**
     * @param $userId
     * @param $password
     * @return string
     */
    public static function hashPass( $userId, $password )
    {
        $userId = mb_strtolower( $userId, 'utf8' );

        return md5( $userId . ' ~task12599658ManagerFL@@ ' . $password );
    }

    /**
     * Метод для проверки Тукущей политики пользователя.
     */
    public static function loadDefaultPolicy()
    {
        $userPolicy = UP_PUBLIC;
        if ( !isset( $_SESSION[ self::$userPolicy ] ) )
            $_SESSION[ self::$userPolicy ] = $userPolicy;

        User::setPolicy( $_SESSION[ self::$userPolicy ] );
    }

    /**
     * Метод для выхода из авторизации.
     */
    public static function logout()
    {
        $userPolicy = UP_PUBLIC;
        $_SESSION[ self::$userPolicy ] = $userPolicy;
        unset( $_SESSION[ self::$userData ] );
        User::setPolicy( $userPolicy );
    }

    /**
     * @param $login
     * @return bool
     * @throws \Exception
     * Метод для получения данных о пользователе.
     */
    public static function getTaskManagerUserByLogin( $login )
    {
        $arg = [ 'login' => $login ];
        $user = DB::connect()
            ->select()
            ->fields( '*' )
            ->from( 'user' )
            ->where( 'email', ':login' )
            ->getOne( $arg );

        if ( $user ) return $user;
        else return false;
    }

    public static function addUserTaskManager( $login, $password, $policy = UP_TV )
    {
        $login = mb_strtolower( $login, 'utf8' );
        $policy = (int)$policy;

        if ( $login and $password and $policy ) {
            $password = self::hashPass( $login, $password );

            $fields = [ 'email', 'password', 'username' ];
            $values = [
                $login,
                $password,
                C::getStr( 'firstname' ).' '.C::getStr( 'lastname' )
            ];
            //Подготовим значения для добавления.
            $arg = array_combine( $fields, $values );

            DB::connect()
                ->insert( 'user' )
                ->into( $fields )
                ->get( $arg );

            // Мыло пользователю.
            $subject = 'Вы зарегистрировались в системе.';
            $msg = C::getStr( 'firstname' ) . ", вы зарегистрировались в системе Task Manager.\r\nСкоро администратор вам выставит права для дальнейшего пользования.\r\nваш логин: " . $login . "\r\n\r\nС уважением " . str_replace( '/', '', WEBROOTPATH );

            $mailer = new Mailer();
            $mailer->sendMail( $login, NOREPLAY_EMAIL, $subject, $msg );
            // Мыло Админу.
            $subjectAdmin = 'Зарегистрировался новый пользователь.';
            $msgAdmin = "Уважакмый, Администратор.\r\nЗарегистрировался новый пользователь.\r\nЛогин:" . $login . "\r\nИмя:" . C::getStr( 'firstname' ) . "\r\nФамилия:" . C::getStr( 'lastname' ) . "\r\nЖдет выставления прав.";
            $mailer->sendMail( ADM_EMAIL, NOREPLAY_EMAIL, $subjectAdmin, $msgAdmin );
        }
    }

    /**
     * @param $id
     * @return bool|mixed
     * Метод для получения по id имя пользователя.
     */
    public static function getEmailById( $id )
    {
        $arg = [ 'id' => (int)($id) ];
        return DB::connect()
            ->select()
            ->fields( [ 'email' ] )
            ->from( 'user' )
            ->where( 'id', ':id' )
            ->getOne( $arg , \PDO::FETCH_COLUMN );
    }

    /**
     * @return array|bool
     * Метод для получения всех пользователей
     */
    public static function getAllUsers()
    {
        return DB::connect()
            ->select()
            ->fields('*')
            ->from( 'user' )
            ->getAll();
    }

    /**
     * @param $id
     * @return bool|mixed
     * Метод для получение данных user(а) по id.
     */
    public static function getUserId( $id )
    {
        return DB::connect()
            ->select()
            ->fields( 'username, group_policy' )
            ->from( 'user' )
            ->where( 'id', ':id' )
            ->getOne( [ 'id' => (int)$id ] );
    }
}