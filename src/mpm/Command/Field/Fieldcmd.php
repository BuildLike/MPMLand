<?php
namespace mpm\Command\Field;

class Fieldcmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("평야", "평야에 관련된 명령어", "/평야");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    $pl->sendMessage($this->api->Fieldhelp());
    return true;
  }
}
 ?>
