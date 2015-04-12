<?php

namespace PurePermsWatch;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;

use Praxthisnovcht\EssentialsPEChat\EssentialsPEChat;
use _64FF00\PurePerms\PurePerms;

class PurePermsWatch extends PluginBase{
	
	public function onEnable(){
		$this->getLogger()->info("PurePermsWatch Enabled");
		EssentialsPEChat::getInstance()->registerExtension($this);
	}
	public function onRegisterPrefix(){
				$isMultiWorldEnabled = $this->pureperms->getConfig()->get("enable-multiworld-formats");
				$levelName = $isMultiWorldEnabled ?  $player->getLevel()->getName() : null;
		EssentialsPEChat::getInstance()->replacePrefix("{PurePerms}", PurePerms::getInstance()->getUser($player)->getGroup($levelName)(EssentialsPEChat::getInstance()->getCurrentEvent()->getPlayer()->getName()));
	}
}
