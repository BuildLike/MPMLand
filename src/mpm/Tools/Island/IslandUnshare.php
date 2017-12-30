<?php
namespace mpm\Tools\Island;

class IslandUnShare{
  /** @var array*/
  private $c;


  public function __construct(int $num, $share = []){
    $this->c = LandAPI::getAll();
    if($this->c['island'] [$num] ['owner'] == null){$this->sendNope($owner);return true;}
    $this->configset($num, $share);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, $shares = []){
    foreach ($this->c['island'] [$num] ['share'] as $share) {
      if(! isset($this->c['island'] [$num] ['share'] [$share])) continue;
      unset($this->c['island'] [$num] ['share'] [$share]);
    }
    return true;
  }
  public function sendNope(Player $pl){
    $pl->sendMessage(LandAPI::$prefix."해당 섬의 오너가 없습니다!!");
  }
}
 ?>
