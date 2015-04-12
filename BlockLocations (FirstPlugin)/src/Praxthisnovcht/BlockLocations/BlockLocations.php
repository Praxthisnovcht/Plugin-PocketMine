<?php

namespace Praxthisnovcht\BlockLocations;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Position;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\block\BlockBreakEvent;


class BlockLocations extends PluginBase implements Listener {
	public $locations = array();
	public function onEnable() {	
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
    }
	public function onDisable() {
	}		
		public function onCommand(CommandSender $p, Command $command, $label, array $args) {
    	
    	
    	if(strtolower($command->getName()) == "blockl")
    	{
    		$brek = $p->getID();
    		$pos = $p->getName();
    		
    		if (! (in_array($brek, $this->locations)))
    		{
    			$this->locations[$pos] = $brek;
    			$p->sendMessage("BreakPosition On");
    		}
    		else
    		{
    			$fr = array_search($brek, $this->locations);
    			unset($this->locations[$fr]);
    			$p->sendMessage("BreakPosition Off");
     		}

    	}


    }
	public function onBlockBeak(BlockBreakEvent $event)
	{
		$log = $event->getPlayer()->getID();
		
		if(in_array($log, $this->locations))
		{
			$ru = $event->getBlock();
			$zoo = strtolower($event->getPlayer()->getName());
			$this->pos[$zoo] = new Vector3($ru->getX(),$ru->getY(),$ru->getZ());
			$event->getPlayer()->sendMessage("BlockPosition :[x->" . $this->pos[$zoo]->getX() . "y->" . $this->pos[$zoo]->getY() . "z->" . $this->pos[$zoo]->getZ() . "]");
			$event->setCancelled(true);
		}
	}
}