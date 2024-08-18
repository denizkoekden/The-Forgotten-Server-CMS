<?php

/**
* @author Kornholijo
* @desc Class for working with accounts 
* @copyright 2007
*/

class Accounts
{
	private $cms;
	
    public function loadBaseObject(&$base)
    {
        $this->cms = &$base;
    }

    function AccountExists($accountNumber)
    {    	
    	if(!is_numeric($accountNumber)) return ERR_NOTNUMBER;
    	
    	if(!($qu = $this->cms->db->query("SELECT `id` FROM `accounts` WHERE `id` ={$accountNumber}")) || $this->cms->db->num_rows($qu) == 0)
    		return $qu ? ERR_NOEXIST : ERR_DBERROR ;
    	return 1;
    }
    function CreateAccount($accNo, $password)
    {
		if($this->AccountExists($accNo) != ERR_NOEXIST) return ERR_EXIST;
		if(!$qu = $this->cms->db->query("INSERT INTO `accounts` ( `id` , `password` , `type` , `premdays` , `lastday` , `key` ) VALUES ('{$accNo}', '{$password}', '1', '0', '0', '0')"))
    		return ERR_DBERROR;
    	return 1;
	
	}
    function SetPassword($accNo, $newPass)
    {

		if(!$qu = $this->cms->db->query("UPDATE `accounts` SET `password` = '{$newPass}' WHERE `id` = {$accNo} LIMIT 1"))
    		return ERR_DBERROR;
    	return 1;

	}
	function GetPassword($accNo)
	{
		if(!$this->AccountExists($accNo)) return ERR_NOEXIST;
		
		if(!($qu = $this->cms->db->query("SELECT `password` FROM `accounts` WHERE `id` = {$accNo}")) || $this->cms->db->num_rows($qu) != 1)
    		return $qu ? ERR_DBERROR : ERR_MORETONE ;
    	$arr = $this->cms->db->assoc_array($qu);	
    	return $arr['password'];		
	}    
	function SetRecoveryKey($accNo, $newKey)
    {

		if(!$qu = $this->cms->db->query("UPDATE `accounts` SET `key` = '{$newPass}' WHERE `id` = {$accNo} LIMIT 1"))
    		return ERR_DBERROR;
    	return 1;

	}
	function GetRecoveryKey($accNo)
	{
		if(!$this->AccountExists($accNo)) return ERR_NOEXIST;
		
		if(!($qu = $this->cms->db->query("SELECT `key` FROM `accounts` WHERE `id` = {$accNo}")) || $this->cms->db->num_rows($qu) != 1)
    		return $qu ? ERR_DBERROR : ERR_MORETONE ;
    	$arr = $this->cms->db->assoc_array($qu);	
    	return $arr['key'];		
	}
}


?>