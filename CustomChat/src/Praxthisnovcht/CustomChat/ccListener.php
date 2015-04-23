<?php

namespace Praxthisnovcht\CustomChat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\level\Position;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\tile\Sign;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;


use MassiveEconomy\MassiveEconomyAPI;
use Praxthisnovcht\KillChat\KillChat;
/**
 * PraxListener
 *
 */
class ccListener implements Listener {
	public $plugin;
	private $pureperms;
	public function __construct(ccMain $pg) {
		$this->plugin = $pg;
		// use KillChat\KillChat
		$this->killchat = $this->plugin->getServer()->getPluginManager()->getPlugin("KillChat");
		// Use PurePerms by 64FF00	
		$this->pureperms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		// Use MassiveEconomy
		$this->massive = $this->plugin->getServer()->getPluginManager()->getPlugin("MassiveEconomy");
		
		$this->factionspro = $this->plugin->getServer()->getPluginManager()->getPlugin("FactionsPro");
	}
	public function onPlayerChat(PlayerChatEvent $event) {
		$this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$allowChat = $this->config->get ( "disablechat" );
		// $this->log ( "allowChat ".$allowChat);
		if ($allowChat) {
			$event->setCancelled ( true );
			return;
		}
		
		if (! $allowChat || $allowChat == null) {
			$player = $event->getPlayer ();
		
			$perm = "chatmute";
			// $this->log ( "permission ".$player->isPermissionSet ( $perm ));
			
			if ($player->isPermissionSet ( $perm )) {
				$event->setCancelled ( true );
				return;
			}
			if ($this->config->get("per-world-chat") == true){
					$format = $this->getFormattedMessage ( $player, $event->getMessage () );
			$config_node = $this->config->get ( "enable-formatter" );
			if (isset ( $config_node ) and $config_node === true) {
				foreach($player->getServer()->getOnlinePlayers() as $players){
					if ($players->getLevel()->getName() == $player->getLevel()->getName()){
						$players->sendMessage($format);
					}
				}
				$player->getServer()->getLogger()->info($format);
				$event->setCancelled(true);
				return;
			}
				
			}
			$format = $this->getFormattedMessage ( $player, $event->getMessage () );
			$config_node = $this->config->get ( "enable-formatter" );
			if (isset ( $config_node ) and $config_node === true) {
				$event->setFormat ( $format );
			}
			return;
		}
	}
    public function onPlayerQuit(PlayerQuitEvent $event){ // Thank to Guillaume351 Help Me !
    $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
         $message = $this->config->get("CustomLeave");
             $player = $event->getPlayer();
                 $event->setQuitMessage(null);
                     if($this->factionspro == true && $this->factionspro->isInFaction(strtolower($player->getName()))) {
                         $getUserFaction = $this->factionspro->getPlayerFaction(strtolower($player->getName()));
                             $message = str_replace ( "@Faction", $getUserFaction, $message );
                                 }else{
                                     $nofac = $this->config->get ( "if-player-has-no-faction");
                                         $message = str_replace ( "@Faction", $nofac, $message );
                                             }
                                                 $message = str_replace("@Player", $event->getPlayer()->getDisplayName(), $message);
                                                     foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
                                                         $player->sendPopup($message);
    } 
}
    public function onPlayerJoin(PlayerJoinEvent $event) { // Thank to Guillaume351 Help Me !
     $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
         $player = $event->getPlayer ();
             $this->plugin->formatterPlayerDisplayName ( $player );
                 $message = $this->config->get("CustomJoin");
                     $player = $event->getPlayer();
					     $event->setJoinMessage(null);
                             if($this->factionspro == true && $this->factionspro->isInFaction(strtolower($player->getName()))) {
                                 $getUserFaction = $this->factionspro->getPlayerFaction(strtolower($player->getName()));
                                     $message = str_replace ( "@Faction", $getUserFaction, $message );
                                         }else{
                                             $nofac = $this->plugin->config->get ( "if-player-has-no-faction");
                                                 $message = str_replace ( "@Faction", $nofac, $message );
                                                     }
                                                         $message = str_replace("@Player", $event->getPlayer()->getDisplayName(), $message);
                                                             $this->plugin->formatterPlayerDisplayName ( $player );
                                                                 foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
                                                                     $player->sendPopup($message);
    }  
}
// 	public function formatterPlayerDisplayName(Player $p) {
// 		$playerPrefix = $this->plugin->getConfig ()->get ( $player->getName () );
// 		$defaultPrefix = $this->plugin->getConfig ()->get ( "default-player-prefix" );
		
