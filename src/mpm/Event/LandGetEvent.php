<?php
namespace mpm\Event;

use pocketmine\Player;

class LandBuyEvent extends LandEvent implements Cancellable{
  /** @var Player */
  private $player;
  /** @var string */
  private $type;
  private $num;

  public function __construct(Player $player, string $type, int $num = null){
    $this->player = $player;
    parent::__construct($player);
    $this->num = $num;
    $level = $type;
    $this->type = $type;
    if($level == "Field", $level == "Island", $level == "SkyLand") return true;
    return false;
  }
  public function getGettingNum(){
    return $this->num;
  }
  public function getGettingType() : string{
    $this->type;
  }
}
 ?>
