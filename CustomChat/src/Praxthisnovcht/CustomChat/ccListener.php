<?php

namespace Praxthisnovcht\CustomChat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
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
	public $pgin;
	private $pureperms;
	public function __construct(ccMain $pg) {
		$this->pgin = $pg;
		// use KillChat\KillChat
		$this->killchat = $this->pgin->getServer()->getPluginManager()->getPlugin("KillChat");
		// Use PurePerms by 64FF00	
		$this->pureperms = $this->pgin->getServer()->getPluginManager()->getPlugin("PurePerms");
		// Use MassiveEconomy
		$this->massive = $this->pgin->getServer()->getPluginManager()->getPlugin("MassiveEconomy");
		
		$this->factionspro = $this->pgin->getServer()->getPluginManager()->getPlugin("FactionsPro");
	}
	public function onPlayerChat(PlayerChatEvent $event) {
		$allowChat = $this->pgin->getConfig ()->get ( "disablechat" );
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
			$format = $this->getFormattedMessage ( $player, $event->getMessage () );
			$config_node = $this->pgin->getConfig ()->get ( "enable-formatter" );
			if (isset ( $config_node ) and $config_node === true) {
				$event->setFormat ( $format );
			}
			return;
		}
	}
	public function onPlayerJoin(PlayerJoinEvent $event) {
		$player = $event->getPlayer ();
		$this->pgin->formatterPlayerDisplayName ( $player );
	}
// 	public function formatterPlayerDisplayName(Player $p) {
// 		$playerPrefix = $this->pgin->getConfig ()->get ( $player->getName () );
// 		$defaultPrefix = $this->pgin->getConfig ()->get ( "default-player-prefix" );
		
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
		$format = $this->pgin->getConfig ()->get ( "chat-format" );
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
			$nofac = $this->pgin->getConfig ()->get ( "if-player-has-no-faction");
			$format = str_replace ( "{FACTION}", $nofac, $format );
		}





		
		$format = str_replace ( "{WORLD_NAME}", $player->getLevel ()->getName (), $format );
		
		$nick = $this->pgin->getConfig ()->get ( $player->getName () > ".nick");
		if ($nick!=null) {
			$format = str_replace ( "{DISPLAY_NAME}", $nick, $format );
		} else {
			$format = str_replace ( "{DISPLAY_NAME}", $player->getName (), $format );			
		}
		
		$format = str_replace ( "{MESSAGE}", $message, $format );
		
		$level = $player->getLevel ()->getName ();
		
		$prefix = null;
		$playerPrefix = $this->pgin->getConfig ()->get ( $player->getName ().".prefix" );
		if ($playerPrefix != null) {
			$prefix = $playerPrefix;
		} else {
			//use default prefix
			$prefix = $this->pgin->getConfig ()->get ( "default-player-prefix");
		}				
		if ($prefix == null) {
			$prefix = "";
		}
		$format = str_replace ( "{PREFIX}", $prefix, $format );
		return $format;
	}
	private function log($msg) {
		$this->pgin->getLogger ()->info ( $msg );
	}
}
