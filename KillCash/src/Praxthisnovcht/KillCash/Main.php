<?php

namespace Praxthisnovcht\KillCash;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\Server;

class Main extends PluginBase implements Listener{

	public $money;
	
	
	public function onDisable(){
		 $this->getLogger()->info(TextFormat::RED."KillCash unloaded!");
	         }
	public function onEnable(){
		 @mkdir($this->getDataFolder());

      $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML, array(
        "money-Drop"  => 100,
        "money-Lost"  => 100,
            "message-Drop" => "You kill {Name} and earn {Money} coins",
            "message-Lost" => "you was killed by {Name} and lost {Money} coins"
                         ));
        
                             $this->getServer()->getPluginManager()->registerEvents($this, $this);
                                 $load = $this->getServer()->getPluginManager();
                                      if(!($this->money = $load->getPlugin("PocketMoney"))  && !($this->money = $load->getPlugin("EconomyAPI")) && !($this->money = $load->getPlugin("MassiveEconomy"))){
                                         $this->getLogger()->info(TextFormat::GOLD." .KillCash not loaded, I can't find Plugin Economy");
                                             $this->getLogger()->info(TextFormat::GOLD.". Please install:");
                                                 $this->getLogger()->info(TextFormat::GOLD.". MassiveEconomy-EconomyAPI-PocketMoney-EconomyMaster:");
                                                     } else {
                                                         $this->getLogger()->info(TextFormat::GREEN."Using money API from ".
			                                                 TextFormat::GREEN.$this->money->getName()." v".
			                                                     $this->money->getDescription()->getVersion());
																 		 $this->getLogger()->info(TextFormat::GREEN."KillCash Enabled!");
                                                                     }
  }

	public function onPlayerDeath(PlayerDeathEvent $event){
               $entity = $event->getEntity();
        	     $cause = $entity->getLastDamageCause();
			         if($cause instanceof EntityDamageByEntityEvent) {
			           	 $killer = $cause->getDamager()->getPlayer();
									     # CustomMessage
										 $Kmessage = str_replace("{Name}", $entity->getPlayer()->getName(), $this->config->get("message-Drop"));
					                     $Kmessage = str_replace("{Money}", $this->config->get("money-Drop"), $this->config->get("message-Drop"));
										 $killer->sendMessage("$Kmessage");
																				 
										 $Dmessage = str_replace("{Name}", $killer->getPlayer()->getName(), $this->config->get("message-Lost"));
					                     $Dmessage = str_replace("{Money}", $this->config->get("money-Lost"), $this->config->get("message-Lost"));										 
										 $entity>sendMessage("$Dmessage");										 										 
										     # Conclusion
											$this->reduceMoney($entity->getName(), $this->config->get("money-Lost"));
					                         $this->grantMoney($killer->getName(), $this->config->get("money-Drop"));
					                             return true;
				                                 
			                                         }else{
				                                         return true;
			                                                 }
		                                                         
	}
##########################################################################################################################################	
 # V_1.0.1
  public function reduceMoney($p,$money) {
     if(!$this->money) return false;
	    switch($this->money->getName()){
                                     case "EconomyAPI":
                                         $this->money->reduceMoney($p,$this->money->getMoney($p)-$money);
                                             break;												 										
                                                     default:
                                                         return false;
                                                             }
                                                                 return true;
                                                                     }
##############################################################################################################################################
  public function grantMoney($p,$money) {
     if(!$this->money) return false;
        switch($this->money->getName()){
            case "PocketMoney":
                 $this->money->grantMoney($p, $money);
                     break;
                         case "MassiveEconomy":
                             $this->money->payPlayer($p,$money);
                                 break;
                                     case "EconomyAPI":
                                         $this->money->setMoney($p,$this->money->getMoney($p)+$money);
                                             break;												 
										
                                                     default:
                                                         return false;
                                                             }
                                                                 return true;
                                                                     }

}
