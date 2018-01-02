<?php
namespace mpm\Command\Skyland;

class Skylandcmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("공중섬", "공중섬 명령어입니다.", "/공중섬");
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    $pl->sendMessage($this->api->skylandhelp());
    return true;
  }
}
 ?>
