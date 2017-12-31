<?php
namespace mpm\Command\Field;

class FieldBuycmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("평야구매", $api->cmdhelp['LandBuy'], "/평야구매 [번호]", ['번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
     if (! isset($i[0])){
       $pl->sendMessage(MPMLand::$prefix."/평야구매 [번호]");
       return true;
     }
      case "field":
      new FieldAdd($i[0],null,$pl);
    return true;
  }
}
 ?>
