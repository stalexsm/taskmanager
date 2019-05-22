<?php
/**
 * Created by PhpStorm.
 * User: StAlex67
 * Date: 02.08.2015
 * Time: 13:15
 */

namespace c\classes;

use c\core\Parameters;
use c\core\User;

class Prototype
{

    private $template = 'Main.tpl';
    private $data = [ ];


    /**
     * Инитим начальные данные.
     */
    public function init()
    {
        $this->setData( 'title', Parameters::getTitle() );
        $this->setData( 'copyright', Parameters::getCopyright() );
        $this->setData( 'ver', Parameters::getVersion() );
    }

    /**
     * @param $cmd
     * Метод выполнения.
     */
    public function execute( $cmd )
    {
        if ( defined( 'AP_' . $cmd ) ) {
            if ( constant( 'AP_' . $cmd ) <= User::getPolicy() )
                return $this->$cmd();
            else $this->goHeader( '/' );
        }
    }

    /**
     * @param $url
     * Метод переадресации.
     */
    public function goHeader( $url )
    {
        header( 'Location:' . $url );
        exit;
    }

    /**
     * Простой парсер шаблона на php.
     */
    public function render()
    {
        extract( $this->data );
        ob_start();
        include_once ( 'c/templates/' . $this->getTemplate() );
        echo ob_get_clean();
    }

    /**
     * @return array
     * Метод для получения данных.
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $name
     * @return mixed
     * Метод для получения данных по имени.
     */
    public function getDataName( $name )
    {
        if ( isset( $this->data[ $name ] ) ) return $this->data[ $name ];
    }

    /**
     * @param $name
     * @param $value
     * Метод для добавления данных.
     */
    public function setData( $name, $value )
    {
        $this->data[ $name ] = $value;
    }

    /**
     * @return string
     * Метод для получения шаблона.
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param $value
     * Метод для установки шаблона.
     */
    public function setTemplate( $value )
    {
        $this->template = $value;
    }

}