<?php

namespace MapReset;


use pocketmine\Server;
use pocketmine\utils\Utils;
use pocketmine\utils\Config;
use pocketmine\level\Position;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\AsyncTask;
use pocketmine\level\Level;

class MapResetCountDown extends PluginTask {
	
	public function __construct(Main $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
		$this->length = -1;
    }
    public function onRun($currentTick){
    	$startreset = $this->owner->getConfig()->get("startreset");
    	if($startreset === "no"){
    		$this->owner->getConfig()->set("startreset", "yes"); //The reason why Im doing this is to make sure the map wont reset on onEnable()
    	}
    	elseif($startreser === "yes"){
    		Server::getInstance()->broadcastMessage("[MapReset] Map reseting in $time minute/s!");
    	}
    		
    		
    	}
    }
