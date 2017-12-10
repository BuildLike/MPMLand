<?php
namespace mpm\Landcmd;

use mpm\Generator\{FieldGenerator, IsLandGenerator, SkyLandGenerator};
use mpm\Command\{Landcmd, LandBuycmd, Landgivecmd, LandSharecmd, LandMovecmd};
use mpm\Lands\{Field, IsLand, Land, SkyLand};
use mpm\Event\{LandEvent, LandGetEvent, LandGiveEvent, LandShareEvent, WarpLandEvent};
use mpm\MPMLand;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Landcmd extends Command{
  /** @var MPMLand */
  private $owner;

  private $c;

  public function __construct(MPMLand $owner, $c){
    $this->owner = $owner;
    $this->c = $c;
        parent::__construct("땅양도", "땅을 양도합니다.", "/땅양도 [플레이어]", ["플레이어"]);
  }
  public function execute(CommandSender $pl, string $commandLabel, array $args) : bool{
    if(! isset($args[0])){$pl->sendMessage($pr."/땅양도 [플레이어]"); return true;}
    if(! isset($this->c[$pl->getLevel()->getName()]])){$pl->sendMessage($pr."당신은 섬, 하늘섬, 평지중 한 월드에 있어야 합니다."); return true;}
    $a = 0;
    switch($pl->getLevel()->getName()){
      case 'Island': $cl = 200;
      case 'SkyLand': $cl = 200;
      case 'Field': $cl = 30;
    }
    foreach($this->c[$pl->getLevel()->getName()] as $id => $data){
      if(! isset($data) or $pl->distance(new Vector3(103 + $id * 200, 12, 297)) >= $cl) continue;
      $a = $id; break;
    }
    switch($pl->getLevel()->getName()){
      case 'Island': $class = Island::getId($a);
      case 'SkyLand': $class = Skyland::getId($a);
      case 'Field': $class = Field::getId($a);
    }
    if($class !== null or $class->getOwner() !== $pl->getName()){$pl->sendMessage($pr."당신의 땅에서만 가능한 작업입니다."); return true;}
    $d = [];
    foreach($this->c[$pl->getLevel()->getName()] as $id => $data){
      if(! isset($data) or $data['owner'] !== $args[0]) continue;
      array_push($d, $id);
      if(count($d) >= 3){$pl->sendMessage($pr."플레이어의 섬 개수가 일정 제한을 넘었습니다."); return true;}
    }
    $class->setOwner($args[0]);
    $ev = new LandGetEvent($pl, $this->owner->getServer()->getPlayer($args[0]),$a, $pl->getLevel()->getName());
    $this->owner->getServer()->getPluginManager()->callEvent($ev);
    return true;
  }
}
 ?>
