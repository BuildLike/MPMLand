<?php
namespace mpm\Tools\Field;

class FieldAdd{
  /** @var array*/
  private $c;


  public function __construct(int $num,Vector2 $fpos, Vector2 $lpos, Player $owner = null, $options = []){
    $this->c = LandAPI::getAll();
    $name = ($owner == null)? null:$owner->getName();
    if($this->c['field'] [$num] [$owner] !== null){$this->sendNope($owner);return true;}
    $this->configset($num, $fpos, $lpos,$name, $options);
    $this->sendAdded($num, $owner);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, Vector2 $fpos, Vector2 $lpos,$owner, $optioins){
    $this->c['field'] [$num] = [
      'owner' => $owner,
      'pos' => [
        'mpos' => [($fpos->x + $lpos->x)/2, ($fpos->y + $lpos->y)/2],
        'fpos' => [$fpos->x, $fpos->y],
        'lpos' => [$lpos->x, $lpos->y]
      ],
      'share' => [],
      'options' => $options
    ];
    return true;
  }
  public function sendAdded($num, Player $owner){
    $owner->sendMessage(LandAPI::$prefix."땅".$num."번이 설정됬습나다. ");
    return true;
  }
  public function sendNope(Player $pl){
    $pl->sendMessage(LandAPI::$prefix."해당 땅은 이미 누가 구매하였습니다.");
  }
}
 ?>
