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
    parent::__construct("땅이동","해당 번호의 땅으로 이동합니다.", "/땅이동 [번호]", ['번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if(! isset($this->c['Land'] [$i[0]]){
      $pl->sendMessage(MPMLand::$prefix."해당 땅은 없거나 등록되지 않았습니다.");
      return true;
    }
      new LandWarp($i[1], $pl);
    return true;
  }
}
 ?>
