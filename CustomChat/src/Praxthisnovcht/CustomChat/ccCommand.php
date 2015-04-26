<?php

namespace Praxthisnovcht\CustomChat;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

/**
 * Command
 *
 */
class ccCommand {
	private $plugin;
	/**
	 *
	 * @param
	 *        	$pg
	 */
	public function __construct(ccMain $pg) {
		$this->plugin = $pg;
	}

	
	/**
	 * onCommand
	 *
	 * @param CommandSender $sender        	
	 * @param Command $command        	
	 * @param unknown $label        	
	 * @param array $args        	
	 * @return boolean
	 */
    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		 $this->config = ccMain::getInstance()->getCfg();

		if ((strtolower ( $command->getName () ) == "customchat")) {
			$sender->sendMessage (TextFormat::RED . "-==[CustomChat]==-");
			$sender->sendMessage (TextFormat::RED . "Usage: /mute <player>");
			$sender->sendMessage (TextFormat::RED . "Usage: /unmute <player>");
			$sender->sendMessage (TextFormat::RED . "Usage: /delprefix <player>");
			$sender->sendMessage (TextFormat::RED . "Usage: /enablechat");	
			$sender->sendMessage (TextFormat::RED . "Usage: /disablechat");	
			$sender->sendMessage (TextFormat::RED . "Usage: /enableworld");	
			$sender->sendMessage (TextFormat::RED . "Usage: /disableworld");	
			$sender->sendMessage (TextFormat::RED . "Usage: /defprefix <Prefix>");
			$sender->sendMessage (TextFormat::RED . "Usage: /setprefix <Prefix> <player>");
			$sender->sendMessage (TextFormat::RED . "Usage: /setnick <Nick> <player>");
			$sender->sendMessage (TextFormat::RED . "Usage: /delnick <player>");
			return;
		}
		// disable chat for all players
		if ((strtolower ( $command->getName () ) == "disablechat")) {
		 $this->config = ccMain::getInstance()->getCfg();
			$this->config->set ( "disablechat", true ); // config.yml
			$this->config->save ();
			$sender->sendMessage (TextFormat::RED . "[CustomChat] Disable chat for all Players" );
			$this->log ( "[CustomChat] Disable chat for all Players" );
			return;
		}
		// enable chat for all players
		if ((strtolower ( $command->getName () ) == "enablechat")) {
		    $this->config = ccMain::getInstance()->getCfg();
			$this->config->set ( "disablechat", false ); // config.yml
            $this->config->save ();
			$sender->sendMessage (TextFormat::GREEN . "[CustomChat] Enable chat for all Players" );
			$this->log ( "[CustomChat] Enable chat for all Players" );
			return;
		}		
		// sets default prefix for new players
		if ((strtolower ( $command->getName () ) == "defprefix") && isset ( $args [0] )) {
//					if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /defprefix <Player> <Prefix>");
//				return true;
//			}
			$playerName = $args [0];
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Player " . $playerName . " is not Online!" );
				return true;
			}
			$prefix = $args [1];
			$this->config->set ( "default-player-prefix", $prefix );
			$this->config->save ();
			$sender->sendMessage (TextFormat::RED . "[CustomChat] All players default prefix set to " . $args [1] );
			return;
		}		
		// sets prefix for player
		if ((strtolower ( $command->getName () ) == "setprefix") && isset ( $args [0] ) && isset ( $args [1] )) {
//				if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /setprefix <Player> <Prefix>");
//				return true;
//			}		
		$playerName = $args [0];
		 	  $this->playerConfig = ccMain::getInstance()->getPlCfg($playerName);
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Player " . $playerName . " is not Online!" );
				return true;
			}
			$prefix = $args [1];
			$this->playerConfig->set ( $p->getName ().".prefix", $prefix );
			$this->playerConfig->save ();
			
			// $p->setDisplayName($prefix.":".$name);
			$this->plugin->formatterPlayerDisplayName ( $p );
			$sender->sendMessage (TextFormat::GREEN . $p->getName () . "[CustomChat] Prefix set to " . $args [1] );
			return;
		}		
		// set player's prefix to default.
		if ((strtolower ( $command->getName () ) == "delprefix") && isset ( $args [0] )) {
//				if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /delprefix <Player>");
//				return true;
//			}	
			$playerName = $args [0];
			  $this->playerConfig = ccMain::getInstance()->getPlCfg($playerName);
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Player " . $playerName . " is not Online!" );
				return true;
			}
			$this->playerConfig->remove ( $p->getName () . ".prefix" );
			$this->playerConfig->save ();
			$sender->sendMessage (TextFormat::RED . $p->getName () . "[CustomChat] Prefix set to Default" );
			return;
		}		
		// sets nick for player
		if ((strtolower ( $command->getName () ) == "setnick") && isset ( $args [0] ) && isset ( $args [1] )) {
//				if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /setnick <Player> <Nick>");
//				return true;
//			}	
			$playerName = $args [0];
		     $this->playerConfig = ccMain::getInstance()->getPlCfg($playerName);
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Player " . $playerName . " is not Online!" );
				return true;
			}
			$nick = $args [1];
			$this->playerConfig->set ( $p->getName () . ".nick", $nick );
			$this->playerConfig->save ();
			
			$this->plugin->formatterPlayerDisplayName ( $p );
			$sender->sendMessage (TextFormat::GREEN . $p->getName () . "[CustomChat] Nick name set to " . $args [1] );
			return;
		}
		// sets nick for player
		if ((strtolower ( $command->getName () ) == "delnick") && isset ( $args [0] ) && isset ( $args [1] )) {
//				if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /delnick <Player>");
//				return true;
//			}	
			$playerName = $args [0];
	     		  $this->playerConfig = ccMain::getInstance()->getPlCfg($playerName);
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Players " . $playerName . " is not Online!" );
				return true; 
			}
			$nick = $args [1];
			$this->playerConfig->remove ( $p->getName () . ".nick" );
			$this->playerConfig->save ();
			// save yml
			
			$this->plugin->formatterPlayerDisplayName ( $p );
			$sender->sendMessage (TextFormat::GREEN . $p->getName () . "[CustomChat] Nick removed !" );
			return;
		}		
		// mute player from chat
		if ((strtolower ( $command->getName () ) == "mute") && isset ( $args [0] )) {
//				if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /mute <Player>");
//				return true;
//			}	
			$playerName = $args [0];
			// check if the player exist
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Players " . $playerName . " is not Online!" );
				return true;
			}
			$perm = "chatmute";
			$p->addAttachment ( $this->plugin, $perm, true );
			$sender->sendMessage (TextFormat::GREEN . $p->getName () . " chat muted" );
			// $this->log ( "isPermissionSet " . $p->isPermissionSet ( $perm ) );
			return;
		}
		// - unmute player from chat
		if ((strtolower ( $command->getName () ) == "unmute") && isset ( $args [0] )) {
//			if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /unmute <Player>");
//				return true;
//			}	

			$playerName = $args [0];
			// check if the player exist
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Players " . $playerName . " is not Online!" );
				return true;
			}
			$perm = "chatmute";
			foreach ( $p->getEffectivePermissions () as $pm ) {
				if ($pm->getPermission () == $perm) {
					// $this->log ( "remove attachements " . $pm->getValue () );
					$p->removeAttachment ( $pm->getAttachment () );
					$sender->sendMessage (TextFormat::GREEN . $p->getName () . "[CustomChat] Chat unmuted" );
					return;
				}
			}
			$sender->sendMessage (TextFormat::RED . $p->getName () . "[CustomChat] Already unmuted" );
			// $this->log ( "isPermissionSet " . $p->isPermissionSet ( $perm ) );
			return; // next try again
			
		}
