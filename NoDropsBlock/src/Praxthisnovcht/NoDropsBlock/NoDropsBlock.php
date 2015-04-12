<?php

namespace Praxthisnovcht\NoDropsBlock;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\DiamondPickaxe;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;

class NoDropsBlock extends PluginBase implements Listener{
	public function onEnable(){
		$this->getLogger()->info(TextFormat::GREEN . "- NoDropsBlock - Loading!");

		if (!file_exists($this->getDataFolder())){
			@mkdir($this->getDataFolder(), 0700, true);
		}
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		// This will check the config, to prevent issues in the code
		$this->saveDefaultConfig();
		if(!$this->getConfig()->exists("onPlayerDropItem") || !is_bool($this->getConfig()->get("onPlayerDropItem"))){
			$this->getConfig()->set("onPlayerDropItem", false); // Set to 'false' by default as seen in the default config.yml file
		}

		$this->getLogger()->info(TextFormat::GREEN . "- NoDropsBlock - Enabled!");
	}

	public function onDisable(){
		$this->getLogger()->info(TextFormat::GREEN . "- NoDropsBlock - Disabled!");
	}

	/**
	 * @param BlockBreakEvent $event
	 */
	public function onBlockBreak(BlockBreakEvent $event){
		$event->setCancelled(true);
		$event->getBlock()->onBreak(new DiamondPickaxe());
	}
}