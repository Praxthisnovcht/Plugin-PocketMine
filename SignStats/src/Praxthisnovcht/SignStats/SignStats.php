<?php
namespace Praxthisnovcht\SignStats;
# based on KillChat
use pocketmine\IPlayer;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\tile\Sign;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;

// use Praxthisnovcht\SignStats\Time;




class SignStats extends PluginBase implements Listener{
	
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
		$this->getLogger()->info(TextFormat::GREEN . "SignStats Enabled");
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new Time($this), 10);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	
	public function onSignChange(SignChangeEvent $event){
	$player = $event->getPlayer();
		if(strtolower(trim($event->getLine(0))) == "stats" || strtolower(trim($event->getLine(0))) == "[STATS]"){
			if($player->hasPermission("signstats.perms.sign")){
			          $Kills = $player->getKills();
			          $Deaths = $player->getDeaths();   
			          $Ratio = $player->getKills();     					  
				$event->setLine(0,"[SignStats]");
				$event->setLine(1,"[Kills :".$Kills."]");
				$event->setLine(2,"[Deaths :".$Deaths."]");
				$event->setLine(3,"[Ratio :".$getKdRatio."]");		
				
				$event->getPlayer()->sendMessage("[SignStats] SignStats created successfully !");
			}else{
				$player->sendMessage("[SignStats] You don't have permissions!");
				
				$event->setLine(0,"[ACESS DENIED]");
				$event->setLine(1,"[ACESS DENIED]");
				$event->setLine(2,"[ACESS DENIED]");
				$event->setLine(3,"[ACESS DENIED]");
				
			}
		}
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
	  if($player->hasPermission("signstats.commands.stats")){
		switch($command->getName()){
				$player = $event->getPlayer();
					  $Kills = $player->getKills();
			          $Deaths = $player->getDeaths();   
			          $Ratio = $player->getKdRatio();  
			case "stats":
		$sender->sendMessage(TextFormat::GREEN ."====== Vos stats =====");
		$sender->sendMessage(TextFormat::GREEN ."- Kills : " . $Kills);
		$sender->sendMessage(TextFormat::GREEN ."- Deaths : " . $Deaths );
		$sender->sendMessage(TextFormat::GREEN ."- Ratio : " . $getKdRatio);
		$sender->sendMessage(TextFormat::GREEN ."=====================");
				return true;
		        }
	        }
			}else{
				$player->sendMessage("[SignStats] You don't have permissions!");
		
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
	
/**

@param int $kills

@param int $deaths

@param int $digits default 3 decimal places

@return string

*/

    function getKdRatio($kills, $deaths, $digits = 3){

        if($deaths === 0) return "N/A";

            $ratio = (string) round($kills / $deaths, $digits);
            return rtrim($ratio, " 0.");
  
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

