<?php
namespace mpm\Tools\Skyland;

class SkylandShare{
  /** @var array*/
  private $c;


  public function __construct(int $num, $share = []){
    $this->c = LandAPI::getAll();
    if($this->c['skyland'] [$num] ['owner'] == null){$this->sendNope($owner);return true;}
    $this->configset($num, $share);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, $share = []){
    $this->c['skyland'] [$num] ['share'] = $share;
    return true;
  }
  public function sendNope(Player $pl){
    $pl->sendMessage(LandAPI::$prefix."해당 섬의 오너가 없습니다!!");
  }
}
 ?>
