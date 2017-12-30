<?php
namespace mpm\Tools\Island;

class IslandAdd{
  /** @var array*/
  private $c;


  public function __construct(int $num,Vector2 $pos, Player $owner = null, $options = []){
    $this->c = LandAPI::getAll();
    $name = ($owner == null)? null:$owner->getName();
    if($this->c['island'] [$num] [$owner] !== null){$this->sendNope($owner);return true;}
    $this->configset($num, $pos,$name, $options);
    $this->sendAdded($num, $owner);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, Vector2 $pos,$owner, $optioins){
    $this->c['island'] [$num] = [
      'owner' => $owner,
      'pos' => [$pos->x, $pos->y],
      'share' => [],
      'options' => $options
    ];
    return true;
  }
  public function sendAdded($num, Player $owner){
    $owner->sendMessage(LandAPI::$prefix."섬".$num."번이 설정됬습나다. ");
    return true;
  }
  public function sendNope(Player $pl){
    $pl->sendMessage(LandAPI::$prefix."해당 섬은 이미 누가 구매하였습니다.");
  }
}
 ?>
