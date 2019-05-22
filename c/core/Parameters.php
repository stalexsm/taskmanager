<?php
/**
 * Класс для получения параметров для системы.
 */
namespace c\core;


class Parameters
{
    /** @var array Массив с разрешенными статусами для специалиста. */
    public static $allowedSpecialist = [ 1, 2, 3, 6, 7 ];

    /**
     * @return array|bool
     * Метод для получения массива типов задач.
     */
    public static function getType()
    {
        return DB::connect()
            ->select()
            ->fields( [ 'id', 'name' ] )
            ->from( 'type' )
            ->order( 'id' )
            ->getAll( [ ], \PDO::FETCH_KEY_PAIR );
    }

    /**
     * @return array|bool
     * Метод для получения массива статусов задач.
     */
    public static function getStatus()
    {
        return DB::connect()
            ->select()
            ->fields( [ 'id', 'name' ] )
            ->from( 'status' )
            ->order( 'id' )
            ->getAll( [ ], \PDO::FETCH_KEY_PAIR );
    }

    /**
     * @return array|bool
     * Метод для получения массива приоритетов задач.
     */
    public static function getPriority()
    {
        return DB::connect()
            ->select()
            ->fields( [ 'id', 'name' ] )
            ->from( 'priority' )
            ->order( 'id' )
            ->getAll( [ ], \PDO::FETCH_KEY_PAIR );
    }

    /**
     * @return array
     * Метод для получения исполнителей.
     */
    public static function getPerformer()
    {
        return  DB::connect()
            ->select()
            ->fields( [ 'id, username' ] )
            ->from( 'user' )
            ->order( 'id' )
            ->getAll( [ ], \PDO::FETCH_KEY_PAIR );
    }

    /**
     * @return mixed
     * Метод для получения title.
     */
    public static function getTitle()
    {
        $arg = [ 'title' => 'title' ];
        return DB::connect()
            ->select()
            ->fields( 'value' )
            ->from( 'parameters' )
            ->where( 'title', ':title' )
            ->getOne( $arg, \PDO::FETCH_COLUMN );
    }

    /**
     * @return mixed
     * Метод для получения copyright.
     */
    public static function getCopyright()
    {
        $arg = [ 'copyright' => 'copyright' ];
        return DB::connect()
            ->select()
            ->fields( 'value' )
            ->from( 'parameters' )
            ->where( 'title', ':copyright' )
            ->getOne( $arg, \PDO::FETCH_COLUMN );
    }

    public static function getVersion()
    {
        $arg = [ 'ver' => 'ver' ];
        return DB::connect()
            ->select()
            ->fields( 'value' )
            ->from( 'parameters' )
            ->where( 'title', ':ver' )
            ->getOne( $arg, \PDO::FETCH_COLUMN );
    }
}