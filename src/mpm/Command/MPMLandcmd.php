<?php
namespace mpm\Command;

class MPMLandcmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("MPM", "MPM 플러그인 명령어", "/MPM");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    $pl->sendMessage($this->api->getallhelps());
    return true;
  }
}
 ?>
