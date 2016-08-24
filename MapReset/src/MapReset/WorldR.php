<?php

namespace MapReset\Main;

use MapReset\Main\WorldR;
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

// Useless

Class WorldR
{
    public function __construct(WorldR $plugin){
        $this->plugin = $plugin;
    }
    
    public function WorldR($lev)
    {
            $name = $lev->getFolderName();
            if ($this->plugin->getOwner()->getServer()->isLevelLoaded($name))
            {
                    $this->plugin->getOwner()->getServer()->unloadLevel($this->plugin->getOwner()->getServer()->getLevelByName($name));
            }
            $zip = new \ZipArchive;
            $zip->open($this->plugin->getOwner()->getDataFolder() . 'World/' . $name . '.zip');
            $zip->extractTo($this->plugin->getOwner()->getServer()->getDataPath() . 'worlds');
            $zip->close();
            unset($zip);
            $this->plugin->getOwner()->getServer()->loadLevel($name);
            return true;
    }
}
