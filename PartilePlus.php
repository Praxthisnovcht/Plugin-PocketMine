<?php
namespace ImagicalGamer\Particles;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;

use pocketmine\level\particle\DustParticle;

use pocketmine\math\Vector3;
use pocketmine\scheduler\PluginTask;
/* Copyright (C) ImagicalGamer - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Jake C <imagicalgamer@outlook.com>, May 2016
 */

class Main extends PluginBase implements Listener{

	public function onEnable(){
		@mkdir($this->getDataFolder());
		
		if(!file_exists($this->getDataFolder() . "config.yml")){
			file_put_contents($this->getDataFolder() . "config.yml",yaml_emit(array()));
		}
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
				// Create the folder plugin.yml
        "LobbyX"  => 100,
        "LobbyY"  => 100,
        "LobbyZ"  => 100,
	]);	
	}
}	
	

                      
class ParticlesPlus extends PluginTask {
  public function __construct($plugin)
  {
    $this->plugin = $plugin;
    parent::__construct($plugin);
  }

  public function onRun($tick){
    $level = $this->plugin->getServer()->getDefaultLevel();
    $r = rand(1,300);
    $g = rand(1,300);
    $b = rand(1,300);
    $x = $this->config("LobbyX");
    $y = $this->config("LobbyY");
    $z = $this->config("LobbyZ");
    $center = new Vector3($x, $y, $z);
    $radius = 0.5;
    $count = 100;
    $particle = new DustParticle($center, $r, $g, $b, 1);
                for($yaw = 0, $y = $center->y; $y < $center->y + 4; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
                  $x = -sin($yaw) + $center->x;
                  $z = cos($yaw) + $center->z;
                  $particle->setComponents($x, $y, $z);
                  $level->addParticle($particle);
}
  }
}
