<?php
namespace mpm\Tools\Field;

class FieldAdd{
  /** @var array*/
  private $c;


  public function __construct(int $num, Player $owner = null, $options = []){
    $this->c = LandAPI::getAll();
    $name = ($owner == null)? null:$owner->getName();
    if($this->c['field'] [$num] [$owner] !== $name){$this->sendNope($owner);return true;}
    $this->configset($num, $name, $options);
    $this->sendAdded($num, $owner);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, $owner, $options){
    $this->c['field'] [$num] ['owner'] = $owner;
    $this->c['field'] [$num] ['share'] = [];
    $this->c['field'] [$num] ['option'] = $options
    return true;
  }
  public function sendAdded($num, Player $owner){
    $owner->sendMessage(LandAPI::$prefix."땅".$num."번을 구매하셨습니다. ");
    return true;
  }
  public function sendNope(Player $pl){
    $pl->sendMessage(LandAPI::$prefix."해당 땅은 이미 누가 구매하였습니다.");
  }
}
 ?>
