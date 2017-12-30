<?php
namespace mpm\Api;

use mpm\MPMLand;

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
  protected $types = [
    'island',
    'field',
    'skyland',
    'Land'
  ];

  /** @var string[] */
  protected $cmdhelp = [
    'Land' => "땅에 대한 명령어들을 봅니다.",
    'LandWarp' => "/땅이동 [타입] [번호] - [타입]의 [번호]로 이동합니다.",
    'LandBuy' => "/땅구매 [타입] [번호] - [타입]의 [번호]를 구매합니다.",
    'LandShare' => "/땅공유 [플레이어] - [플레이어]를 현재 땅에서 공유시킵니다.",
    'LandUnShare' => "/땅공유해제 [플레이어] - [플레이어]를 현재 땅에서 공유해제시킵니다.",
    'LandGive' => "/땅양도 [플레이어] - [플레이어]에게 현재 땅을 양도합니다."
  ];



  public function LoadConfig(){
    @mkdir($this->getDataFolder());
      $this->con = new Config($this->getDataFolder().'data.json', Config::JSON, [
          'island' => [],
          'skyland' => [],
          'field' => [],
          'Land' => []
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

  public function getLand($type, $num) : array{
    return $this->c[$type] [$num];
  }

  public function getOwner($type, $num) : string{
    return $this->c[$type] [$num] ['owner'];
  }

  public function getShare($type, $num) : array{
    return $this->c[$type] [$num] ['share'];
  }

  public function getOptions($type, $num) : array{
    return $this->c[$type] [$num] ['options'];
  }

  public function setOption($type, $num, $key, $v){
    $this->c[$type] [$num] ['option'] [$key] = $v;
    return true;
  }

  public function getLandByPlayer(Player $pl){
    foreach ($this->c as $key => $value) {
      foreach ($value as $num => $info) {
        if($key == "Land"){
          if($pl->getLevel()->getName() !== $info['fpos'][3]) continue;
          if($pl->x >= $info['fpos'][0] || $pl->z >= $info['fpos'][2] || $pl->x <= $info['lpos'][0] || $pl->z <= $info['lpos'][2]){
            return $info;
          }
        }elseif ($key == "field") {
          if($pl->getLevel()->getName() !== "field") continue;
          if($pl->x >= $info['fpos'][0] || $pl->z >= $info['fpos'][2] || $pl->x <= $info['lpos'][0] || $pl->z <= $info['lpos'][2]){
            return $info;
          }else{
            if($pl->getLevel()->getName() !== $key) continue;
              if($pl->direction(new Vector3($info['pos'][0], $pl->y, $info['pos'][1])) <= 200){
                return $info;
              }
          }
        }
      }
    }
    return false;
  }
}
 ?>
