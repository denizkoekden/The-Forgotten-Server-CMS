<?php
/**
* @author Kornholijo
* @copyright 2007
*/

define(CANNOT_KILL_CRITICAL_PLUGIN, -100);

class xFile
{
    public $filename, $handle;
    function __construct($file, $flags)
    {
        $this->filename = $file;
        $this->handle = fopen($file, $flags);

    }
    function __destruct()
    {
        fclose($this->handle);
    }
    function write($content)
    {
        if (is_writable($this->filename) && $this->handle)
            if (fwrite($this->handle, $content) === false)
				return 0;
		return 1;
    }
    function readFull()
    {
		return fread($this->handle, filesize($this->filename));
	}
}

class fooBar
{
    private $base;
    public $pluginName = 'fooBar';
    public $isCritical = false;

    private $logMode = 1;

    public function loadBaseObject(&$base)
    {
        $this->base = &$base;
    }

    public function onAttach()
    {
        $this->base->OutputLogMessage("FooBar has born!");
    }

    public function onDetach()
    {
        $this->base->OutputLogMessage("FooBar died, aew!");
    }
}

class logManager
{
    private $base;
    private $logFile;
    public $pluginName = 'logManager';
    public $isCritical = true;// we never die ;)

	public function __construct()
	{
		$this->logFile = new xFile('test.log', 'a+');
		$this->logFile->write("---------------------------------------------------------------\r\n");
		$this->logFile->write('-logManager-for-TFSCMS v0.2alpha bootUp @ '. date("ymd.his") ."\r\n");
		$this->logFile->write("---------------------------------------------------------------\r\n");
	}
    public function loadBaseObject(&$base)
    {
        $this->base = &$base;
    }

    public function onAttach()
    {
        $this->base->OutputLogMessage("logManager attached!");
    }

    public function onLog()
    {
        $this->logFile->write("{$this->base->lastLogEntry}\r\n");
    }

    public function onDetach()
    {
        $this->base->OutputLogMessage("logManager detached!");
    }
}

class baseClass
{
    private $plugins = array();

    public $devMode = true;
    public $lastLogEntry;

    public function __construct()
    {
        //
    }
    public function __destruct()
    {
        //print_r($this);

        foreach ($this->plugins as $name => $obj)
            $this->removePlugin($name);
        //foreach ($this->plugins as $name)
        //       $this->removePlugin($name);
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

    public function loadPlugin($plugin)
    {
        $this->plugins[$plugin->pluginName] = &$plugin;
        $plugin->loadBaseObject($this);
        $this->triggerEvent(array('onAttach', &$plugin));
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
        //$this->triggerEvent('onBeforeLog');
    }
}
$base = new baseClass;
$base->loadPlugin(new logManager);
$base->loadPlugin(new foobar);
$base->OutputLogMessage('hiHo logmanager!');
?>