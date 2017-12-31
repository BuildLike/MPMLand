<?php
namespace mpm\Command\Island;

class IslandSharecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("섬공유", "섬을 공유한다.", "/섬공유 [플레이어] (플레이어) ...");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage("/섬공유 [플레이어] (플레이어) ...");
      return true;
    }
    new IslandShare($this->api->getLandByPlayer($pl)['num'], $i);
    return true;
  }
}
 ?>
