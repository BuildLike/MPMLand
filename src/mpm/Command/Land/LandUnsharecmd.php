<?php
namespace mpm\Command;

class LandUnsharecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("땅공유", $this->api->cmdhelp['LandUnshare'], "/땅공유 [플레이어] (플레이어) ...");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage($this->api->cmdhelp['LandUnshare']);
      return true;
    }
    switch($pl->getLevel()->getName()){
      case "field":
      $class = "FieldUnshare";
      break;
      case "island":
      $class = "IslandUnshare";
      break;
      case "skyland":
      $class = "SkylandUnshare";
      break;
      default:
      $class = "LandUnshare";
      break;
    }
    new $class($this->api->getLandByPlayer($pl)['num'], $i);
    return true;
  }
}
 ?>
