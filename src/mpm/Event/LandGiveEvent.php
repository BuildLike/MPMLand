<?php
namespace mpm\Event;

use pocketmine\Player;

class LandGiveEvent extends LandGetEvent{

  private $Giver;

  public function __construct(Player $player,Player $giver, $id, $type){
    $this->Giver = $giver; // I typed taker to giver.. Sorry
    parent::__construct($player,$id, $type);
  }
  public function getTaker() : Player{
    return $this->Giver;
  }
}
 ?>
