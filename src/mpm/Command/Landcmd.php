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

  public function __construct(MPMLand $owner){
    $this->owner = $owner;
        parent::__construct("땅", "섬/평지에 대한 명령어 정보를 봅니다..", "/땅");
  }
  public function execute(CommandSender $pl, string $commandLabel, array $args) : bool{
    $pl->sendMessage($pr." /땅구매 [타입] (번호[기본값 : 남은 섬중 제일 낮은 섬의 번호]) §o§8- [타입]에 있는 [번호]를 구매합니다.");
    $pl->sendMessage($pr." /땅양도 [플레이어] §o§8- 땅을 [플레이어] 에게 양도합니다.");
    $pl->sendMessage($pr." /땅이동 [타입] [번호] §o§8- [타입]의 [번호]으로 갑니다.");
    $pl->sendMessage($pr." /땅공유 [플레이어] §o§8- 이땅을 [플레이어]에게 공유/공유해제 시킵니다.");
    $pl->sendMessage($pr." /땅목록 (개수[기본값 : 10])§o§8- 남은 섬 중 [개수]만큼을 구합니다.");
    $pl->sendMessage($pr." 타입종류 : Island, Skyland, Field");
    return true;
  }
}
 ?>
