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
private static $object = null;
	public $swCommand;
	public static function getInstance(){
    	return self::$object;
    }
	/**
	 * OnLoad
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onLoad()
	 */
	public function onLoad() {
			if(!self::$object instanceof ccMain){
    		self::$object = $this;
    	}
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
		
		
          @mkdir($this->getDataFolder());
		  @mkdir($this->getDataFolder() . "players/");
                    $this->path = $this->getDataFolder(); 

                 if(!is_file($this->path."config.yml")){
			         file_put_contents($this->path."config.yml", $this->readResource("config.yml"));
			             }
			                 $this->config = new Config($this->path."config.yml", Config::YAML);
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
		$this->playerConfig = new Config($this->path."players/".$p->getName().".yml", Config::YAML);
		$playerPrefix = $this->playerConfig->get ( $p->getName ().".prefix" );
		if ($playerPrefix != null) {
			$prefix = $playerPrefix;
		} else {
			//use default prefix
			$prefix = $this->config->get ( "default-player-prefix");
		}
	
		//check if player has nick name
		$nick = $this->playerConfig->get ( $p->getName().".nick");
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
		$playerPrefix = $this->playerConfig->get ( $p->getName ().".tags" );
		if ($playerTags != null) {
			$tags = $playerTags;
		} else {
			//use default prefix
			$tags = $this->config->get ( "default-player-tags");
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
	
	private function readResource($res){
		$resource = $this->getResource($res);
		if($resource !== null){
			return stream_get_contents($resource);
		}
		return false;
	}
	
	public function getCfg(){
		return new Config($this->getDataFolder()."config.yml", Config::YAML);
	}
 public function getPlCfg($player){
  return new Config($this->getDataFolder()."players/".$player.".yml", Config::YAML);
 }
}