// TAGS
		// sets default tags for new players
		if ((strtolower ( $command->getName () ) == "deftags") && isset ( $args [0] )) {
//			if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /deftags <Player> <Tags>");
//				return true;
//			}	
			$playerName = $args [0];
			$this->config = ccMain::getInstance()->getCfg();
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Players " . $playerName . " is not Online!" );
				return true;
			}
			$tags = $args [1];
			$this->config->set ( "default-player-tags", $tags );
			$this->config->save ();
			$sender->sendMessage (TextFormat::RED . "[CustomChat] All players default tags set to " . $args [1] );
			return;
		}
		
		// sets tags for player
		if ((strtolower ( $command->getName () ) == "tags") && isset ( $args [0] ) && isset ( $args [1] )) {
//			if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /tags <Player> <Tags>");
//				return true;
//			}	
			$playerName = $args [0];
			  $this->playerConfig = ccMain::getInstance()->getPlCfg($playerName);
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Player " . $playerName . " is not Online!" );
				return true;
			}
			$tags = $args [1];
			$this->playerConfig->set ( $p->getName ().".tags", $tags );
			$this->playerConfig->save ();
			
			// $p->setDisplayName($tags.":".$name);
			$this->plugin->formatterPlayerDisplayName ( $p );
			$sender->sendMessage (TextFormat::GREEN . $p->getName () . "[CustomChat] Tags set to " . $args [1] );
			return;
		}
		
		// set player's tags to default.
		if ((strtolower ( $command->getName () ) == "deltags") && isset ( $args [0] )) {
//			if(empty($args[0])) {
//				$sender->sendMessage (TextFormat::DARK_BLUE ."Usage: /tags <Player>");
//				return true;
//			}	
			$playerName = $args [0];
	     	  $this->playerConfig = ccMain::getInstance()->getPlCfg($playerName);
			$p = $sender->getServer ()->getPlayerExact ( $playerName );
			if ($p == null) {
				$sender->sendMessage (TextFormat::RED . "[CustomChat] Player " . $playerName . " is not Online!" );
				return true;
			}
			$this->playerConfig->remove ( $p->getName () . ".tags" );
			$this->playerConfig->getConfig ()->save ();
			$sender->sendMessage (TextFormat::RED . $p->getName () . "[CustomChat] Tags set to default" );
			return;
		}
		// disable PerWorldChat for all players
		if ((strtolower ( $command->getName () ) == "disableworld")) {
		    $this->config = ccMain::getInstance()->getCfg();
			$this->config->set ( "per-world-chat", false ); // config.yml
			$this->config->save ();
			$sender->sendMessage (TextFormat::RED . "[CustomChat] Disable PerWorldChat for all players" );
			$this->log ( "[CustomChat] Disable PerWorldChat for all players" );
			return;
		}
		// enable PerWorldChat for all players
		if ((strtolower ( $command->getName () ) == "enableworld")) {	
		    $this->config = ccMain::getInstance()->getCfg();
			$this->config->set ( "per-world-chat", true ); // config.yml
			$this->config->getConfig ()->save ();
			$sender->sendMessage (TextFormat::GREEN . "[CustomChat] Enable PerWorldChat for all players" );
			$this->log ( "[CustomChat] Enable PerWorldChat for all players" );
			return;
		}
		if ((strtolower ( $command->getName () ) == "alert")) {
			     $this->config_message = ccMain::getInstance()->getMCfg();
                     if (isset($args[0])) {
                         Server::getInstance()->broadcastMessage((" §d[SERVER] ".implode(" ", $args)));
                             }
                                 else {
                                     $sender->sendMessage("Usage: /alert <Message>");
                                         }
                                             return;			
	}
}
	             // TODO NEXT VERSION
	
	private function hasCommandAccess(CommandSender $sender) {
		if ($sender->getName () == "CONSOLE") {
			return true;
		} elseif ($sender->isOp ()) {
			return true;
		}
		return false;
	}
	
	/**
	 * Logging util function
	 *
	 * @param unknown $msg        	
	 */
	private function log($msg) {
		$this->plugin->getLogger ()->info ( $msg );
	}
}
