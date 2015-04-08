<?php

namespace MassiveEconomyWatch;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;

use Praxthisnovcht\EssentialsPEChat\EssentialsPEChat;
use MassiveEconomy\MassiveEconomyAPI;

class MassiveEconomyWatch extends PluginBase{
	
	public function onEnable(){
		$this->getLogger()->info("MassiveEconomyWatch Enabled");
		EssentialsPEChat::getInstance()->registerExtension($this);
	}
	public function onRegisterPrefix(){
		EssentialsChat::getInstance()->replacePrefix("{MONEY}", MassiveEconomyAPI::getInstance()->getMoney(EssentialsChat::getInstance()->getCurrentEvent()->getPlayer()->getName()));
	}
}