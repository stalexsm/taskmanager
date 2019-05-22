<?php

namespace c\core;

class DB
{

    private $db;
    private $sql;
    private static $instance;


    /**
     * @return DB
     */
    static function connect()
    {
        if ( self::$instance instanceof self )
            return self::$instance;

        return self::$instance = new self;
    }

    /**
     * @throws \Exception
     */
    public function __construct()
    {

        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->db = new \PDO( HOST_DB, USER_DB, PASSWD_DB, $opt );
    }

    /**
     * @return $this
     * Метод для выборки.
     */

    public function select()
    {
        $this->sql = "SELECT ";

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     * Метод для добавления полей в запрос на выборку.
     */
    public function fields( $fields = [ ] )
    {
        if ( is_array( $fields ) ) {
            $fields = implode( ',', $fields );
            $this->sql .= $fields;
        } else if ( $fields == '*' ) {
            $this->sql .= '*';
        } else
            $this->sql .= $fields;

        return $this;
    }

    /**
     * @param $table
     * @param bool $alias
     * @return $this
     * Метод для добавления таблицы в запроск на выборку.
     */
    public function from( $table, $alias = false )
    {
        if ( $alias ) $this->sql .= " FROM `{$table}` AS {$alias}";
        else $this->sql .= " FROM `{$table}`";

        return $this;
    }

    /**
     * @param $join
     * @param $table
     * @param $alias
     * @return $this
     * Метод для добавления JOIN в запрос выборки.
     */
    public function join( $join, $table, $alias = false )
    {
        $join = mb_strtoupper( $join, 'utf8' );
        if ( $alias ) $this->sql .= " {$join} JOIN `{$table}` AS {$alias} ";
        else $this->sql .= " {$join} JOIN `{$table}` ";

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     * Метод для добавления ON в запрос выборки.
     */

    public function on( $name, $value )
    {
        $this->sql .= " ON {$name} = {$value}";

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $operand
     * @return $this
     */

    public function where( $name, $value, $operand = '=' )
    {
        $this->sql .= " WHERE {$name}{$operand}{$value}";

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param $operand
     * @return $this
     */

    public function andWhere( $name, $value, $operand = '=' )
    {
        $this->sql .= " AND {$name}{$operand}{$value}";

        return $this;
    }

    /**
     * @return $this
     * Метод для случайной сортировки.
     */

    public function rand()
    {
        $this->sql .= " ORDER BY RAND()";

        return $this;
    }

    /**
     * @param string $order
     * @param string $direction
     * @return $this
     * Метод для сортировки.
     */

    public function order( $order, $direction = 'ASC' )
    {
        $this->sql .= " ORDER BY {$order} {$direction}";

        return $this;
    }

    /**
     * @param $count
     * @param bool|false $perpage
     * @return $this
     * Метод для лимита (постраничной навигации) в запрос выборки.
     */

    public function limit( $count, $perpage = false )
    {

        if ( $perpage ) $this->sql .= " LIMIT " . ( ( (int)$count - 1 ) * $perpage ) . "," . (int)$perpage;
        else $this->sql .= " LIMIT {$count}";

        return $this;
    }

    /**
     * @param $table
     * @return $this
     * Метод для удаления.
     */
    public function delete( $table )
    {
        $this->sql = "DELETE FROM `{$table}` ";

        return $this;
    }

    /**
     * @param $table
     * @return $this
     * Метод для добавления
     */
    public function insert( $table ) {
        $this->sql = "INSERT INTO `{$table}` ";

        return $this;
    }

    /**
     * @param $fields
     * @return $this
     * Метод для добавления полей в запрос INSERT.
     */
    public function into ( $fields ) {

        $values = $fields;

        if(is_array($fields)) {
            $fields = implode(',', $fields);
            $this->sql .= '('.$fields.')';
        } else {
            $this->sql .= '('.$fields.')';
        }

        if(is_array($values)) {
            $this->sql .= " VALUES (";
            foreach($values as $value) {
                $this->sql .= ":$value,";
            }
            $this->sql = substr($this->sql, 0, -1);
            $this->sql .= ")";
        } else {
            $this->sql .= " VALUES (:$values)";
        }

        return $this;
    }

    /**
     * @param $table
     * @return $this
     * Метод для обновления данных в БД.
     */
    public function update( $table )
    {
        $this->sql = "UPDATE `{$table}` ";

        return $this;
    }

    /**
     * @param $sql
     * @return $this
     * Метод для самописного запроса.
     */
    public function sql( $sql )
    {
        $this->sql = $sql;

        return $this;
    }


    /**
     * @param $fields
     * @return $this
     * поля для обновленя в запрос на UPDATE.
     */
    public function set( $fields )
    {

        $this->sql .= " SET ";
        if ( is_array( $fields ) )
            foreach ( $fields as $field ) {
                if( $field == 'id' ) continue;
                $this->sql .= "`" . str_replace( "`", "``", $field ) . "`" . "=:$field, ";
            }
        $this->sql = substr( $this->sql, 0, -2 );

        return $this;
    }

    /**
     * @param array $arg
     * @return string
     * Метод для выполнения.
     */
    public function get( $arg = [ ] )
    {
        $result = $this->db->prepare( $this->sql );

        $result->execute( $arg );

        return $this->db->lastInsertId();


    }

    /**
     * @return mixed
     * Метод возвращает запрос.
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @param $sql
     * Метод для написания запроса.
     */
    public function setSql( $sql )
    {
        $this->sql = $sql;
    }

    /**
     * Метод для отладки запроса.
     */
    public function dump()
    {
        var_dump( $this->sql );
    }

    /**
     * @param array $arg
     * @param int $argument
     * @return bool|mixed
     * Метод для выборки одной записи
     */
    public function getOne( $arg = [ ], $argument = \PDO::FETCH_ASSOC )
    {
        $result = $this->db->prepare( $this->sql );
        $result->execute( $arg );

        if ( $result->rowCount() == 0 ) return false;

        return $result->fetch( $argument );

    }

    /**
     * @param array $arg
     * @param int $argument
     * @return array|bool
     * Метод для всех записей.
     */

    public function getAll( $arg = [ ], $argument = \PDO::FETCH_ASSOC )
    {

        $result = $this->db->prepare( $this->sql );
        $result->execute( $arg );
        if ( $result->rowCount() == 0 ) return false;

        $row = $result->fetchAll( $argument );

        return $row;
    }
}