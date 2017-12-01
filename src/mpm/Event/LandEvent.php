<?php
namespace mpm\Event;

use pocketmine\Player;

class LandEvent extends Event{
  /** @var Player */
  private $player;

  public function __construct(Player $player){
    $this->player = $player;
  }
  public function getPlayer() : Player{
    return $this->player;
  }
  /**
  * @desc This function returns {Field, Island, SkyLand}. If the Player is in another world, It returns false
  */
  public function getNowType(){
    $level = $this->player->getLevel()->getName();
    if($level == "Field", $level == "Island", $level == "SkyLand") return $level;
    return false;
  }
}
 ?>
