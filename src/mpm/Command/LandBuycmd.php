<?php
namespace mpm\Command;

class LandBuycmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("땅구매", $api->cmdhelp['LandBuy'], "/땅구매 [타입] [번호]", ['타입', '번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
    if(! isset($this->api->types[$i[0]])){
      $pl->sendMessage(MPMLand::$prefix."땅 종류에는 여러가지가 있습니다.");
      foreach ($this->api->types as $key) {
        $pl->sendMessage($key);
      }
      return true;
    }
    switch($i[0]){
      case "field":
      new FieldAdd($i[1],null,$pl);
      break;
      case "island":
      new IslandAdd($i[1], new Vector2(103 + $i[1] * 200, 297),$pl);
      break;
      case "skyland":
      new SkylandAdd($i[1], new Vector2(103 + $i[1] * 200, 297),$pl);
      break;
      case "Land":
      new LandAdd($i[1], null, $pl);
      break;
    }
    return true;
  }
}
 ?>
