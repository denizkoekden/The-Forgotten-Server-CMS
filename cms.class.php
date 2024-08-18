<?php

/**
* @author 	  Kornholijo
* @desc   	  A simple extendable CMS Class
* @copyright 2007
*/

define(CMS_VERSION, "0.1");
define(MISSING_CMS, 0);

define(CANNOT_KILL_CRITICAL_PLUGIN, -100);

if (MISSING_CONFIG)
    @include ('config.php');

class baseCMS
{
    //var $db, $accounts, $players, $gui;

    private $plugins = array();

    public $devMode = true;
    public $lastLogEntry;

    function __construct()
    {

        if (MISSING_CONFIG)
            $this->fatalError("CMSEXCEPTION: Unable to read config!");
            
		if(!class_exists('DBHandler')) require ($settings['database'] . 'db.php');
		if(!class_exists('Accounts')) require ('accounts.class.php');
		if(!class_exists('Players')) require ('players.class.php');
		if(!class_exists('Gui')) require ('gui.class.php');
		
        if (!$this->loadPlugin(new DBHandler($settings['hostname'], $settings['username'],
            $settings['password'], $settings['dbase'])))
            $this->fatalError('CMSEXCEPTION: Cannot load DBHandler class!');
        if (!$this->loadPlugin(new Accounts))
            $this->fatalError('CMSEXCEPTION: Cannot load Account management class!');
        if (!$this->loadPlugin(new Players))
            $this->fatalError('CMSEXCEPTION: Cannot load Players management class!');
        if (!$this->loadPlugin(new Gui))
            $this->fatalError('CMSEXCEPTION: Cannot load GUI input processing class!');

    }

    public function __destruct()
    {
        foreach ($this->plugins as $name => $obj)
            $this->removePlugin($name);

    }

    private function triggerEvent($eventHandler)
    {
        if (is_array($eventHandler))
        {
            if (method_exists(&$eventHandler[1], $eventHandler[0]))
                $eventHandler[1]->$eventHandler[0]();
        }
        else
        {
            foreach ($this->plugins as $name => $obj)
                if (method_exists($obj, $eventHandler))
                    $this->plugins[$name]->$eventHandler();
        }
    }

    public function gotPlugin($pName)
    {
        foreach ($this->plugins as $name => $obj)
            if ($pName == $name)
                return 1;
        return 0;
    }
    public function loadPlugin($plugin)
    {
        $this->plugins[$plugin->pluginName] = &$plugin;
        $plugin->loadBaseObject($this);
        $this->triggerEvent(array('onAttach', &$plugin));
        return 1;
    }

    public function removePlugin($name, $critRemove = false)
    {
        if (!$critRemove && $this->plugins[$name]->isCritical)
            return CANNOT_KILL_CRITICAL_PLUGIN;

        $this->triggerEvent(array('onDetach', &$this->plugins[$name]));
        unset($this->plugins[$name]);
    }

    public function OutputLogMessage($message)
    {
        $this->lastLogEntry = $message;
        if ($this->devMode)
            echo "{$this->lastLogEntry} <br/>";
        $this->triggerEvent('onLog');
    }
    public function fatalError($message)
    {
        $this->OutputLogMessage($message);
        die($message);
    }
}

?>