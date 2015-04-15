<?php

namespace Praxthisnovcht\JoinAndLeaveCustom;

use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener{  // Klasse      

    public function onEnable(){  // plugin enable
        $this->getLogger()->info("JoinAndLeaveCustom has been enabled."); // message
    } //fin function
    
    public function onDisable(){ // plugin disable
        $this->getLogger()->info("JoinAndLeaveCustom has been disabled."); // message
    } //fin function
    
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        if ($player->isOp()) {
            $event->setJoinMessage("|ScMCPE|".$player->getDisplayName()."[Ranked] Rejoin la Partie!");
        }else {
            $event->setJoinMessage("|ScMCPE|".$player->getDisplayName()."Rejoin la Partie.");
        }
    } 
         public function onQuit(PlayerQuitEvent $event) { // Epic Fail
         $player = $event->getPlayer();
        if ($player->isOp()) {
            $event->setQuitMessage("|ScMCPE|".$player->getDisplayName()."[Ranked] est hors ligne!");
        }else {
            $event->setQuitMessage("|ScMCPE|".$player->getDisplayName()."est hors ligne!.");
        }
    } 
    
    }
