<?php

class createCon
{
	public $host = "localhost";
	public $user = "root";
	public $pass = "root";
	public $db = "slm_desa_rasau_jaya_1";

	public $myconn;

	public function connect()
	{
		$con = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->user, $this->pass);
		if (!$con) {
			die('Could not connect to database!');
		} else {
			$this->myconn = $con;
		}

		return $this->myconn;
	}

	public function close()
	{
		$this->myconn = null;
	}
}
