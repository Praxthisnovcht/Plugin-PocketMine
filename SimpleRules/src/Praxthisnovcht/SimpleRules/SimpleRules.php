<?php

namespace Praxthisnovcht\SimpleRules;


use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class SimpleRules extends PluginBase{
	
	public function onEnable(){
		@mkdir($this->getDataFolder());
		
		if(!file_exists($this->getDataFolder() . "config.yml")){
			file_put_contents($this->getDataFolder() . "config.yml",yaml_emit(array()));
		}
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
				// Create the folder plugin.yml
				"Rules1" => "No right to Spam chatting!",
				"Rules2" => "No right to use mod",				
				"Rules3" => "No right to contact admin to Give / Item",				
				"Rules4" => "No right to Grief other players",
				"Rules5" => "No right to be rude in chat",
		]);
		$this->getLogger()->info(TextFormat::GREEN ."-SimpleRules Enabled!");
    }	    	
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		switch($command->getName()){
			case "rules":
			    $sender->sendMessage(TextFormat::GREEN ."|##|SimpleRules |##|");
				$sender->sendMessage($this->config->get("Rules1"));
				$sender->sendMessage($this->config->get("Rules2"));
				$sender->sendMessage($this->config->get("Rules3"));
				$sender->sendMessage($this->config->get("Rules4"));
				$sender->sendMessage($this->config->get("Rules5"));
//				$sender->sendMessage($this->config->get("wait"));			Next Small Version
				return true;
	}
}
  }
