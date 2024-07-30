<?php
namespace Multi;

use Exception;
use mysqli;

class Db{

    private static $instance = null;
    private $connection;
    private $count;
    private $pageSize;
    private $sql;
    public function  __construct()
    {
        $this->connect();
    }

    public function connect(){
        $config = parse_ini_file(CONFIG . "db.ini");
        try {
            $this->connection = new Mysqli($config["HOST"], $config["USERNAME"], $config["PASSWORD"], $config["DB"]);

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function select($table, $what = '*'){
        $this->sql = "SELECT $what FROM `$table`";
        $this->count = count($this->all());
        return $this;

    }

    public function update($table, $data){
        $dataArr = [];
        foreach ($data as $key => $value){
            $dataArr[] = $key . "='" . $value . "'";
        }
        $dataStr = implode(',',$dataArr);
        $this->sql = "UPDATE $table SET $dataStr";
        return $this;
    }

    public function delete($table){
        $this->sql = "DELETE FROM `$table`";
        return $this;
    }

    public function insert($table, $data){
        $fieldsArray = [];
        $valuesArr = [];
        foreach ($data as $field => $value){
            $fieldsArray[] = "`" . $field . "`";
            $valuesArr[] = "'" . $value . "'";
        }

        $fields = implode(',',$fieldsArray);
        $values = implode(',',$valuesArr);

        $this->sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $response = $this->query();
        if($response){
            $res = ['id'=>$this->getLastInsertedId()];
            return (object) $res;
        }
        return false;
    }

    public function where($condition){
        $conditionArr = [];
        foreach ($condition as $key => $value){
            $conditionArr[] = $key . "='" . $value . "'";
        }

        $conditionStr = implode(' AND ',$conditionArr);

        $this->sql .= " WHERE $conditionStr";
        $this->query();
        $this->count = count($this->all());
        return $this;
    }

    public function query(){
        return $this->connection->query($this->sql);
    }

    public function one(){
        $this->limit(1);
        $data = $this->query();
        $result = $data->fetch_assoc();
        return $result;
    }
    public function all(){
        $result = [];
        $data = $this->query();
        while ($row = $data->fetch_assoc()){
            $result[] = $row;
        }
        return $result;
    }

    public function limit($limit){
        $this->sql .= " LIMIT $limit";
    }

    public function offset($offset){
        $this->sql .= " OFFSET $offset";
    }

    public function paginate($count){
        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        $offset = ($page-1) * $count;
        $this->pageSize = $count;
        $this->limit($count);
        $this->offset($offset);
        return $this->all();
    }

    public function links(){
        $pageCount = ceil($this->count/$this->pageSize);
        $links = '<ul>';
        for($page = 1;$page <= $pageCount;$page++){
            $links .= "<li><a href='?page=".$page."'>$page</a></li>";
        }
        $links .= '<ul>';

        if($pageCount > 1){
            echo  $links;
        }

    }

    public function orderBy($field, $orderType = 'ASC' )
    {

        $this->sql .= " ORDER BY $field  $orderType";
        return $this;
    }

    public function getLastQuery(){
        return $this->sql;
    }

    public function getLastInsertedId() {
        return $this->connection->insert_id;
    }
}