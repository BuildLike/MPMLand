<?php
namespace mpm\Tools\Field;

class FieldUnShare{
  /** @var array*/
  private $c;


  public function __construct(int $num, $share = []){
    $this->c = LandAPI::getAll();
    if($this->c['field'] [$num] ['owner'] == null){$this->sendNope($owner);return true;}
    $this->configset($num, $share);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, $shares = []){
    foreach ($this->c['field'] [$num] ['share'] as $share) {
      if(! isset($this->c['field'] [$num] ['share'] [$share])) continue;
      unset($this->c['field'] [$num] ['share'] [$share]);
    }
    return true;
  }
  public function sendNope(Player $pl){
    $pl->sendMessage(LandAPI::$prefix."해당 땅의 오너가 없습니다!!");
  }
}
 ?>
