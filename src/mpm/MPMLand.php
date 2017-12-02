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
use mpm\Command\{Landcmd, LandBuycmd, Landgivecmd, LandSharecmd, LandMovecmd};
use mpm\Lands\{Field, IsLand, Land, SkyLand};
use mpm\Event\{LandEvent};

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
        foreach([
          "Landcmd", "LandBuycmd", "Landgivecmd", "LandSharecmd", "LandMovecmd"
        ] as $class){
          $class = "\\mpm\\Command\\".$class;
          $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), new $class($this, $this->c));
        }
  }
    public function onDisable(){
      $this->c->save();
    //  $this->s->save();
    }

    /** Event Listening Point */
    public function Listen(LandEvent $ev){
      $pl = $ev->getPlayer();
      $id = $ev->getId();
      $type = $ev->getType();
      if($ev instanceof LandGetEvent){
        $m = $type."의 ".$id."번 영토를 가지셨습니다!";
      }elseif($ev instanceof LandGiveEvent){
        $ta = $ev->getTaker();
        $m = $type."의 ".$id."번 영토를 ".$ta->getName()."님에게 주셨습니다.";
        $ta->sendMessage($type."의 ".$id."번 영토를 ".$pl->getName()."님에게 받았습니다.");
      }elseif($ev instanceof LandShareEvent){
        $ta = $ev->getTaker();
        $m = $type."의 ".$id."번 영토를 ".$ta->getName()."님에게 주셨습니다.";
        $ta->sendMessage($type."의 ".$id."번 영토를 ".$pl->getName()."님에게 받았습니다.");
      }elseif($ev instanceof WarpLandEvent){
        $m = $type."의 ".$id."번 영토로 이동하셨습니다!";
      }
      $pl->sendMessage($m);
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
