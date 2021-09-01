<?php

declare(strict_types = 1);

namespace Zinkil\Distance;

use pocketmine\plugin\PluginBase;
use Zinkil\Distance\EventListener;

class Loader extends PluginBase{

    private static $instance;

    public function onEnable() : void{
        self::$instance = $this;
        $this->setListeners();
    }

    public static function getInstance() : Loader{
        return self::$instance;
    }

    public function setListeners(){
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

}