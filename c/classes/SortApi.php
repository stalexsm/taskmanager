<?php

/**
 * Класс для формирования и работы с сортировкой.
 */

namespace c\classes;

class SortApi
{
    public static $showSort = [
        'performer' => [
            'href' => '?cmd=allProjects&order=performer',
            'title'=> 'по исполнителю',
            'span' => 'glyphicon glyphicon-user',
        ],
        'type' => [
            'href' => '?cmd=allProjects&order=type_id',
            'title'=> 'по типу',
            'span' => 'glyphicon glyphicon-tasks',
        ],
        'status' => [
            'href' => '?cmd=allProjects&order=status_id',
            'title'=> 'по статусу',
            'span' => 'glyphicon glyphicon-stats',
        ],
        'date' => [
            'href' => '?cmd=allProjects&order=begin_date',
            'title'=> 'по дате',
            'span' => 'glyphicon glyphicon-calendar',
        ],
        'cancel' => [
            'href' => '?cmd=allProjects',
            'title'=> 'сбросить',
            'span' => 'glyphicon glyphicon-remove-sign',
        ],
    ];

    /**
     * @param $name
     * @param $value
     * @return array
     * Метод для добавления параметров к стандартному массиву.
     */
    public static function addParamUrl( $name, $value )
    {
        foreach( self::$showSort as &$item )
        {
            $item['href'] .= '&'.$name.'='.$value;
        }

        return self::$showSort;
    }
}
