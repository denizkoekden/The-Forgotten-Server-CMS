<?php

/**
* @author Kornholijo
* @desc Class for handling GUI input
* @copyright 2007
*/

class GUI
{
	private $cms, $db, $accounts, $players;
	
	public function loadBaseObject(&$base)
    {
        $this->cms = &$base;
        $this->db = $this->cms->db;
		$this->accounts = $this->cms->accounts;
		$this->players 	= $this->cms->players;
    }

	
	function processCreateAccount($accNo, $password)
	{
		$password = $this->db->escape_string($password);
		if(strlen($password) < 5) return 'Your password should be more than 5 characters.';
		
		if($accNo == $password) return 'Go look at your password...';
		
		$ret = $this->accounts->CreateAccount($accNo, $password);
		
		switch($ret)
		{
			case ERR_NOTNUMBER: return '';
		}
	}
}

?>