<?php
namespace mpm\Command\SkyLand;

class SkylandBuycmd extends Command{
  /** @var LandAPI */
  private $api;

  /** @var array */
  private $c;

  public function __construct(LandAPI $api, $c){
    $this->api = $api;
    $this->c = $c;
    parent::__construct("공중섬구매", "공중섬을 구매합니다", "/공중섬구매 [번호]", ['번호']);
  }

  public function execute(CommandSender $pl, string $commandLabel, array $i) : bool{
      new SkylandAdd($i[1], new Vector2(103 + $i[1] * 200, 297),$pl);
    return true;
  }
}
 ?>
