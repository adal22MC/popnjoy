<?php

class Conexion{

	private $servername = "localhost"; // 147.135.11.57
    private $username = "root"; // iglesiai_pedro
    private $password = ""; // Pumas12.
	private $bd_name = "pos_produccion"; // iglesiai_pos
	private $conn;

	public function __construct(){

		try {

			$this->conn = new PDO("mysql:host=$this->servername;dbname=$this->bd_name;", $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch(PDOException $e) {
			return "Connection failed: " . $e->getMessage();
		}

	}

	public function getConexion(){
		return $this->conn;
	}

	public function closeConexion(){
		$this->conn = null;
	}

}
















