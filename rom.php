<?php

/**
* @author Kornholijo
* @desc	Read-Only-Memory, *giggles* <:o)
* @copyright 2007
*/

$rom = array('MIN_MYSQL_DBH_VER' => 0x100B,
			 'MIN_ACCS_VER' 	 => 0x100A,
			 'MIN_PLRS_VER' 	 => 0x100A, 
			 'MIN_GUI_VER' 		 => 0x100A
			);

/* Error Codes ._. */ 

// Misc
define(ERR_NOTNUMBER, -1001);
define(ERR_NOEXIST, -1002);
define(ERR_DBERROR, -1003);
define(ERR_MORETONE, -1004);
define(ERR_EXIST, -1005);

?>