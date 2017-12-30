<?php
namespace mpm\Command;

class Landcmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("땅", $this->api->cmdhelp['Land'], "/땅");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    $a = $this->api->cmdhelp;
    foreach ($a as $key => $value) {
      $pl->sendMessage(MPMLand::$prefix.$value);
    }
    return true;
  }
}
 ?>
