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
use pocketmine\level\Explosion;
use pocketmine\event\block\BlockEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityMoveEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3 as Vector3;
use pocketmine\math\Vector2 as Vector2;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\network\protocol\AddMobPacket;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\UpdateBlockPacket;
use pocketmine\block\Block;
use pocketmine\block\WallSign;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\protocol\DataPacket;
use pocketmine\network\protocol\Info;
use pocketmine\network\protocol\LoginPacket;
use pocketmine\level\generator\Generator;
# Addon For CustomChat                      ##
use Praxthisnovcht\KillChat\KillChat; 
use MassiveEconomy\MassiveEconomyAPI;
/**
 * Main
 *        
 */
class ccMain extends PluginBase implements CommandExecutor {

	private $factionspro, $pureperms, $economyjob, $playerstats;

	public $swCommand;
	
	/**
	 * OnLoad
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onLoad()
	 */
	public function onLoad() {
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
		$this->loadConfig ();
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
	
	public function loadConfig() {
		$this->saveDefaultConfig();
		$this->fixConfigData ();
	}
// 	public function reloadConfig() {
// 		$this->reloadConfig ();
// 		$this->loadConfig ();
// 	}
	public function fixConfigData() {
		if (! $this->getConfig ()->get ( "chat-format" )) {
			$this->getConfig ()->set ( "chat-format", "{WORLD_NAME}:[{PREFIX}]<{DISPLAY_NAME}> {MESSAGE}" );
		}	
		if (! $this->getConfig ()->get ( "enable-formatter" )) {
			$this->getConfig ()->set ( "enable-formatter", true );
		}	
		if (! $this->getConfig ()->get ( "disablechat" )) {
			$this->getConfig ()->set ( "disablechat", false );
		}	
		if (! $this->getConfig ()->get ( "default-player-prefix" )) {
			$this->getConfig ()->set ( "default-player-prefix", "PREFIX" );
		}
		if (! $this->getConfig ()->get ( "default-player-tags" )) {
			$this->getConfig ()->set ( "default-player-tags", "TAGS" );
		}
		if (! $this->getConfig ()->get ( "CustomChat options" )) { // Totally Useless ^^
			$this->getConfig ()->set ( "CustomChat options", "{Kills} | {Deaths} | [{Money}$]" );
		}
		if (! $this->getConfig ()->get ( "CustomJoin" )) {
			$this->getConfig ()->set ( "CustomJoin", "@Player joined the server (Iksaku is Awesome) !") ;
		}
		if (! $this->getConfig ()->get ( "CustomLeave" )) {
			$this->getConfig ()->set ( "CustomLeave", "@Player leave the server  (ksaku is Awesome) !");
		}
		if (! $this->getConfig ()->get ( "if-player-has-no-faction" )) {
			$this->getConfig ()->set ( "if-player-has-no-faction", "NoFaction" );
		}
	
		$this->getConfig()->save();
	}
	
	public function formatterPlayerDisplayName(Player $p) {
		$prefix=null;
		$playerPrefix = $this->getConfig ()->get ( $p->getName ().".prefix" );
		if ($playerPrefix != null) {
			$prefix = $playerPrefix;
		} else {
			//use default prefix
			$prefix = $this->getConfig ()->get ( "default-player-prefix");
		}
	
		//check if player has nick name
		$nick = $this->getConfig ()->get ( $p->getName().".nick");
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
		
		
		$tags=null;
		$playerPrefix = $this->getConfig ()->get ( $p->getName ().".tags" );
		if ($playerTags != null) {
			$tags = $playerTags;
		} else {
			//use default prefix
			$tags = $this->getConfig ()->get ( "default-player-tags");
		}
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
