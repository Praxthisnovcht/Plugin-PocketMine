<?php

namespace EconomyJobWatch;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;

use Praxthisnovcht\EssentialsPEChat\EssentialsPEChat;
use EconomyJob\onebone\EconomyJob;

class EconomyJobWatch extends PluginBase{
	
	public function onEnable(){
		$this->getLogger()->info("EconomyJobWatch Enabled");
		EssentialsPEChat::getInstance()->registerExtension($this);
	}
}
