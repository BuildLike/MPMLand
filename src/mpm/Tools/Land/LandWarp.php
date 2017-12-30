<?php
namespace mpm\Tools\Land;

class LandWarp{
  /** @var array*/
  private $c;


  public function __construct(int $num, Player $pl){
    $this->c = LandAPI::getAll();
    $this->warp($num, $pl)
    return true;
  }
  public function warp(int $num, Player $pl){
    $inf = $this->c['Land'] [$num] ['pos'] ['mpos'];
    $pl->teleport(new Position($inf[0], 20, $inf[1], $this->getServer()->getLevelByName($inf[2])));
    $pl->sendMessage(MPMLand::$prefix."당신은 땅".$num."번으로 이동되셨습니다.");
    return true;
  }
}
 ?>
