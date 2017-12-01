<?php
namespace mpm\Event;

use pocketmine\Player;

class LandBuyEvent extends LandGetEvent implements Cancellable{
  /** @var Player */
  private $player;
  /** @var string */
  private $type;
  private $num;
  public function __construct(Player $player, string $type, int $num = null){
    parent::__construct($player, $type, $num);
    $this->player = $player;
    $this->num = $num;
    $this->type = $type; return true;
  }
  public function getPlayerMoney(){
    return PSEconomy::getInstance()->getMoney($this->player->getName());
  }
}
 ?>
