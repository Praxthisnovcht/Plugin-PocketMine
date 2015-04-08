<?php

namespace Praxthisnovcht\HeroesRPG;

use pocketmine\block\Block;
use pocketmine\Player;

class HeroesRPGPlus {

    const ACTION_MINE = 1;
	
    public  function GetXp($move, $id) {

        switch ($move) {


            case self::ACTION_MINE:
                    $itemid = $id->getID();

                    if (in_array($itemid, array(Block::COAL_ORE))) {
                        return rand(0, 2);
                    }
                }
                return false;
        }
}

