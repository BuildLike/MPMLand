<?php
namespace mpm\Command\Skyland;

class SkylandGivecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("공중섬양도", "공중섬을 다른 플레이어에게 양도합니다.", "/공중섬양도 [플레이어]", ['Player']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage("/공중섬양도 [플레이어]");
      return true;
    }
    new SkylandGive($this->api->getLandByPlayer($pl)['num'], $pl, $this->getServer()->getPlayer($i[0]));
    return true;
  }
}
 ?>
