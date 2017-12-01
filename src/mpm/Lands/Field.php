<?php
namespace mpm\Lands;

class IsLand extends MPMLand implements Land{

  private $id;

  private $c;
  public function __construct($id, $owner, Vector3 $vec, $shares = []){
    $this->setConfig($id,'land', [
      'owner' => $owner,
      'pos' => [$vec->x, $vec->y, $vec->z],
      'shares' => $shares,
      'option' => []
    ]);
    $this->id = $id;
    $this->c = $this->getConfig($id, 'land');
  }

  public static function getId($id){
    if($this->getConfig($id) !== null) return false;
    $this->id = $id;
    $this->c = $this->getConfig($id, 'land');
    return true;
  }

  final public function setConfig(){
    $this->setConfig($this->id, $this->c);
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
    new Position($c[0], $c[1], $c[2], $this->getServer()->getLevelByName('Field'));
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
