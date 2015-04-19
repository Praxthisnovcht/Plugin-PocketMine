<?php
 /** Thanks to EvolSoft to help me rewrite plugin CustomChat<EssentialsPEChat
 /* Website : http://www.evolsoft.tk
 /* Page Github: https://github.com/EvolSoft
 /* PocketMine Forum : http://forums.pocketmine.net/forums/
  * 
  *
  */

namespace Praxthisnovcht\EssentialsPEChat;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class EventListener implements Listener{
	
	public function __construct(EssentialsPEChat $plugin){
		$this->plugin = $plugin;
	}

	public function onChat(PlayerChatEvent $event){
		$this->plugin->event = $event;
		$extensions = $this->getAllExtensions();
		foreach($extensions as $get){
			if($this->plugin->getServer()->getPluginManager()->getPlugin($get) && method_exists($this->plugin->getServer()->getPluginManager()->getPlugin($get), "onRegisterPrefix")){
				$this->plugin->getServer()->getPluginManager()->getPlugin($get)->onRegisterPrefix();
			}
		}
	// ===========
	//	Format
	// ===========
		$this->plugin->replaceTag("{WORLD}", $event->getPlayer()->getLevel()->getName()); //Level Tag
		$this->plugin->replaceTag("{PLAYER}", $event->getPlayer()->getName()); //Player Tag
		$this->plugin->replaceTag("{PREFIX}", $this->plugin->getConfig()->get("prefix")); //Prefix Tag
	        $this->plugin->replaceTag("{SUFFIX}", $this->plugin->getConfig()->get("suffix")); //Suffix Tag
		$this->plugin->replaceTag("{MESSAGE}", $event->getMessage()); //Message Tag
		//Custom tags
		$tags = new Config($this->plugin->getDataFolder() . "tags.yml", Config::YAML);
		foreach($tags->getAll() as $tag => $value){
			$this->plugin->replaceTag("{" . strtoupper($tag)."}", $value);
		}
		$event->setFormat($this->getFormattedMessage($this->plugin->getConfig()->get("chat-format")));
	// ===========
	//	Player Mute
	// ===========		
        $mhut = $event->getRecipients();
        for($lol = 0; $i < count($mhut); $lol++) {
            if (isset($this->leave[$mhut[$lol]->getName()])){
                unset($mhut[$lol]);
            }
        }
        $event->setRecipients($mhut);
		
		$allowChat = $this->plugin->getConfig()->get("disablechat");
		if ($allowChat) {
			$event->setCancelled ( true );
			return;
		}
		if (! $allowChat || $allowChat == null) {
			$player = $event->getPlayer ();
			
			$perm = "chatmute";
			
			if ($player->isPermissionSet ( $perm )) {
				$event->setCancelled ( true );
				return;
			}
			$format = $this->getFormattedMessage ( $player, $event->getMessage () );
			$config_node = $this->plugin->getConfig()->get ( "enable-formatter" );
			if (isset ( $config_node ) and $config_node === true) {
				$event->setFormat ( $format );
			}
			return;
		}
	}
	// ===========
	//	Player Join
	// ===========
	public function onPlayerJoin(PlayerJoinEvent $event) {
	    $message = $this->plugin->getConfig()->get("CustomJoin");
		$player = $event->getPlayer();
        if($message === false){                                                                                                                                                                    
            $event->setJoinMessage(null);                                                                                                                                                       
        }
		if($this->factionspro == true && $this->factionspro->isInFaction(strtolower($player->getName()))) {
			$getUserFaction = $this->factionspro->getPlayerFaction(strtolower($player->getName())); 
			$message = str_replace ( "@Faction", $getUserFaction, $message );
		}else{
			$nofac = $this->join->getConfig ()->get ( "if-player-has-no-faction");
			$message = str_replace ( "@Faction", $nofac, $message );
		}		
        $message = str_replace("@Player", $event->getPlayer()->getDisplayName(), $message);                                                                      
		
		$this->plugin->formatterPlayerDisplayName ( $player );
		$event->setJoinMessage($message);
/**
	$player = $event->getPlayer();
	$name = $player->getName();
	$nm = strlen($name);
	$config = $this->PlayerMaxLetter->getAll();
	$max = $config['max'];
	$min = $config['min'];
**/
	}
	// ===========
	//	Player Quit
	// ===========
    public function onPlayerQuit(PlayerQuitEvent $event){
        $message = $this->plugin->getConfig()->get("CustomLeave"); 
		$player = $event->getPlayer();
        if($message === false){
            $event->setQuitMessage(null);
        }
		if($this->factionspro == true && $this->factionspro->isInFaction(strtolower($player->getName()))) {
			$getUserFaction = $this->factionspro->getPlayerFaction(strtolower($player->getName())); 
			$message = str_replace ( "@Faction", $getUserFaction, $message );
		}else{
			$nofac = $this->join->getConfig ()->get ( "if-player-has-no-faction");
			$message = str_replace ( "@Faction", $nofac, $message );
		}
        $message = str_replace("@Player", $event->getPlayer()->getDisplayName(), $message);

		
		$event->setQuitMessage($message);
	}
	
	private function getAllExtensions(){
		return $this->plugin->extensions;
	}
	
	private function getFormattedMessage($message){
		foreach($this->plugin->tags as $key => $tag){
			$message = str_ireplace($key, $tag, $message);
		}
		return $message;
	}
	// ===========
	//	Player Prefix
	// ===========
	public function formatterPlayerDisplayName(Player $p) {
		$prefix=null;
		$playerPrefix = $this->prefix ()->get ( $p->getName ().".prefix" );
		if ($playerPrefix != null) {
			$prefix = $playerPrefix;
		} else {
			//use default prefix
			$prefix = $this->getConfig ()->get ( "default-player-prefix");
		}
		//default to regular name
		$p->setNameTag($p->getName());
		return;
	}


}
