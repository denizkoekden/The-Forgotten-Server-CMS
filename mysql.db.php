<?php

/**
* @author Kornholijo
* @desc MySQL DB support for TFSCMS
* @copyright 2007
*/

class DBHandler {
	private $cms;
    private $hostname = "localhost", $username = "tfs", $password = "", $dbase = "";
    public $link;
    

    function DBHandler($host, $user, $pass, $dbase = "tfs", $conn = true) {

        $this->hostname = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->dbase = $dbase;
        
        if ($conn)
        {	
			if(!$this->connect()) die('CMSEXCEPTION: Cannot connect to database server!');
        	$this->select_db();
        }
    }
    public function loadBaseObject(&$base)
    {
        $this->cms = &$base;
    }


    function connect() 			  { return $this->link = @mysql_connect($this->hostname, $this->username, $this->password, $this->link); }
    function select_db() 		  { return mysql_select_db($this->dbase, $this->link); }
    function query($sql) 		  { return mysql_query($sql, $this->link); }
    function fetch_array($result) { return mysql_fetch_array($result); }
    function assoc_array($result) { return mysql_fetch_array($result, MYSQL_ASSOC); }
    function num_rows($result)	  { return mysql_num_rows($result); }
    function escape_string($str)  { return mysql_real_escape_string($str, $this->link); }
    function error()			  { return mysql_error(); }
    function close() 			  { return mysql_close($this->link); }
}

?>