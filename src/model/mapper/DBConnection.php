<?php
include_once(dirname(__FILE__)."/../config/Config.php");

class DBConnection {
    public $host;
    public $schema;
    public $dsn;
    public $username;
    public $password;
    public $pdo;
    public $command;
    private static $instance;

    function __construct()
    {
        $this->loadDBconnection();
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance == NULL) {
        	
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    function loadDBconnection()
    {
       $config = Config::getInstance()->getConfigDataBase();
        $this->host = $config["host"];
        $this->schema = $config["schema"];
        $this->dsn = $config["dbtype"];
        $this->username = $config["username"];
        $this->password = $config["password"];
    }

    public function connect(){
        $this->pdo = new PDO($this->dsn.':host='.$this->host.';dbname='.$this->schema, $this->username, $this->password);
    }
    
    public function __sleep()
    {
    	return array();
    }

    public function disconnect(){
        $this->pdo = null;
    }

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param mixed $pdo
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }



} 