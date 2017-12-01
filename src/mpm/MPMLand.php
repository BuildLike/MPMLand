<?php
namespace mpm;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use onebone\economyapi\EconomyAPI;
use pocketmine\level\generator\Generator;

use mpm\Generator\{FieldGenerator, IsLandGenerator, SkyLandGenerator};

/* Author : PS88
 *
 * This php file is modified by GoldBigDragon (OverTook).
 */

class MPMLand extends PluginBase implements Listener{

    public $prefix = "§l§f[§bMPMLand§f]";
    /** @var array*/
    private $c;
  /** @var array*/
  private $generators = [
    'Island' => IsLandGenerator::class,
    'Skyland' => SkylandGenerator::class,
    'Field' => FieldGenerator::class
  ];


      public function onLoad(){
        @mkdir($this->getDataFolder());
          $this->c = new Config($this->getDataFolder().'data.json', Config::JSON, [
              'Island' => [],
              'Skyland' => [],
              'Land' => [],
          ]);
          $this->c = $this->c->getAll();
    }
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    if(!file_exists($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
        $downRP = false;
        if(!file_exists($this->getDataFolder() . "sspe12_2.mcpack")) {
            $downRP = true;
            echo TextFormat::toANSI("§l§f[§bMPMLand§f] 리소스팩 다운중");
            file_put_contents($this->getDataFolder() . "sspe12_2.mcpack", Utils::getURL("http://ryfol.weebly.com/uploads/4/7/6/5/47651895/sspe13_1.mcpack"));
        }
        echo str_repeat("\010", $downRP ? strlen(TextFormat::toANSI("§l§f[§bMPMLand§f] 리소스팩 다운중")) : 0) . TextFormat::toANSI("§f[Spooky] ⚪ Applying resource pack...   "); // Replacing latest message
        $pack = new ZippedResourcePack($this->getDataFolder() . "sspe12_2.mcpack");
        $r = new \ReflectionClass("pocketmine\\resourcepacks\\ResourcePackManager");
        // Reflection because devs thought it was a great idea to not let plugins manage resource packs :/
        $resourcePacks = $r->getProperty("resourcePacks");
        $resourcePacks->setAccessible(true);
        $rps = $resourcePacks->getValue($this->getServer()->getResourceManager());
        $rps[] = $pack;
        $resourcePacks->setValue($this->getServer()->getResourceManager(), $rps);
        $resourceUuids = $r->getProperty("uuidList");
        $resourceUuids->setAccessible(true);
        $uuids = $resourceUuids->getValue($this->getServer()->getResourceManager());
        $uuids[$pack->getPackId()] = $pack;
        $resourceUuids->setValue($this->getServer()->getResourceManager(), $uuids);
        // Forcing resource packs. We want the client to hear the music!
        $forceResources = $r->getProperty("serverForceResources");
        $forceResources->setAccessible(true);
        $forceResources->setValue($this->getServer()->getResourceManager(), true);
        echo str_repeat("\010", strlen("⚪ Applying resource pack... ")) . TextFormat::toANSI("§a✔️ 리소스팩 로드완료    \n");

        foreach ($this->generators as $name => $class) {
          Generator::addGenerator($class, $name);
      		$gener = Generator::getGenerator($name);

      		if(!($this->getServer()->loadLevel($name))){
      			@mkdir($this->getServer()->getDataPath() . "/" . "worlds" . "/" . $name);
      			$options = [];
      			$this->getServer()->generateLevel($name, 0, $gener, $options);
      			$this->getLogger()->info($name." was maded.");
      		}
      		$this->getLogger()->info($name." Loaded");
        }
  }
    public function onDisable(){
      $this->c->save();
      $this->s->save();
    }

    public function onCommand(CommandSender $pl, Command $cmd, String $label, array $args) : bool{
      if(! $pl instanceof Player){
        $this->getLogger()->info($this->prefix."서버에서만 사용가능합니다.");
        return true;
      }
      $pr = $this->prefix;
          switch($cmd->getName()){
            case '땅구매':
              if(EconomyAPI::getInstance()->myMoney($pl->getName()) < 20000){
                $pl->sendMessage($pr."돈이 부족합니다. ".$type." 가격 : 20000won");
                return true;
              }
              if(! isset($args[0])){$pl->sendMessage($pr."/땅구매 [타입] (번호[기본값 : 남은 섬중 제일 낮은 섬의 번호])"); return true;}
              if(! isset($this->c[$args[0]])){$pl->sendMessage($pr." 타입종류 : Island, Skyland, Field"); return true;}
              $a = [];
              foreach($this->c[$args[0]] as $id => $data){
                if(isset($data)) continue;
                array_push($a, $id);
                if(count($a) >= 10) break;
              }
              $d = [];
              foreach($this->c[$args[0]] as $id => $data){
                if(! isset($data) or $data['owner'] !== $pl->getName()) continue;
                array_push($d, $id);
                if(count($d) >= 3){$pl->sendMessage($pr."섬 개수가 일정 제한을 넘었습니다."); return true;}
              }
              $num = (! isset($args[0]))? $a[0] : $args[1];
              if(isset($this->c[$args[0]] [$args[1]] ['owner'])){$pl->sendMessage($pr."이미 섬 주인이 있습니다.."); return true;}
              switch($args[0]){
                case 'Island': $class = new IsLand($num, $pl->getName(), new Vector3(103 + $num * 200, 12, 297));
                case 'SkyLand': $class = new SkyLand($num, $pl->getName(), new Vector3(103 + $num * 200, 12, 297));
                case 'Field': $class = new Field($num, $pl->getName());
              }
              //$this->getServer()->getPluginManager()->callEvent();
             break;
           case '땅양도':
             if(! isset($args[0])){$pl->sendMessage($pr."/땅양도 [플레이어]"); return true;}
             if(! isset($this->c[$pl->getLevel()->getName()]])){$pl->sendMessage($pr."당신은 섬, 하늘섬, 평지중 한 월드에 있어야 합니다."); return true;}
             $a = 0;
             switch($pl->getLevel()->getName()){
               case 'Island': $cl = 200;
               case 'SkyLand': $cl = 200;
               case 'Field': $cl = 30;
             }
             foreach($this->c[$pl->getLevel()->getName()] as $id => $data){
               if(! isset($data) or $pl->distance(new Vector3(103 + $id * 200, 12, 297)) >= $cl) continue;
               $a = $id; break;
             }
             switch($pl->getLevel()->getName()){
               case 'Island': $class = Island::getId($a);
               case 'SkyLand': $class = Skyland::getId($a);
               case 'Field': $class = Field::getId($a);
             }
             if($class !== null or $class->getOwner() !== $pl->getName()){$pl->sendMessage($pr."당신의 땅에서만 가능한 작업입니다."); return true;}
             $d = [];
             foreach($this->c[$pl->getLevel()->getName()] as $id => $data){
               if(! isset($data) or $data['owner'] !== $args[0]) continue;
               array_push($d, $id);
               if(count($d) >= 3){$pl->sendMessage($pr."플레이어의 섬 개수가 일정 제한을 넘었습니다."); return true;}
             }
             $class->setOwner($args[0]);
            break;
           case '땅이동':
             if(! isset($args[0]) or ! isset($args[1])){$pl->sendMessage($pr."/땅이동 [타입] [번호]"); return true;}
             if(! isset($this->c[$args[0]])){$pl->sendMessage($pr." 타입종류 : Island, Skyland, Field"); return true;}
             $a = $args[0];
             switch($args[1]){
               case 'Island': $class = Island::getId($a);
               case 'SkyLand': $class = Skyland::getId($a);
               case 'Field': $class = Field::getId($a);
             }
             $pl->teleport($class->getPos());
             //$this->getServer()->getPluginManager()->callEvent();
            break;
           case '땅공유':
           if(! isset($args[0])){$pl->sendMessage($pr."/땅공유 [플레이어]"); return true;}
           if(! isset($this->c[$pl->getLevel()->getName()]])){$pl->sendMessage($pr."당신은 섬, 하늘섬, 평지중 한 월드에 있어야 합니다."); return true;}
           $a = 0;
           switch($pl->getLevel()->getName()){
             case 'Island': $cl = 200;
             case 'SkyLand': $cl = 200;
             case 'Field': $cl = 30;
           }
           foreach($this->c[$pl->getLevel()->getName()] as $id => $data){
             if(! isset($data) or $pl->distance(new Vector3(103 + $id * 200, 12, 297)) >= $cl) continue;
             $a = $id; break;
           }
           switch($pl->getLevel()->getName()){
             case 'Island': $class = Island::getId($a);
             case 'SkyLand': $class = Skyland::getId($a);
             case 'Field': $class = Field::getId($a);
           }
           if($class !== null or $class->getOwner() !== $pl->getName()){$pl->sendMessage($pr."당신의 땅에서만 가능한 작업입니다."); return true;}
           if(isset($class->getShares()[$args[0]])){$class->outShare($args[0]);}else{$class->addShare($args[0]);}
          break;
           case '땅':
             $pl->sendMessage($pr." /땅구매 [타입] (번호[기본값 : 남은 섬중 제일 낮은 섬의 번호]) §o§8- [타입]에 있는 [번호]를 구매합니다.");
             $pl->sendMessage($pr." /땅양도 [플레이어] §o§8- 땅을 [플레이어] 에게 양도합니다.");
             $pl->sendMessage($pr." /땅이동 [타입] [번호] §o§8- [타입]의 [번호]으로 갑니다.");
             $pl->sendMessage($pr." /땅공유 [플레이어] §o§8- 이땅을 [플레이어]에게 공유/공유해제 시킵니다.");
             $pl->sendMessage($pr." /땅목록 (개수[기본값 : 10])§o§8- 남은 섬 중 [개수]만큼을 구합니다.");
             $pl->sendMessage($pr." 타입종류 : Island, Skyland, Field");
            break;
    }return true;
}

/** For Implemented Land Classes */
public function setConfig($id, $type, array $data){
  $this->c[$id] = $data;
}
public function getConfig($id, $type) : array{
  return $this->c[$id];
}
public function getLands($name, $type) : array{
   $a = [];
   foreach($this->c as $id => $data){
     if($data['owner'] !== $name) continue;
     array_push($a, $id);
   }
   return $a;
}

    /**EventListning Point*/
}
