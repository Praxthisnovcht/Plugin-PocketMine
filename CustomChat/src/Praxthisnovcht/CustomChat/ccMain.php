<?php

namespace Praxthisnovcht\CustomChat;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
# Addon For CustomChat
use Praxthisnovcht\KillChat\KillChat; 
use MassiveEconomy\MassiveEconomyAPI;
/**
 * Main
 *        
 */
class ccMain extends PluginBase implements CommandExecutor {

	private $factionspro, $pureperms, $economyjob, $playerstats;

	public $swCommand;
    public $cfg;   
    public $users;
	
	/**
	 * OnLoad
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onLoad()
	 */
	public function onLoad() {
       	$this->users = $this->getDataFolder();
	    $this->getLogger()->info(TextFormat::YELLOW . "Loading CustomChat v_1.4.5 by Praxthisnovcht");
		$this->swCommand = new ccCommand ( $this );
	}
	
	/**
	 * OnEnable
	 *
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onEnable()
	 */
	public function onEnable() {
	    @mkdir($this->getDataFolder());
	         @mkdir($this->getDataFolder() . "users/");
                 $this->saveDefaultConfig();
                     $this->users = $this->getDataFolder();
                         $this->cfg = $this->getConfig()->getAll();
		                     $this->enabled = true;
				// Use PurePerms by 64FF00	
		if(!$this->getServer()->getPluginManager()->getPlugin("PurePerms") == false) {
			$this->pureperms = $this->getServer()->getPluginManager()->getPlugin("PurePerms ");
			$this->log ( TextFormat::GREEN . "- CustomChat - Loaded With PurePerms !" );
		}
		if(!$this->getServer()->getPluginManager()->getPlugin("KillChat") == false) {
			$kl_chat = Server::getInstance()->getPluginManager()->getPlugin("KillChat");
			$this->log ( TextFormat::YELLOW . "- CustomChat - Loaded With KillChat !" );
		}
		if(!$this->getServer()->getPluginManager()->getPlugin("MassiveEconomy") == false) {
			$me_money = Server::getInstance()->getPluginManager()->getPlugin("MassiveEconomy");
			$this->log ( TextFormat::GREEN . "- CustomChat - Loaded With MassiveEconomy !" );
		}
		if(!$this->getServer()->getPluginManager()->getPlugin("FactionsPro") == false) {
			$this->factionspro = $this->getServer()->getPluginManager()->getPlugin("FactionsPro");
			$this->log ( TextFormat::GREEN . "- CustomChat - Loaded With FactionsPro!" );
		}
		$this->getServer()->getPluginManager()->registerEvents(new ccListener($this), $this);
		$this->log ( TextFormat::GREEN . "- CustomChat - Enabled!" );

	}
	
	/**
	 * OnDisable
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onDisable()
	 */
	public function onDisable() {
		$this->log ( TextFormat::RED . "CustomChat - Disabled" );
		$this->enabled = false;
	}
	
	/**
	 * OnCommand
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onCommand()
	 */
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		$this->swCommand->onCommand ( $sender, $command, $label, $args );
	}
	
	public function formatterPlayerDisplayName(Player $p) {
		$prefix=null;
             $this->users = $this->getDataFolder();
		         $playerPrefix = $this->users->get ( $p->getName ().".prefix" ); 106
		             if ($playerPrefix != null) {
			             $prefix = $playerPrefix;
		                     } else {
			                     //use default prefix
                                         $this->cfg = $this->getConfig()->getAll();
			                                  $prefix = $this->cfg ()->get ( "default-player-prefix");
		                                         }
	
		                                             //check if player has nick name
                                                         $this->users = $this->getDataFolder();
		                                                     $nick = $this->users ()->get ( $p->getName().".nick");
		                                                         if ($nick!=null && $prefix!=null) {
			                                                         $p->setNameTag( $prefix . ":" . $nick );
			                                                             return;
		                                                                     }
		                                                                         if ($nick!=null && $prefix==null) {
			                                                                         $p->setNameTag($nick );
			                                                                                 return;
		                                                                                         }
		                                                                                             if ($nick==null && $prefix!=null) {
			                                                                                             $p->setNameTag($prefix . ":".$p->getName());
			                                                                                                 return;
		                                                                                                         }
	
		                                                                                                             //default to regular name
		                                                                                                                 $p->setNameTag($p->getName());
		                                                                                                                     return;
	// NEW VERSION //	
		
		$tags=null;
		     $playerPrefix = $this->users ()->get ( $p->getName ().".tags" );
		         if ($playerTags != null) {
			         $tags = $playerTags;
		                 } else {
			                 //use default prefix
                                 $this->cfg = $this->getConfig()->getAll();
			                         $tags = $this->cfg ()->get ( "default-player-tags");
		}
	}
    public function AlreadyPrsent($player){
	     return file_exists($this->users . "users/".strtolower($player.".yml"));
    }
    public function NewPrsent($player){
         $users = new Config($this->users . "users/" . strtolower($player . ".yml"), Config::YAML);
    	     $users->set(".prefix", PREFIX);
    	         $users->set(".tags", TAGS);
    	             $users->save();
}
	
	/**
	 * Logging util function
	 *
	 * @param unknown $msg        	
	 */
	private function log($msg) {
		$this->getLogger ()->info ( $msg );
	}
}
