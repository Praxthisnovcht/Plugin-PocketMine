<?php

namespace Praxthisnovcht\EasySurvival;



use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;


/**
 * Main // EasySurvival 1.0.0 Release  
 */
class EasySurvival extends PluginBase implements Listener {
	  public function onLoad() {
    $this->getLogger()->info(TextFormat::YELLOW . "Loading EasySurvival by Praxthisnovcht");
    }
	public function onEnable() {
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
		$this->getLogger()->info(TextFormat::YELLOW . "Enabling EasySurvival...");
	}
	public function onJoin(PlayerJoinEvent $event) {
     $player = $event->getPlayer (); # GetPlayer
     foreach ( $player->getInventory ()->getContents () as $item ) {
      if($item->getID () == Item::STONE_SWORD and $item->getID () == Item::STONE_SHOVEL and $item->getID () == Item::STONE_HOE and $item->getID () == Item::IRON_PICKAXE and Item::STONE_AXE and $item->getID () == Item::CHAIN_CHESTPLATE and Item::IRON_LEGGINGS $item->getID () == Item::LEATHER_BOOTS and Item::IRON_HELMET)
                return;
        }		
	public function playerRespawn(PlayerRespawnEvent $event) {
     $player = $event->getPlayer (); # GetPlayer
     foreach ( $player->getInventory ()->getContents () as $item ) {
      if($item->getID () == Item::STONE_SWORD and $item->getID () == Item::STONE_SHOVEL and $item->getID () == Item::STONE_HOE and $item->getID () == Item::IRON_PICKAXE and Item::STONE_AXE and $item->getID () == Item::CHAIN_CHESTPLATE and Item::IRON_LEGGINGS $item->getID () == Item::LEATHER_BOOTS and Item::IRON_HELMET)
                return;
        }	
  public function onDisable() {
    $this->getLogger()->info(TextFormat::YELLOW . "Disabling EasySurvival");
  }
}
?>
