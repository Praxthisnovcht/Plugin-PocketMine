<?php

namespace Praxthisnovcht\CustomChat;

use pocketmine\scheduler\PluginTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Praxthisnovcht\CustomChat;

class ccTask extends PluginTask{

    public function __construct(ccMain $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
		$this->message = $message;
    }
    public function onRun($currentTick){
        $this->getOwner();
        $this->plugin->config_message = $this->owner->ccMain::getInstance()->getMCfg();
    	if($this->config_message->get("Enable-AutoMessage")==true){
//        $message = $messages[$messagekey];
        $this->owner->getServer()->broadcastMessage($this->plugin->configFile($this->config_message->get["Prefix"]."): ".$message);
         }
    }
}