// 		if ($playerPrefix != null) {
// 			$p->setDisplayName ( $playerPrefix . ":" . $name );
// 			return;
// 		}
		
// 		if ($defaultPrefix != null) {
// 			$p->setDisplayName ( $defaultPrefix . ":" . $name );
// 			return;
// 		}
// 	}
	
	public function getFormattedMessage(Player $player, $message) {
		 $this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$format = $this->config->get ( "chat-format" );
		// $format = "<{PREFIX} {USER_NAME}> {MESSAGE}";	


		if(!$this->pureperms) {
			$format = str_replace("{PurePerms}", "NoGroup", $format);
		}
		if($this->pureperms) {
				$isMultiWorldEnabled = $this->pureperms->getConfig()->get("enable-multiworld-formats");
				$levelName = $isMultiWorldEnabled ?  $player->getLevel()->getName() : null;
                 $format = str_replace("{PurePerms}", $this->pureperms->getUser($player)->getGroup($levelName)->getName(), $format);
            } else {
                return false;
                }
		if($this->killchat) {
			$format = str_replace ( "{Kills}", KillChat::getInstance()->getKills($player->getName()), $format); 
		}else{
			$format = str_replace ( "{Kills}", "ERROR", $format);
		}
		if($this->killchat) {
			$format = str_replace ( "{Deaths}", KillChat::getInstance()->getDeaths($player->getName()), $format); 
		}else{
			$format = str_replace ( "{Deaths}", "ERROR", $format);
		}
		if($this->massive) {
			$format = str_replace ( "{Money}", MassiveEconomyAPI::getInstance()->getMoney($player->getName()), $format); 
		}else{
			$format = str_replace ( "{Money}", "ERROR", $format);
		}
		if($this->factionspro == true && $this->factionspro->isInFaction($player->getName())) {
			$getUserFaction = $this->factionspro->getPlayerFaction($player->getName()); 
			$format = str_replace ( "{FACTION}", $getUserFaction, $format );
		}else{
			$nofac = $this->config->get ( "if-player-has-no-faction");
			$format = str_replace ( "{FACTION}", $nofac, $format );
		}
		$tags = null;
		$playerTags = $this->config->get ( $player->getName ().".tags" );
		if ($playerTags != null) {
			$tags = $playerTags;
		} else {
			//use default tags
			$tags = $this->config->get ( "default-player-tags");
		}				
		if ($tags == null) {
			 $tags = "";
		         }
		             $format = str_replace ( "{TAGS}", $tags, $format );
		                 return $format;





		
		$format = str_replace ( "{WORLD_NAME}", $player->getLevel ()->getName (), $format );
		
		$nick = $this->config->get ( $player->getName () > ".nick");
		if ($nick!=null) {
			$format = str_replace ( "{DISPLAY_NAME}", $nick, $format );
		} else {
			$format = str_replace ( "{DISPLAY_NAME}", $player->getName (), $format );			
		}
		
		$format = str_replace ( "{MESSAGE}", $message, $format );
		
		$level = $player->getLevel ()->getName ();
		
		$prefix = null;
			 $this->playerConfig = new Config($this->getDataFolder()."players/".$player->getName().".yml", Config::YAML);
		$playerPrefix = $this->playerConfig->get ( $player->getName ().".prefix" );
		if ($playerPrefix != null) {
			$prefix = $playerPrefix;
		} else {
			//use default prefix
			$prefix = $this->config->get ( "default-player-prefix");
		}				
		if ($prefix == null) {
			$prefix = "";
		}
		$format = str_replace ( "{PREFIX}", $prefix, $format );
		return $format;
	}
	private function log($msg) {
		$this->plugin->getLogger ()->info ( $msg );
	}
}
