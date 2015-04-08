<?php
 /** Thanks to EvolSoft to help me rewrite plugin CustomChat<EssentialsPEChat
 /* Website : http://www.evolsoft.tk
 /* Page Github: https://github.com/EvolSoft
 /* PocketMine Forum : http://forums.pocketmine.net/forums/
  * 
  *
  */

namespace Praxthisnovcht\EssentialsPEChat;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class EssentialsPEChat extends PluginBase{
	
	public $extensions = array();
	
	public $tags = array();
	
	public $event;
	
	private static $object = null;
	
	public static function getInstance(){
		return self::$object;
	}
	
	public function onLoad(){
	    $this->getLogger()->info(TextFormat::YELLOW . "Loading EssentialsPEChat......Wait....");
		if(!self::$object instanceof EssentialsPEChat){
			self::$object = $this;
		}
	}

	public function onEnable(){
	    @mkdir($this->getDataFolder());
	    $this->saveDefaultConfig();
		$this->getLogger()->info(TextFormat::GREEN . "EssentialsPEChat 1.4.0 Loaded!");
		$this->registerExtension($this);
		$this->config = new Config ( $this->getDataFolder () . "prefix.yml", Config::YAML );
		$this->prefix = $this->config->getAll ();
		// CustomJoin
		$this->join = new Config ( $this->getDataFolder () . "CustomJoin.yml", Config::YAML );
		$this->join = $this->config->getAll ();
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
	}
	
	public function onDisable() {
		$this->config->setAll ( $this->prefix );
		$this->config->save ();

		$this->join->setAll ( $this->join );
		$this->join->save ();
		$this->getLogger()->info(TextFormat::RED . "EssentialsPEChat 1.4.0 Unloaded!");
	}
	
	public function registerExtension(Plugin $extension){
		array_push($this->extensions, $extension->getName());
	}
	
	public function replaceTag($tag, $replace){
		$tag = strtolower($tag);
		$this->tags[$tag] = $replace;
	}
	
	public function getCurrentEvent(){
		return $this->event;
	}
	
}
