<?php
namespace mpm\Tools\Island;

class IslandWarp{
  /** @var array*/
  private $c;


  public function __construct(int $num, Player $pl){
    $this->c = LandAPI::getAll();
    $this->warp($num, $pl)
    return true;
  }
  public function warp(int $num, Player $pl){
    $inf = $this->c['island'] [$num] ['pos'];
    $pl->teleport(new Position($inf[0], 20, $inf[1], $this->getServer()->getLevelByName("island")));
    $pl->sendMessage(MPMLand::$prefix."당신은 섬".$num."번으로 이동되셨습니다.");
    return true;
  }
}
 ?>
