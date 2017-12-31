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
    parent::__construct("땅이동", $api->cmdhelp['LandWarp'], "/땅이동 [타입] [번호]", ['타입', '번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if(! isset($this->api->types[$i[0]])){
      $pl->sendMessage(MPMLand::$prefix."땅 종류에는 여러가지가 있습니다.");
      foreach ($this->api->types as $key) {
        $pl->sendMessage($key);
      }
      return true;
    }
    if(! isset($this->c[$i[0]] [$i[1]]){
      $pl->sendMessage(MPMLand::$prefix."해당 땅은 없거나 등록되지 않았습니다.");
      return true;
    }
    switch($i[0]){
      case "field":
      new FieldWarp($i[1], $pl);
      break;
      case "island":
      new IslandWarp($i[1], $pl);
      break;
      case "skyland":
      new SkylandWarp($i[1], $pl);
      break;
      case "Land":
      new LandWarp($i[1], $pl);
      break;
    }
    return true;
  }
}
 ?>
