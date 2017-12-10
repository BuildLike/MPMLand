<?php
namespace mpm\Event;

use pocketmine\Player;

class LandGetEvent extends LandEvent implements Cancellable{

  public static $handlerList = null;
  protected $id;

  public function __construct(Player $player, $id, $type){
    parent::__construct($player, $id, $type);
  }
}
 ?>
