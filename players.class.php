<?php

/**
* @author Kornholijo
* @desc Class for working with players
* @copyright 2007
*/

class Players
{
	private $cms;
	
    public function loadBaseObject(&$base)
    {
        $this->cms = &$base;
    }

    function PlayerExists($name)
    {    	
    	if(!($qu = $this->cms->db->query("SELECT `name` FROM `players` WHERE `name` = '{$name}'")) || $this->cms->db->num_rows($qu) == 0)
    		return $qu ? ERR_NOEXIST : ERR_DBERROR ;
    	return 1;
    }
    function PlayerExistsA($id)
    {    	
    	if(!($qu = $this->cms->db->query("SELECT `id` FROM `players` WHERE `id` = '{$id}'")) || $this->cms->db->num_rows($qu) == 0)
    		return $qu ? ERR_NOEXIST : ERR_DBERROR  ;
    	return 1;
    }
    function getLevel($name)
    {
    	if($this->PlayerExists($name) == ERR_NOEXIST) return ERR_NOEXIST;
    	
		if(!$qu = $this->cms->db->query("SELECT `level` from `players` WHERE `name` = '{$name}'"))
			return ERR_DBERROR;
		else
			{
				$ret = $this->cms->db->assoc_array($qu);
				return $ret['level'];
			}
	}
	function getLevelA($id)
    {
    	if($this->PlayerExistsA($id) == ERR_NOEXIST) return ERR_NOEXIST;
    	
		if(!$qu = $this->cms->db->query("SELECT `level` from `players` WHERE `id` = {$id}"))
			return ERR_DBERROR;
		else
			{
				$ret = $this->cms->db->assoc_array($qu);
				return $ret['level'];
			}
	}
	function setName($name, $newName)
	{
		if($this->PlayerExists($name) == ERR_NOEXIST) return ERR_NOEXIST;
		
		if(!$this->cms->db->query("UPDATE `players` SET `name` = '{$newName}' WHERE `name` = '{$name}'"))
			return ERR_DBERROR;
		else
			return 1;
	}
	function setNameA($id, $newName)
	{
		if($this->PlayerExistsA($id) == ERR_NOEXIST) return ERR_NOEXIST;
		
		if(!$this->cms->db->query("UPDATE `players` SET `name` = '{$newName}' WHERE `id` = {$id}"))
			return ERR_DBERROR;
		else
			return 1;
	}	
    
}

class Player // oi :o
{
	var $cms, $res, $id, $name, $accNo, $sex, $groupId, $experience, $level, $soul, $capacity, $vocation, $mana, $manaMax, $manaSpent, $magLevel, $health, $healthMax, $blessings, $lookType, $lookHead, $lookBody, $lookLegs, $lookFeet, $lookAddons, $rsTime, $rs, $posx, $posy, $posz, $townid, $rankId, $guildName, $guildLevel, $guildId, $guildRank, $guildNick, $password;
	function Player($cms, $name)
	{
		$this->cms = $cms;
		$this->name = $name;
		$this->loadPlayer();
	}	
	function loadPlayer()
	{
		if($this->cms->players->PlayerExists($this->name) == ERR_NOEXIST) return ERR_NOEXIST;
			
		$ret = $this->cms->db->query("SELECT * FROM `players` WHERE `name` = '{$this->cms->db->escape_string($this->name)}'");	
		if (!$ret) return ERR_DBERROR;
		$res = $this->cms->db->assoc_array($ret);
		
		if(!res) return ERR_DBERROR;
		
		$this->res = $res;
		
		$this->id = $res['id'];
		$this->accNo = $res['account_id'];
		$this->sex = $res['sex'];
		$this->groupId = $res['group_id'];
		$this->experience = $res['experience'];
		$this->level = $res['level'];
		$this->soul = $res['soul'];
		$this->capacity = $res['cap'];
		$this->vocation = $res['vocation'];
		$this->mana = $res['mana'];
		$this->manaMax = $res['manamax'];
		$this->manaSpent = $res['manaspent'];
		$this->magLevel = $res['maglevel'];
		$this->health  = $res['health'];
		$this->healthMax = $res['healthmax'];
		$this->blessings = $res['blessings'];
		$this->lookType = $res['looktype'];
		$this->lookHead = $res['lookhead'];
		$this->lookBody = $res['lookbody'];
		$this->lookLegs = $res['looklegs'];
		$this->lookFeet = $res['lookfeet'];
		$this->lookAddons = $res['lookaddons'];
		$this->rstime = $res['redskulltime'];
		$this->rs = $res['redskull'];
		
		$this->posx = $res['posx'];
		$this->posy = $res['posy'];
		$this->posz = $res['posz'];
		
		$this->townid = $res['town_id'];
		$this->rankId = $res['rank_id'];
		
		$this->guildNick = $res['guildnick'];
		
		return 1;	
	}
}

?>