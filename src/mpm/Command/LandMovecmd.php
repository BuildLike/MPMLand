<?php
namespace mpm\Landcmd;

use mpm\Generator\{FieldGenerator, IsLandGenerator, SkyLandGenerator};
use mpm\Command\{Landcmd, LandBuycmd, Landgivecmd, LandSharecmd, LandMovecmd};
use mpm\Lands\{Field, IsLand, Land, SkyLand};
use mpm\Event\{LandEvent};
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
        parent::__construct("땅이동", "땅으로 이동합니다.", "/땅이동 [번호]", ["번호"]);
  }
  public function execute(CommandSender $pl, string $commandLabel, array $args) : bool{
    if(! isset($args[0]) or ! isset($args[1])){$pl->sendMessage($pr."/땅이동 [타입] [번호]"); return true;}
    if(! isset($this->c[$args[0]])){$pl->sendMessage($pr." 타입종류 : Island, Skyland, Field"); return true;}
    $a = $args[0];
    switch($args[1]){
      case 'Island': $class = Island::getId($a);
      case 'SkyLand': $class = Skyland::getId($a);
      case 'Field': $class = Field::getId($a);
    }
    $pl->teleport($class->getPos());
    return true;
  }
}
 ?>
