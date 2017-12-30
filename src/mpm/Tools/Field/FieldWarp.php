<?php
namespace mpm\Tools\Field;

class FieldWarp{
  /** @var array*/
  private $c;


  public function __construct(int $num, Player $pl){
    $this->c = LandAPI::getAll();
    $this->warp($num, $pl)
    return true;
  }
  public function warp(int $num, Player $pl){
    $inf = $this->c['field'] [$num] ['pos'] ['mpos'];
    $pl->teleport(new Position($inf[0], $inf[1], $this->getServer()->getLevelByName("field")));
    $pl->sendMessage(MPMLand::$prefix."당신은 땅".$num."번으로 이동되셨습니다.");
    return true;
  }
}
 ?>
