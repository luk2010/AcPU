<?php

require 'functions.php';
require 'bdd.php';
require 'page.php';

class AcPU
{
    protected static $instance;
    
    protected function __construct() {
        
    }
    
    protected function __clone() {
        
    }
    
    public static function get()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self;
        }
        
        return self::$instance;
    }
    
    public static function version()
    {
        return "AcPU build 20";
    }
    
    public function initMySQLBdd($name, $login, $password, $adress)
    {
        try {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new BDD(new PDO('mysql:host='.$adress.';dbname='.$name.'', $login, $password, $pdo_options), $name);
        
        return $bdd;
        } catch (Exception $e) {
            die ('Can\'t find bdd '.$name.' !');
            return NULL;
        }
    }
    
    public function initPostGreBdd($name, $login, $password, $adress)
    {
        try {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new BDD(new PDO('pgsql:host='.$adress.';dbname='.$name.'', $login, $password, $pdo_options), $name);
        
        return $bdd;
        } catch (Exception $e) {
            die ('Can\'t find bdd '.$name.' !');
            return NULL;
        }
    }
    
    public function getBdd()
    {
        return $bdd;
    }
    
    protected $bdd;
    
    public function createHTMLConstructor($name)
    {
        return new HTMLConstructor($name);
    }
    
    public function getPost($name)
    {
        return $_POST[$name];
    }
    
    public function getGet($name)
    {
        return $_GET[$name];
    }
}

?>
