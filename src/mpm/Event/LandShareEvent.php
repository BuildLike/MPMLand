<?php
namespace mpm\Event;

use pocketmine\Player;

class LandShareEvent extends LandEvent{

  public static $handlerList = null;
  protected $sharer;

  public function __construct(Player $player,Player $sharer, $id, $type){
    $this->sharer = $sharer;
    parent::__construct($player,$id, $type);
  }
  public function getSharer() : Player{
    return $this->sharer;
  }
}
 ?>
