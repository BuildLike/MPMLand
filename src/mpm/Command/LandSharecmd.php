<?php
namespace mpm\Command;

class LandSharecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("땅공유", $this->api->cmdhelp['LandShare'], "/땅공유 [플레이어] (플레이어) ...");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage($this->api->cmdhelp['LandShare']);
      return true;
    }
    switch($pl->getLevel()->getName()){
      case "field":
      $class = "FieldShare";
      break;
      case "island":
      $class = "IslandShare";
      break;
      case "skyland":
      $class = "SkylandShare";
      break;
      default:
      $class = "LandShare";
      break;
    }
    new $class($this->api->getLandByPlayer($pl)['num'], $i);
    return true;
  }
}
 ?>
