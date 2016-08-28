<?php

namespace _64FF00\PureChat;

use _64FF00\PurePerms\event\PPGroupChangedEvent;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\Player;

class PCListener implements Listener
{
    /*
        PureChat by 64FF00 (Twitter: @64FF00)

          888  888    .d8888b.      d8888  8888888888 8888888888 .d8888b.   .d8888b.
          888  888   d88P  Y88b    d8P888  888        888       d88P  Y88b d88P  Y88b
        888888888888 888          d8P 888  888        888       888    888 888    888
          888  888   888d888b.   d8P  888  8888888    8888888   888    888 888    888
          888  888   888P "Y88b d88   888  888        888       888    888 888    888
        888888888888 888    888 8888888888 888        888       888    888 888    888
          888  888   Y88b  d88P       888  888        888       Y88b  d88P Y88b  d88P
          888  888    "Y8888P"        888  888        888        "Y8888P"   "Y8888P"
    */

    private $plugin;

    /**
 * @param PureChat $plugin
 */
    public function __construct(PureChat $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onGroupChanged(PPGroupChangedEvent $event)
    {
        /** @var \pocketmine\IPlayer $player */
        $player = $event->getPlayer();
		
		if($player instanceof Player)
		{
			$levelName = $this->plugin->getConfig()->get("enable-multiworld-chat") ? $player->getLevel()->getName() : null;

			$nameTag = $this->plugin->getNametag($player, $levelName);

			$player->setNameTag($nameTag);
		}
    }

    /**
     * @param PlayerJoinEvent $event
     * @priority HIGH
     */
    public function onPlayerJoin(PlayerJoinEvent $event)
    {
        /** @var \pocketmine\Player $player */
        $player = $event->getPlayer();
        $levelName = $this->plugin->getConfig()->get("enable-multiworld-chat") ? $player->getLevel()->getName() : null;

        $nameTag = $this->plugin->getNametag($player, $levelName);

        $player->setNameTag($nameTag);
    }

    /**
     * @param PlayerChatEvent $event
     * @priority HIGH
     */
    public function onPlayerChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        $message = $event->getMessage();

        $levelName = $this->plugin->getConfig()->get("enable-multiworld-chat") ? $player->getLevel()->getName() : null;

        $chatFormat = $this->plugin->getChatFormat($player, $message, $levelName);

        $event->setFormat($chatFormat);
    }
}
