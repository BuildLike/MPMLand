<?php
namespace mpm\Event;

use pocketmine\Player;

class WarpLandEvent extends LandEvent{

  public static $handlerList = null;
  protected $id;

  protected $title;

  public function __construct(Player $player, $id, $type, $title = ""){
    $this->title = $title;
    parent::__construct($player, $id, $type);
  }
  public function setWelcomeTitle($title){
    $this->title = $title;
  }
  public function getWelcomeTitle($title){
    return $this->title;
  }
}
 ?>
