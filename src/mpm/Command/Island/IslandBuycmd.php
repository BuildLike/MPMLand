<?php
namespace mpm\Command\Island;

class IslandBuycmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("섬구매", "", "/섬구매 [번호]", ['번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
      new IslandAdd($i[1], new Vector2(103 + $i[1] * 200, 297),$pl);
    return true;
  }
}
 ?>
