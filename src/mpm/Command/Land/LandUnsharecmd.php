<?php
namespace mpm\Command\Land;

class LandSharecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("땅공유해제", "땅을 공유해제 합니다.", "/땅공유해제 [플레이어] (플레이어) ...");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage("/땅공유해제 [플레이어] (플레이어) ...");
      return true;
    }
    new LandShare($this->api->getLandByPlayer($pl)['num'], $i);
    return true;
  }
}
 ?>
