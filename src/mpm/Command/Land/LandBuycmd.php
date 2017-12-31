<?php
namespace mpm\Command\Land;

class LandBuycmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("땅구매","땅을 구매합니다.", "/땅구매 [번호]", ['타입', '번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
      case "Land":
      new LandAdd($i[0], $pl);
      break;
    }
    return true;
  }
}
 ?>
