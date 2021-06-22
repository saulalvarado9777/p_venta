<?php
    class conexion{
        private $servidor="localhost";
        //private $servidor="sql302.epizy.com";
        private $db="ventas";
        //private $db="epiz_28857032_ventas";
        private $puerto=3306;
        private $charset="utf8";
        //private $usuario="epiz_28857032";
        private $usuario="saul";
        private $contrasena="1234";
        //private $contrasena="QynT4FrfWAYA";
        public $pdo=null;
        private $atributos =[PDO::ATTR_CASE=>PDO::CASE_LOWER,PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_ORACLE_NULLS=>PDO::NULL_EMPTY_STRING,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ];
        function __construct(){ 
            $this->pdo= new PDO("mysql:dbname={$this->db};host={$this->servidor};port={$this->puerto};charset={$this->charset}", $this->usuario, $this->contrasena,$this->atributos);
        }


    }
?>