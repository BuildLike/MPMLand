<?php
namespace mpm\Tools\Island;

class IslandGive{
  /** @var array*/
  private $c;


  public function __construct(int $num,Player $before, Player $after){
    $this->c = LandAPI::getAll();
    if($this->c['island'] [$num] ['owner'] != $before){$this->sendNope($before);return true;}
    $this->configset($num, $after);
    $this->sendGiven($num, $before, $after);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset(int $num,Player $after){
    $this->c['island'] [$num] ['owner'] = $after->getName();
    return true;
  }
  public function sendAdded(int $num,Player $before, Player $after){
    $before->sendMessage(LandAPI::$prefix."섬".$num."번을 양도하였습나다.");
    $after->sendMessage(LandAPI::$prefix."섬".$num."번이 양도받으셨습나다.");
    return true;
  }
  public function sendNope(Player $pl){
    $pl->sendMessage(LandAPI::$prefix."해당 섬은 당신의 것이 아닙니다.");
  }
}
 ?>