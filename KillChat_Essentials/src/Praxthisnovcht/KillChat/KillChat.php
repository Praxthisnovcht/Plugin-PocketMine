<?php
/** Thanks to EvolSoft to help me rewrite plugin CustomChat<EssentialsChat
/* Website:
/* Page Github:
/* PocketMine Forums:
 *
 *
 */
namespace Praxthisnovcht\KillChat;

use pocketmine\IPlayer;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\Listener;

use Praxthisnovcht\EssentialsPEChat\EssentialsPEChat;

class KillChat extends PluginBase implements Listener{
	
	public $data;
	
	private static $object = null;
	
	public static function getInstance(){
		return self::$object;
	}
	
	public function onLoad(){
		if(!self::$object instanceof KillChat){
			self::$object = $this;
		}
		$this->data = $this->getDataFolder();
	}
	
	public function onEnable(){
		@mkdir($this->getDataFolder());
		@mkdir($this->getDataFolder() . "data/");
		$this->getLogger()->info(TextFormat::GREEN . "KillChat extension for EssentialsPEChat enabled");
		EssentialsPEChat::getInstance()->registerExtension($this); //Register this plugin as EssentialsPEChat extension
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onRegisterPrefix(){
		EssentialsPEChat::getInstance()->replacePrefix("{Kills}", $this->getKills(EssentialsPEChat::getInstance()->getCurrentEvent()->getPlayer()->getName()));
		EssentialsPEChat::getInstance()->replacePrefix("{Deaths}", $this->getDeaths(EssentialsPEChat::getInstance()->getCurrentEvent()->getPlayer()->getName()));
	}
	
	public function onPlayerDeath(PlayerDeathEvent $event){
		//Getting Victim
		$victim = $event->getEntity(); 
		if($victim instanceof Player){
			$vdata = new Config($this->getDataFolder() . "data/" . strtolower($victim->getName()) . ".yml", Config::YAML);
			//Check victim data
			if($vdata->exists("kills") && $vdata->exists("deaths")){
				$vdata->set("deaths", $vdata->get("deaths") + 1);
				$vdata->save();
			}else{
				$vdata->setAll(array("kills" => 0, "deaths" => 1)); //Add first death
				$vdata->save();
			}
			$cause = $event->getEntity()->getLastDamageCause()->getCause();
			if($cause == 1){ //Killer is an entity
				//Get Killer Entity
				$killer = $event->getEntity()->getLastDamageCause()->getDamager();
				//Get if the killer is a player
				if($killer instanceof Player){
					//Get killer data
					$kdata = new Config($this->getDataFolder() . "data/" . strtolower($killer->getName()) . ".yml", Config::YAML);
					//Check killer data
					if($kdata->exists("kills") && $kdata->exists("deaths")){
						$kdata->set("kills", $kdata->get("kills") + 1);
						$kdata->save();
					}else{
						$kdata->setAll(array("kills" => 1, "deaths" => 0)); //Add first kill
						$kdata->save();
					}
				}
			}
		}
	}
	
	public function getKills($player){
		$data = new Config($this->getDataFolder() . "data/" . strtolower($player) . ".yml", Config::YAML);
		//Check data
		if($data->exists("kills") && $data->exists("deaths")){
			return $data->get("kills");
		}else{
			$data->setAll(array("kills" => 0, "deaths" => 0));
			$data->save();
		}
	}
	
	public function getDeaths($player){
		$data = new Config($this->getDataFolder() . "data/" . strtolower($player) . ".yml", Config::YAML);
		//Check data
		if($data->exists("kills") && $data->exists("deaths")){
			return $data->get("deaths");
		}else{
			$data->setAll(array("kills" => 0, "deaths" => 0));
			$data->save();
		}
	}
	
}

