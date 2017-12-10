<?php
namespace mpm\Event;

use pocketmine\Player;

abstract class LandEvent extends Event{
  /** @var Player */
  private $player;

  private $id;

  private $type

  public function __construct(Player $player,$id, $type){
    $this->player = $player;
    $this->type = $type;
  }
  public function getPlayer() : Player{
    return $this->player;
  }
  public function getType(){
    return $this->type;
  }
  public function getId(){
    return $this->id;
  }
}
 ?>
