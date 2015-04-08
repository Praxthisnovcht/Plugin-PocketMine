<?php

namespace Praxthisnovcht\HeroesRPG;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class HeroesRPG extends PluginBase {

    public function onLoad() {
	    $this->getLogger()->info(TextFormat::YELLOW . "Loading HeroesRPG....");
	    $this->getLogger()->info(TextFormat::YELLOW . "Loading XP | LEVEL In HeroesRPG....");
        
    }
    public function onDisable() {
	    $this->getLogger()->info(TextFormat::RED . "HeroesRPG is Disabled...");        
    }	
    public function onEnable() {
	    @mkdir($this->getDataFolder());
	    @mkdir($this->getDataFolder() . "users/");
        $this->saveDefaultConfig();
        $this->data = $this->getDataFolder();
        $this->config = $this->getConfig()->getAll();
        $this->getServer()->getPluginManager()->registerEvents(new HeroesRPGListener($this), $this);

	    $this->getLogger()->info(TextFormat::GREEN . "HeroesRPG is Enabled, Lets Go Guys !!!!");

	}
    public function RegisterPlayer(Player $player){
    	$data = new Config($this->data . "users/" . strtolower($player->getName() . ".yml"), Config::YAML);
    	$data->set("XP", "0");
    	$data->save();
    }
    public function isPlayerRegistered($player){
    	return file_exists($this->data . "users/" . strtolower($player . ".yml"));
    }
    public function getXP(Player $player) {
    }
    public function AddPlayerXp(Player $player, $amount) {
	
	}
    public function SetXP(Player $player, $amount) {
	
	}

}
