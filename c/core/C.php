<?php

namespace c\core;

class C
{

    /**
     * @param $name
     * @param $default
     * @return string
     * Вспомогательный метод.
     */
    static function getStr( $name, $default = '' )
    {
        $val = $default;
        if ( isset( $_GET[ $name ] ) ) $val = $_GET[ $name ];
        if ( isset( $_POST[ $name ] ) ) $val = $_POST[ $name ];
        if ( get_magic_quotes_gpc() ) $val = stripslashes( $val );

        return $val;
    }

    /**
     * @param $name
     * @param $default
     * @return int
     * Вспомогательный метод.
     */
    static function getInt( $name, $default = 0 )
    {
        $val = $default;
        if ( isset( $_GET[ $name ] ) ) $val = $_GET[ $name ];
        if ( isset( $_POST[ $name ] ) ) $val = $_POST[ $name ];
        $val = (int)$val;

        return $val;
    }

    /**
     * @param $name
     * @param string $default
     * @return string
     * Вспомогательный метод.
     */
    static function getSesStr( $name, $default = '' )
    {
        return $_SESSION[ 'getPostStorage' ][ 'name' ] =
            self::getStr( $name,
                isset( $_SESSION[ 'getPostStorage' ][ $name ] ) ? $_SESSION[ 'getPostStorage' ][ $name ] : $default );
    }

    /**
     * @param $name
     * @param string $default
     * @return int
     * Вспомогательный метод.
     */
    static function getSesInt( $name, $default = '' )
    {
        return $_SESSION[ 'getPostStorage' ][ 'name' ] =
            self::getInt( $name,
                isset( $_SESSION[ 'getPostStorage' ][ $name ] ) ? $_SESSION[ 'getPostStorage' ][ $name ] : $default );
    }
}