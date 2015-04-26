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
        $this->duration = $duration;
    }
    public function onRun($currentTick){  	
    }
}
