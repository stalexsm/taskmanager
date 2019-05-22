<?php

namespace c\core;

class File
{
    protected static $allowedExt = [ '.doc', '.docx', '.pdf', '.jpg', '.jpeg', '.png', '.psd', '.txt' ];

    /**
     * @param $file
     * @param $id
     * @return array|void
     * Метод для загрузки файлов.
     */
    public static function uploadFile( $id, $file )
    {
        if( empty( $file['name'][0] ) ) return;

        $files = [];
        $dir = 'c/files/'.$id.'/';
        $re = "/\\.\\S{3,4}$/i";

        if( $file['name'] )
        {
            $i = 0;
            while( $i < count( $file['name'] ) )
            {
                preg_match($re, $file['name'][$i], $matches);
                if( in_array( $matches[0], self::$allowedExt ) )
                {
                    if( $file['size'][$i] < 1024 * 5 * 1024 )
                    {
                        if( is_uploaded_file( $file['tmp_name'][$i] ) )
                        {
                            if( !file_exists( 'c/files/' ) ) mkdir( 'c/files/', 0777, true );
                            if( !file_exists( $dir ) ) mkdir( $dir, 0777, true );
                            move_uploaded_file($file["tmp_name"][$i], $dir.md5($file['name'][$i].date('H:i:s') ).$matches[0]);
                            $files[$i] = $dir.md5($file['name'][$i].date('H:i:s') ).$matches[0];
                        }
                    }
                }
                $i++;
            }
        }

        return $files;
    }

    /**
     * @param $id
     * @param array $files
     * Метод для записи файлов в БД.
     */
    public static function setFilesTask( $id, $files = [] )
    {
        $into = [ 'task_id', 'files_data' ];
        $val = [
            'task_id' => $id,
            'files_data' => json_encode( $files ),
        ];

        DB::connect()
            ->insert( 'files' )
            ->into( $into )
            ->get( $val );
    }

    /**
     * @param $id
     * @param $files
     * Метод для обновления файлов к задаче.
     */
    public static function updateFilesTask( $id, $files )
    {
        $fields = [ 'files_data' ];
        $arg = [
            'task_id' => $id,
            'files_data' => json_encode( $files ),
        ];
        DB::connect()
            ->update( 'files' )
            ->set( $fields )
            ->where( 'task_id', ':task_id' )
            ->get( $arg );
    }

    /**
     * @param $taskId
     * @return bool|mixed
     * Метод для получения файлов по ID задачи.
     */
    public static function getFilesId( $taskId ) {
        $files = DB::connect()
                ->select()
                ->fields( 'files_data' )
                ->from( 'files' )
                ->where( 'task_id', ':task_id' )
                ->getOne( [ 'task_id' => $taskId ] );

        return  json_decode( $files['files_data'], true );
    }

    /**
     * @param $dir
     * Метод для удаления файлов по id ( номеру папки ).
     */
    public static function unlinkId( $dir )
    {

        if ($tmp = glob($dir."/*"))
        {
            foreach( $tmp as $file )
            {
                is_dir( $file )? self::unlinkId( $file ) : unlink($file);
            }
        }
        rmdir($dir);
    }
}