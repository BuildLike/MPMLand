<?php
namespace mpm\Command\Field;

class FieldGivecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("평야양도", "플레이어에게 평야를 양도합니다.", "/평야양도 [플레이어]", ['Player']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($pl->getLevel()->getName() !== "field"){
      $pl->sendMessage(MPMLand::$prefix."평야 영역이 아닙니다.");
      return true;
    }
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage("/평야양도 [플레이어]");
      return true;
    }
    new FieldGive($this->api->getLandByPlayer($pl)['num'], $pl, $this->getServer()->getPlayer($i[0]));
    return true;
  }
}
 ?>
