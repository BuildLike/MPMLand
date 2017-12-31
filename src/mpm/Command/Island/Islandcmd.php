<?php
namespace mpm\Command\Island;

class Islandcmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("섬", $this->api->cmdhelp['Land'], "/섬");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    $pl->sendMessage($this->api->Islandhelp());
    return true;
  }
}
 ?>
