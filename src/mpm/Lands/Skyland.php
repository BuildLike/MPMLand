<?php
namespace mpm\Lands;

use mpm\Generator\{FieldGenerator, IsLandGenerator, SkyLandGenerator};
use mpm\Command\{Landcmd, LandBuycmd, Landgivecmd, LandSharecmd, LandMovecmd};
use mpm\Lands\{Field, IsLand, Land, SkyLand};
use mpm\Event\{LandEvent};
use mpm\MPMLand;

class IsLand extends MPMLand implements Land{

  private $id;

  private $c;
  public function __construct($id, $owner, Vector3 $vec, $shares = []){
    $this->setConf($id,'Skyland', [
      'owner' => $owner,
      'pos' => [$vec->x, $vec->y, $vec->z],
      'shares' => $shares,
      'option' => []
    ]);
    $this->id = $id;
    $this->c = $this->getConf($id, 'Skyland');
  }

  public static function getId($id){
    if($this->getConf($id) !== null) return false;
    $this->id = $id;
    $this->c = $this->getConf($id, 'Skyland');
    return true;
  }

  final public function setConf(){
    $this->setConf($this->id, $this->c);
  }

  public function getOwnerName(){
    return $this->c ['owner'];
  }

  public function setOwner($owner){
    $this->c ['owner'] = $owner;
  }

  public function addShare($pname){
    array_push($this->c ['shares'], $pname);
  }

  public function getShares() : array{
    return $this->c ['shares'];
  }

  public function outShare($pname){
    unset($this->c ['shares'] [$pname]);
  }

  public function setPvp(bool $value = false){
    $this->c ['option'] ['pvp'] = $value;
  }

  public function getPos() : Position{
    $c = $this->c ['pos'];
    new Position($c[0], $c[1], $c[2], $this->getServer()->getLevelByName('Skyland'));
  }

  public function getWelcomeTitle(){
    return $this->c ['option'] ['welcome'];
  }

  public function setWelcomeTitle($title){
    $this->c ['option'] ['welcome'] = $title;
  }

  public function setOpend(bool $value = false){
    $this->c ['option'] ['open'] = $value;
  }
}

 ?>
