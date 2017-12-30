<?php
namespace mpm\Tools\Land;

class LandAdd{
  /** @var array*/
  private $c;


  public function __construct(int $num, Position $fpos, Position $lpos, Player $owner = null, $options = []){
    $this->c = LandAPI::getAll();
    $name = ($owner == null)? null:$owner->getName();
    if($this->c['Land'] [$num] [$owner] !== null){$this->sendNope($owner);return true;}
    $this->configset($num, $fpos, $lpos,$name, $options);
    $this->sendAdded($num, $owner);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, Position $fpos, Position $lpos ,$owner, $optioins){
    $this->c['Land'] [$num] = [
      'owner' => $owner,
      'pos' => [
        'mpos' => [($fpos->x + $lpos->x)/2, ($fpos->y + $lpos->y)/2, $fpos->level->getName()],
        'fpos' => [$fpos->x, $fpos->y, $fpos->z, $fpos->level->getName()],
        'lpos' => [$lpos->x, $lpos->y, $lpos->z, $lpos->level->getName()]
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
