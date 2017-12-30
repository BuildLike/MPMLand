<?php
namespace mpm\Tools\Field;

class FieldGive{
  /** @var array*/
  private $c;


  public function __construct(int $num,Player $before = null, Player $after){
    $this->c = LandAPI::getAll();
    if($this->c['field'] [$num] ['owner'] != $before){$this->sendNope($before);return true;}
    $this->configset($num, $after);
    $this->sendGiven($num, $before, $after);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset(int $num,Player $after){
    $this->c['field'] [$num] ['owner'] = $after->getName();
    return true;
  }
  public function sendAdded(int $num,Player $before, Player $after){
    if($pl == null) return true;
    $before->sendMessage(LandAPI::$prefix."땅".$num."번을 양도하였습나다.");
    $after->sendMessage(LandAPI::$prefix."땅".$num."번이 양도받으셨습나다.");
    return true;
  }
  public function sendNope(Player $pl = null){
    if($pl == null) return true;
    $pl->sendMessage(LandAPI::$prefix."해당 땅은 당신의 것이 아닙니다.");
  }
}
 ?>
