<?php
namespace mpm;

class LandAPI extends MPMLand{
  /** @var Config */
  private $con;

  /** @var array */
  private $c;

  /** @var string */
  private $type;

  /** @var int */
  private $num;

  /** @var string[] */
  private $types = [
    'Island',
    'Field',
    'Skyland'
  ];



  public function LoadConfig(){
    @mkdir($this->getDataFolder());
      $this->con = new Config($this->getDataFolder().'data.json', Config::JSON, [
          'Island' => [],
          'Skyland' => [],
          'Land' => [],
      ]);
      $this->c = $this->con->getAll();
  }

  public function UnLoadConfig(){
    $this->con->setAll($this->c);
    $this->con->save();
  }

  public static function getAll() : array{
    return $this->c;
  }

  public static function setAll($v = []){
    $this->c = $v;
  }
}
 ?>
