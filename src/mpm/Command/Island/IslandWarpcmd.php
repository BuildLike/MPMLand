<?php
namespace mpm\Command;

class LandWarpcmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("섬이동", "해당 번호의 섬으로 이동합니다.", "/섬이동 [번호]", ['타입', '번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if(! isset($this->c['island'] [$i[1]]){
      $pl->sendMessage(MPMLand::$prefix."해당 섬은 없거나 등록되지 않았습니다.");
      return true;
    }
      new IslandWarp($i[1], $pl);
    return true;
  }
}
 ?>
