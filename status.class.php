<?php

/**
 * @author Kornholijo
 * @copyright 2007
 */

/* TODO: Maybe use domdoc to parse info? */
class Status
{
	var $hostname, $port;
	
	var $online = 0, $xmlstr;
	
	var $players, $playerspeak, $playersmax, $monsters;
	
	var $uptime_h, $uptime_m; 
	
	function Status($hostname = "localhost", $port = 7171)
	{
		$this->hostname = $hostname;
		$this->port = $port;
		$this->update();
		
	}
	function update()
	{
		$fp = @fsockopen($this->hostname, $this->port, $errno, $errstr, 3);
		if ($fp)
		{
			fwrite($fp, chr(6).chr(0).chr(255).chr(255).'info');
			
			while(!feof($fp))
				$this->xmlstr .= fgets($fp, 32);
				
			preg_match('/players online="(\d+)" max="(\d+)" peak="(\d+)"/', $this->xmlstr, $regexTmp);
			
			$this->players 	   = $regexTmp[1];
			$this->playersmax  = $regexTmp[2];
			$this->playerspeak = $regexTmp[3]; 
			
			preg_match('/monsters total="(\d+)"/', $this->xmlstr, $regexTmp);
			
			$this->monsters = $regexTmp[1];
			
			preg_match('/uptime="(\d+)"/', $this->xmlstr, $regexTmp); 
			
			$this->uptime_h = floor($regexTmp[1] / 3600); 
			$this->uptime_m = floor(($regexTmp[1] - $this->uptime_h * 3600) / 60); 
			
			$this->online = 1;
		} else {
			$this->online = 0;
		}
	}
}

$test = new Status("localhost", 7171);
echo $test->online.' are onlain FPD(((((FILHAHOS PUTA DEDDEDED))))) CeiVBOTen bekus hav munstrer manisS ==== '.$test->monsters;
?>