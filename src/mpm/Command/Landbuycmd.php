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
        parent::__construct("땅구매", "땅을 구매합니다.", "/땅구매 [타입] (번호[기본값 : 남은 섬중 제일 낮은 섬의 번호])", ["타입", "번호(기본값 : 남은 섬 중 가장 작은 수)"]);
  }
  public function execute(CommandSender $pl, string $commandLabel, array $args) : bool{
    if(EconomyAPI::getInstance()->myMoney($pl->getName()) < 20000){
      $pl->sendMessage($pr."돈이 부족합니다. ".$type." 가격 : 20000won");
      return true;
    }
    if(! isset($args[0])){$pl->sendMessage($pr."/땅구매 [타입] (번호[기본값 : 남은 섬중 제일 낮은 섬의 번호])"); return true;}
    if(! isset($this->c[$args[0]])){$pl->sendMessage($pr." 타입종류 : Island, Skyland, Field"); return true;}
    $a = [];
    foreach($this->c[$args[0]] as $id => $data){
      if(isset($data)) continue;
      array_push($a, $id);
      if(count($a) >= 10) break;
    }
    $d = [];
    foreach($this->c[$args[0]] as $id => $data){
      if(! isset($data) or $data['owner'] !== $pl->getName()) continue;
      array_push($d, $id);
      if(count($d) >= 3){$pl->sendMessage($pr."섬 개수가 일정 제한을 넘었습니다."); return true;}
    }
    $num = (! isset($args[0]))? $a[0] : $args[1];
    if(isset($this->c[$args[0]] [$args[1]] ['owner'])){$pl->sendMessage($pr."이미 섬 주인이 있습니다.."); return true;}
    switch($args[0]){
      case 'Island': $class = new IsLand($num, $pl->getName(), new Vector3(103 + $num * 200, 12, 297));
      case 'SkyLand': $class = new SkyLand($num, $pl->getName(), new Vector3(103 + $num * 200, 12, 297));
      case 'Field': $class = new Field($num, $pl->getName());
    }
    $ev = new LandGetEvent($pl, $num, $args[0]);
    $this->owner->getServer()->getPluginManager()->callEvent($ev);
    return true;
  }
}
 ?>
