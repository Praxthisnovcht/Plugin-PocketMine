<?php

namespace MapReset;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\Server;

class MapResetCommand {
	private $pgin;

	public function __construct(Main $pg) {
		$this->pgin = $pg;
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		switch ($args[0]){
			case "mapreset";
				$sender->sendMessage("[MapReset] Resting map! Please wait...");
				$world = $this->owner->getConfig()->get("WorldTpPlayer");
				$this->resetCommandMap($sender);
				foreach($this->getServer()->getLevels->getPlayers() as $p){
					//tleport playeer to "world tp player"
					$p->sendMessage("[MapReset] The map is resetting. You have been teleported to $world");
					return true;
					break;
				}
			}
		}
		public function resetCommandMap() {
			$this->plugin->getLogger->info("[MapReset] Resseting map. Please wait.");
		}
		public function log($message) {
			$this->plugin->getLogger ()->info ( $message );
		}
	}
