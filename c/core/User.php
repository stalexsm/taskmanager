<?php

namespace c\core;

class User {

    static $userPolicy = UP_PUBLIC;

    /**
     * @param $userPolicy
     * Метод для записи политики доступа
     */
    static public function setPolicy($userPolicy){

        self::$userPolicy = $userPolicy;

    }

    /**
     * @return string
     * Метод для чтения политики доступа.
     */
    static public function getPolicy(){

        return self::$userPolicy;

    }

    /**
     * @param $policy
     * @param bool|false $lessPolitics
     * @return bool
     * Метод для проверки палитики.
     */
    static public function granted($policy, $lessPolitics = false){
        if( $lessPolitics ) return ( self::$userPolicy > $policy && self::$userPolicy < $lessPolitics );
        return self::$userPolicy >= $policy;

    }
}