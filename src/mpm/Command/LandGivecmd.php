<?php
namespace mpm\Command;

class LandGivecmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("땅양도", $this->api->cmdhelp['LandGive'], "/땅양도 [플레이어]", ['Player']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if($this->api->getLandByPlayer($pl) == false or $this->api->getLandByPlayer($pl)['owner'] !== $pl->getName()){
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
      return true;
    }
    if(! isset($i[0])){
      $pl->sendMessage($this->api->cmdhelp['LandGive']);
      return true;
    }
    switch($pl->getLevel()->getName()){
      case "field":
      $class = "FieldGive";
      break;
      case "island":
      $class = "IslandGive";
      break;
      case "skyland":
      $class = "SkylandGive";
      break;
      default:
      $class = "LandGive";
      break;
    }
    new $class($this->api->getLandByPlayer($pl)['num'], $pl, $this->getServer()->getPlayer($i[0]));
    return true;
  }
}
 ?>
