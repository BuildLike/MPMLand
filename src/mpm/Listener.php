<?php
namespace mpm;

class Listener implements Listener{

  /** @var LandAPI */
  private $api;

  public function blockbreak(BlockBreakEvent $ev){
    $pl = $ev->getPlayer();
    if($this->api->getLandByPlayer($pl) == true or $this->api->getLandByPlayer($pl)['owner'] == $pl->getName() or isset($this->api->getLandByPlayer($pl)['share'] [$pl->getName()])){
      $ev->setCancelled(false);
    }else{
      $ev->setCancelled(true);
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
    }
  }

  public function blockplace(BlockPlaceEvent $ev){
    $pl = $ev->getPlayer();
    if($this->api->getLandByPlayer($pl) == true or $this->api->getLandByPlayer($pl)['owner'] == $pl->getName() or isset($this->api->getLandByPlayer($pl)['share'] [$pl->getName()])){
      $ev->setCancelled(false);
    }else{
      $ev->setCancelled(true);
      $pl->sendMessage(MPMLand::$prefix."당신의 영역이 아닙니다.");
    }
  }
}
 ?>
