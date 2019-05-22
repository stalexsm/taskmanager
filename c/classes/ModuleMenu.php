<?php

namespace c\classes;

class ModuleMenu
{

    public $template = '';
    public $data = [

        'main'     => [
            'title'  => 'Главная',
            'href'   => '/',
            'policy' => UP_SPECIALIST,
        ],

        'work'     => [
            'title'  => 'Мои задачи',
            'href'   => '/?cmd=getUserTask',
            'policy' => UP_SPECIALIST,
        ],

        'projects' => [
            'title'  => 'Проекты',
            'href'   => '#',
            'policy' => UP_MANAGER,
            'items'  => [

                'allProjects' => [
                    'title' => 'Проекты в работе',
                    'href'  => '/?cmd=allProjects',
                    'policy'=> UP_MANAGER ],

                'closedTask' => [
                    'title' => 'Закрытые проекты',
                    'href'  => '/?cmd=allProjects&act=closed',
                    'policy'=> UP_MANAGER ],
            ],
        ],

        'setting' => [
            'title'  => 'Настройки',
            'href'   => '#',
            'policy' => UP_SYS,
            'items'  => [

                'editUsers' => [
                    'title'  => 'Пользователи',
                    'href'   => '/?cmd=_editUsers',
                    'policy' => UP_SYS ],
            ],
        ],

        'new_task' => [
            'title'  => '<span class="glyphicon glyphicon-plus"></span>',
            'href'   => '/?cmd=_addNewTask',
            'policy' => UP_MANAGER,z
        ],
    ];

    /**
     * @param string $currentItem
     * @return bool
     */
    function selectItem( $currentItem = '' )
    {

        $menu = $this->data;
        $result = false;

        foreach ( $menu as $key => &$item ) {
            unset( $item[ 'active' ] );
            if ( $key == $currentItem ) {
                $item[ 'active' ] = '1';
                $result = true;
            }

            if ( isset( $item[ 'items' ] ) )
                foreach ( $item[ 'items' ] as $subkey => &$subitem ) {
                    unset( $subitem[ 'active' ] );
                    if ( $subkey == $currentItem ) {
                        $subitem[ 'active' ] = '1';
                        $item[ 'active' ] = '1';
                        $result = true;
                    }
                }
        }

        if ( $result ) $this->data = $menu;

        return $result;
    }

}