<?php

declare(strict_types = 1);

namespace Zinkil\Distance;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\event\entity\EntityDamageEvent;
use Zinkil\Distance\Loader;

class EventListener implements Listener{
	
	public $instance;
	
	public function __construct(){
		$this->instance = Loader::getInstance();
	}

	public function onEntityDamageByEntity(EntityDamageEvent $event){
		$player = $event->getEntity();
		$cause = $event->getCause();
		$level = $player->getLevel()->getName();
		switch($cause){
			case EntityDamageEvent::CAUSE_ENTITY_ATTACK:
			$damager = $event->getDamager();
			if(!$player instanceof Player || !$damager instanceof Player) return;
			if($damager->isCreative() || $player->isCreative()) return;
			if($event->isCancelled()) return; // Don't send the distance message if the damage is cancelled or from attack cooldown
            $playerposition = $player->getPosition() ?? new Vector3(0,0,0);
			$damagerposition = $damager->getPosition() ?? new Vector3(0,0,0);
			$distance = $damagerposition->distance($playerposition);
			$playername = $player->getDisplayName();
			$damagername = $damager->getDisplayName();

			$player->sendTip("§r§e" . $damagername . "§e: §7" . $distance);
			$damager->sendTip("§r§cDistance: §7" . $distance);
        }
    }
}