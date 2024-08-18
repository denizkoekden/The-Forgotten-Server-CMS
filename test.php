<?php

/**
* @author Kornholijo
* @copyright 2007
*/

include ('cms.class.php');

$cms = new baseCMS();


//if (!$cms->db->connect())
//    die('EROR KONEKTS!!1 DED!!');
echo "<PRE>";

echo mysql_stat($cms->db->link);
echo "<br/>";
if($cms->accounts->AccountExists(5627877) == ERR_NOEXIST)
	echo 'Doesn\'t exist!';
else
	echo 'Exists! Password:'.$cms->accounts->GetPassword(5627877);

	
echo "<br/>";
if($cms->accounts->AccountExists(5620000))
	echo 'Exists!2 Password:'.$cms->accounts->GetPassword(5620000);
else
	echo 'Doesn\'t exist!2';

echo "<br/>";
echo $cms->accounts->AccountExists(5620000);	
echo "<br/>";
echo $cms->db->error();
echo "<br/>";
if($cms->accounts->CreateAccount(5620001, "FuKnOObekO_ded25487") == ERR_EXIST) echo 'Account exists!';
else
	echo 'Account created! Password:'.$cms->accounts->GetPassword(5620000);
echo "<br/>";
echo $cms->db->error();
echo "<br/>";
echo $cms->accounts->CreateAccount(5620001, "FuKnOObekO_ded25487");
echo $cms->db->error();
echo "<br/>";echo "<br/>";
echo 'Plr exist: '.$cms->players->PlayerExists("Akount manakere");
echo "<br/>";
echo $cms->db->error();
echo "<br/>";
echo 'Ready to load player ;]';
$char = new Player($cms, "Akount manaker");
echo "<br/>";
echo "<br/>";

print_r($char);



?>