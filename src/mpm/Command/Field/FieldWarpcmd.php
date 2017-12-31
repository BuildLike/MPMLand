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
    parent::__construct("평야이동", "평야의 특정 번호로 이동합니다.", "/평야이동 [번호]", ['번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if(! isset($this->c['field'] [$i[1]]){
      $pl->sendMessage(MPMLand::$prefix."해당 평야은 없거나 등록되지 않았습니다.");
      return true;
    }
      new FieldWarp($i[1], $pl);
    return true;
  }
}
 ?>
