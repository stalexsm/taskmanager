<?php
/**
 * Класс для работы с задачами.
 */

namespace c\classes;

use c\core\DB;
use c\core\File;

class TaskApi
{
    const FinishStatus = 8;

    public static function getObjectById($id)
    {

        /** @var  $id */
        $id = (int)$id;

        /** @var  $table */
        $table = 'task';

        /** @var  $fields array выбираемых полей. */
        $fields = [
            't.*',
            'st.name as status',
            'tt.name as type',
            'p.name as priority',
            'u.username as manager',
            'u.id as manager_id',
        ];

        $arg = ['id' => $id];

        return DB::connect()
            ->select()
            ->fields($fields)
            ->from($table, 't')
            ->join('left', 'status', 'st')
            ->on('st.id', 't.status_id')
            ->join('left', 'type', 'tt')
            ->on('tt.id', 't.type_id')
            ->join('left', 'priority', 'p')
            ->on('p.id', 't.priority_id')
            ->join('left', 'user', 'u')
            ->on('u.id', 't.manager')
            ->where('t.id', ':id')
            ->getOne($arg);
    }

    public static function getObjectByIdPerformer($id)
    {

        /** @var  $id */
        $id = (int)$id;

        /** @var  $table */
        $table = 'task';

        /** @var  $fields array выбираемых полей. */
        $fields = [
            't.*',
            'st.name as status',
            'tt.name as type',
            'p.name as priority',
            'u.username as performer',
            'u.id as performer_id',
        ];

        $arg = ['id' => $id];

        return DB::connect()
            ->select()
            ->fields($fields)
            ->from($table, 't')
            ->join('left', 'status', 'st')
            ->on('st.id', 't.status_id')
            ->join('left', 'type', 'tt')
            ->on('tt.id', 't.type_id')
            ->join('left', 'priority', 'p')
            ->on('p.id', 't.priority_id')
            ->join('left', 'user', 'u')
            ->on('u.id', 't.performer')
            ->where('t.id', ':id')
            ->getOne($arg);
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     * Метод для определения, есть задача или нет.
     */
    public static function getObjectIssetById($id)
    {
        $id = (int)$id;
        $table = 'task';

        $arg = ['id' => $id];

        return DB::connect()
            ->select()
            ->fields('id')
            ->from($table)
            ->where('id', ':id')
            ->getOne($arg);
    }

    /**
     * @param $id
     * @param $fields
     * @param $values
     * @return bool
     */
    public static function updateTask($id, $fields, $values)
    {
        $id = (int)$id;
        $table = 'task';

        $arg = array_combine($fields, $values);
        $arg['id'] = $id;

        return DB::connect()
            ->update($table)
            ->set($fields)
            ->where('id', ':id')
            ->get($arg);
    }

    /**
     * @param int $count
     * @param bool $perpage
     * @param int $performer
     * @return array|bool
     * @throws \Exception
     * Метод для выборки проектов.
     */
    public static function getObjects($count = 10, $perpage = false, $performer = 0)
    {

        /** @var  $table string */
        $table = 'task';

        $count = (int)$count;
        $performer = (int)$performer;

        /** @var  $fields array выбираемых полей. */
        $fields = [
            't.id',
            't.title',
            'st.name as status',
            'tt.name as type',
            'p.name as priority',
            't.begin_date',
            'u.username as manager',
        ];

        $arg = [ 'performer' => $performer ];

        return DB::connect()
            ->select()
            ->fields($fields)
            ->from($table, 't')
            ->join('left', 'status', 'st')
            ->on('st.id', 't.status_id')
            ->join('left', 'type', 'tt')
            ->on('tt.id', 't.type_id')
            ->join('left', 'priority', 'p')
            ->on('p.id', 't.priority_id')
            ->join('left', 'user', 'u')
            ->on('u.id', 't.manager')
            ->where('t.performer', ':performer')
            ->order('priority_id', 'DESC')
            ->limit($count, $perpage)
            ->getAll($arg);
    }


    /**
     * @param int $count
     * @param bool|false $perpage
     * @param int $manager
     * @param string $order
     * @param int $closed
     * @return array|bool
     * Метод для выборки проектов.
     */
    public static function getAllObjectsManager( $count = 10, $perpage = false, $manager = 0, $order = 'priority_id', $closed = 0 )
    {

        /** @var  $table string */
        $table = 'task';

        $count = (int)$count;
        $manager = (int)$manager;
        $closed = (int)$closed;
        if($order == 'performer') $order = 't.'.$order;

        /** @var  $fields array выбираемых полей. */
        $fields = [
            't.id',
            't.title',
            't.performer',
            'st.name as status',
            'tt.name as type',
            'p.name as priority',
            't.begin_date',
            'u.username as performer',
        ];

        $arg = [ 'manager' => $manager, 'closed' => $closed ];

        return DB::connect()
            ->select()
            ->fields($fields)
            ->from($table, 't')
            ->join('left', 'status', 'st')
            ->on('st.id', 't.status_id')
            ->join('left', 'type', 'tt')
            ->on('tt.id', 't.type_id')
            ->join('left', 'priority', 'p')
            ->on('p.id', 't.priority_id')
            ->join('left', 'user', 'u')
            ->on('u.id', 't.performer')
            ->where('t.manager', ':manager')
            ->andWhere( 'closed', ':closed' )
            ->order($order, 'DESC')
            ->limit($count, $perpage)
            ->getAll($arg);
    }


    /**
     * @param int $performer
     * @return int
     * Метод для подсчета задач.
     */
    public static function countTask( $performer = 0 )
    {

        /** @var  $table string */
        $table = 'task';
        $performer = (int)$performer;

        $fields = ['count(*) as count'];

        $arg = [ 'performer' => $performer ];

        $object = DB::connect()
            ->select()
            ->fields($fields)
            ->from($table)
            ->where('performer', ':performer')
            ->getOne($arg, \PDO::FETCH_COLUMN);

        return (int)$object;
    }

    /**
     * @param int $manager
     * @return int
     * Метод для подсчета задач.
     */
    public static function countTaskManager( $manager = 0, $closed = 0 )
    {

        /** @var  $table string */
        $table = 'task';
        $manager = (int)$manager;
        $closed  = (int)$closed;

        $fields = ['count(*) as count'];

        $arg = [ 'manager' => $manager, 'closed' => $closed ];

        $object = DB::connect()
            ->select()
            ->fields($fields)
            ->from($table)
            ->where('manager', ':manager')
            ->andWhere( 'closed', ':closed' )
            ->getOne($arg, \PDO::FETCH_COLUMN);

        return (int)$object;
    }

    /**
 * @param $id
 * @param $status
 * @param $assessment
 * @param $comment
 */
    public static function detailUpdateTask($id, $status, $assessment, $performer, $comment)
    {
        $id        = (int)$id;
        $status    = (int)$status;
        $performer = (int)$performer;

        $fields = ['id', 'status_id', 'assessment', 'performer' ];
        $date = date('Y-m-d H:i:s');
        $arg = [
            'id' => $id,
            'status_id' => $status,
            'assessment' => $assessment,
            'performer' => $performer,
        ];

        // Обновим саму задачу.
        DB::connect()
            ->update('task')
            ->set($fields)
            ->where('id', ':id')
            ->get($arg);

        // Если пусто, то не пишем.
        if (isset($comment) && !empty($comment)) {

            $into = ['task_id', 'user_id', 'comment', 'date'];
            $val = [
                'task_id' => $id,
                'user_id' => $_SESSION[UserAuth::$userData]['id'],
                'comment' => strip_tags( $comment ),
                'date' => $date,
            ];
            //Добавим комментарий для задачи.
            DB::connect()
                ->insert('comments')
                ->into($into)
                ->get($val);
        }
    }

    /**
     * @param $id
     * @param $title
     * @param $performer
     * @param $type
     * @param $priority
     * @param $linksFl
     * @param $correspondenceFl
     * @param $linkProject
     * @param $testPlatform
     * @param $linksBackup
     * @param $description
     * @param $status
     * @param $assessment
     * @param $comment
     * Метод для обновления задачи менеджером.
     */
    public static function detailUpdateTaskManager($id,
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
                                                   $comment)
    {
        $id = (int)$id;
        $status = (int)$status;
        $type = (int)$type;
        $performer = (int)$performer;
        $priority = (int)$priority;


        $fields = [
            'id',
            'title',
            'status_id',
            'description',
            'type_id',
            'priority_id',
            'assessment',
            'links_fl',
            'correspondence_fl',
            'links_project',
            'test_platform',
            'links_backup',
            'performer',
        ];

        $date = date('Y-m-d H:i:s');
        $arg = [
            'id'                => $id,
            'title'             => $title,
            'status_id'         => $status,
            'description'       => $description,
            'type_id'           => $type,
            'priority_id'       => $priority,
            'assessment'        => $assessment,
            'links_fl'          => $linksFl,
            'correspondence_fl' => $correspondenceFl,
            'links_project'     => $linkProject,
            'test_platform'     => $testPlatform,
            'links_backup'      => $linksBackup,
            'performer'         => $performer,
        ];

        if( $status == self::FinishStatus )
        {
            $fields[] = 'closed';
            $fields[] = 'end_date';
            $arg     += [ 'closed' => 1, 'end_date' => $date, ];
        }

        // Обновим саму задачу.
        DB::connect()
            ->update('task')
            ->set($fields)
            ->where('id', ':id')
            ->get($arg);

        // Если пусто, то не пишем.
        if (isset($comment) && !empty($comment)) {

            $into = ['task_id', 'user_id', 'comment', 'date'];
            $val = [
                'task_id' => $id,
                'user_id' => $_SESSION[UserAuth::$userData]['id'],
                'comment' => strip_tags( $comment ),
                'date' => $date,
            ];
            //Добавим комментарий для задачи.
            DB::connect()
                ->insert('comments')
                ->into($into)
                ->get($val);
        }
    }


    /**
     * @param $id
     * @return array|bool|void
     */
    public static function getCommentsID($id)
    {

        if (!$id) return;

        $fields = [
            't.comment',
            't.date',
            'u.username as author',
        ];

        $arg = ['id' => $id];

        return DB::connect()
            ->select()
            ->fields($fields)
            ->from('comments', 't')
            ->join('left', 'user', 'u')
            ->on('u.id', 't.user_id')
            ->where('task_id', ':id')
            ->getAll($arg);
    }

    /**
     * @param $title
     * @param $status
     * @param $performer
     * @param $type
     * @param $priority
     * @param $linkFl
     * @param $correspondenceFl
     * @param $linksProject
     * @param $testPlatform
     * @param $linksBackup
     * @param $description
     * @return string
     * Метод для добавления задач.
     */

    public static function addTask($title,
                                   $status,
                                   $performer,
                                   $type,
                                   $priority,
                                   $linkFl,
                                   $correspondenceFl,
                                   $linksProject,
                                   $testPlatform,
                                   $linksBackup,
                                   $description)
    {
        $date = date('Y-m-d H:i:'.'00');
        $description = strip_tags( $description );
        $into = [
            'title',
            'status_id',
            'performer',
            'type_id',
            'priority_id',
            'links_fl',
            'correspondence_fl',
            'links_project',
            'test_platform',
            'links_backup',
            'description',
            'manager',
            'begin_date',
        ];

        $val = [
            'title'            => $title,
            'status_id'        => $status,
            'performer'        => $performer,
            'type_id'          => $type,
            'priority_id'      => $priority,
            'links_fl'         => $linkFl,
            'correspondence_fl'=> $correspondenceFl,
            'links_project'    => $linksProject,
            'test_platform'    => $testPlatform,
            'links_backup'     => $linksBackup,
            'description'      => $description,
            'manager'          => $_SESSION[UserAuth::$userData]['id'],
            'begin_date'       => $date,
        ];

        return DB::connect()
            ->insert('task')
            ->into($into)
            ->get($val);

    }

    public static function deleteTask( $id )
    {

        $arg = [ 'id' => $id ];

        $comments = DB::connect()
            ->select()
            ->fields(['*'])
            ->from( 'comments' )
            ->where( 'task_id', ':id' )
            ->getAll( $arg );

        if( $comments )
            DB::connect()
                ->delete( 'comments' )
                ->where('task_id', ':id')
                ->get( $arg );

        $files = File::getFilesId( $id );
        if( $files ) {
            DB::connect()
                ->delete( 'files' )
                ->where( 'task_id', ':id' )
                ->get( $arg );

            File::unlinkId( 'c/files/'.$id );
        }

        DB::connect()
            ->delete( 'task' )
            ->where('id', ':id')
            ->get( $arg );


    }
}