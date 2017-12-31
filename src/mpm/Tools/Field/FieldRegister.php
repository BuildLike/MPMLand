<?php
namespace mpm\Tools\Field;

class FieldRegister{
  /** @var array*/
  private $c;


  public function __construct(int $num = null, Vector2 $fpos, Vector2 $lpos){
    $this->c = LandAPI::getAll();
    if($num == null){
      $r = [];
      foreach ($this->c['field'] as $key => $value) {
        array_push($r, $key);
      }
      $m = 1;
      for ($i=0; $i >= $m; $i++) {
       if(isset($r[$i])){
         $m++; continue;
       }
       $m = $i;
       break;
      }
      $num = $m;
    }
    $this->configset($num, $fpos, $lpos);
    LandAPI::setAll($this->c);
    return true;
  }
  public function configset($num, Vector2 $fpos, Vector2 $lpos){
    $this->c['field'] [$num] = [
      'owner' => null,
      'pos' => [
        'mpos' => [($fpos->x + $lpos->x)/2, ($fpos->y + $lpos->y)/2],
        'fpos' => [$fpos->x, $fpos->y],
        'lpos' => [$lpos->x, $lpos->y]
      ],
      'share' => [],
      'options' => []
    ];
    return true;
  }
}
 ?>
