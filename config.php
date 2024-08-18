<?
/* TheForgottenServer CMS Settings */

# THIS FILE WILL BE OVERWRITTEN WHEN EDITED FROM ADMINCP #

define(MISSING_CONFIG, 0);

include('rom.php');

$settings = Array(
			
			'server_name' => "The Official TFS Server", 		/* Our server name which will be displayed on each page */
			'cms_url'	  => "http://tfscms.kornholijo.net", 	/* URL at which we can access CMS */
			'auto_update' => true, 								/* Should TFSCMS download updates? */
			'database'    => 'mysql',							/* The type of DB server uses */
			'language'	  => 'eng',								/* Language in which everything will be written */
			/* Database settings */
			'hostname'	  => 'localhost',
			'username'	  => 'tfs',
			'password'    => '',
			'dbase'		  => 'tfs'
);

?>