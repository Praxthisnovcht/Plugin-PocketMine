<?php

namespace MapReset;

use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use MapReset\Perms;
use pocketmine\event\Listener;

class Main extends PluginBase  implements Listener {
 
public $Command;
 
 public function onLoad() { 
   // $this->getLogger()->info(TextFormat::RED . "Loading MapReset"); They would see this message twice if you use onLoad & onEnable.
    $this->Command = new MapResetCommand ( $this );
 }
    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $map = $this->getConfig();
        $time = $map->get("TimeReset"); //Grabs time until reset
        $this->getConfig()->set("startreset", "no"); //This is to make sure there wont be a map reset on onEnable
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new MapResetCountDown($this), $time); //sechdules a task for the time.
        $this->startReset(); //Start reset timer function.
        
        
        # The world will be cloned
        if(!$map->exists("MapReset")){
            $map->set("MapReset", "World1");
            $map->save();
        }
        # The world played then deleted
        if(!$map->exists("MapPlaying")){
            $map->set("MapPlaying", "World_1");
            $map->save();
        }
        # time the world lasted
        if(!$map->exists("TimeReset")){
            $map->set("TimeReset", "120");
            $map->save();
        }
        # when the world is eliminated players will tp in the next world:
        if(!$map->exists("WoldTpPlayer")){
            $map->set("WoldTpPlayer", "world");
            $map->save();
        }
        $this->getLogger()->info(TextFormat::GREEN . "[MapReset] MapReset version 1.0.0 has been enabled.");
    }
 public function startReset(){
  $map = $this->getConfig();
  $timer = $map->get("TimeReset");
  $time = intval($timer * 20); //Fixes things up :D
  $this->getServer()->getScheduler()->scheduleDelayedTask(new CallbackTask([$this, "resetNow"], [$sender]), $time);
 }
 public function resetNow(){
  $this->getLogger()->info("[MapReset] Resetting world. Please wait.");
 }
}

