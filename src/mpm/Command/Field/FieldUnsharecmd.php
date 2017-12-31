<?php
namespace mpm\Command\Field;

class FieldUnsharecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("평야공유해제", "평야를 공유 해제하는데 사용됩니다.", "/평야공유해제 [플레이어] (플레이어) ...");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage(MPMLand::$prefix."/평야공유해제 [플레이어] (플레이어0)");
      return true;
    }
    new FieldUnshare($this->api->getLandByPlayer($pl)['num'], $i);
    return true;
  }
}
 ?>
