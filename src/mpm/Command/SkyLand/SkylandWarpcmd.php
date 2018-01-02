<?php
namespace mpm\Command\Skyland;

class SkylandWarpcmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("공중섬이동", "공중섬이동", "/공중섬이동 [번호]", ['번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if(! isset($this->c['skyland'] [$i[1]]){
      $pl->sendMessage(MPMLand::$prefix."해당 땅은 없거나 등록되지 않았습니다.");
      return true;
    }
      new SkylandWarp($i[1], $pl);
    return true;
  }
}
 ?>
