<?php
namespace mpm\Tools\Land;

class LandInfo{
  /** @var array*/
  private $c;


  public function __construct(int $num, Player $get){
    $this->c = LandAPI::getAll();
    $this->InfoPrint($num, $get);
    return true;
  }
  public function InfoPrint(int $num, Player $pl){
    $inf = $this->c['Land'] [$num];
    $pl->sendMessage("=====[ 땅".$num."번의 정보 ]=====");
    $pl->sendMessage("오너 : ".$inf['owner']);
    $pl->sendMessage("위치(x) : ".$inf['pos'][0]."위치(z) : ".$inf['pos'][1]);
    $pl->sendMessage("공유받은자 : ");
    foreach ($inf['share'] as $share) {
      $pl->sendMessage($share);
    }
    $pl->sendMessage("그외 옵션 : ");
    foreach ($inf['option'] as $key => $value) {
      $pl->sendMessage("옵션(".$key.") : ".$value);
    }
    return true;
  }
}
 ?>
