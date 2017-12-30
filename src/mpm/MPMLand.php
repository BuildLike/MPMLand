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
use mpm\Event\{LandEvent, LandBuyEvent, LandgiveEvent, LandShareEvent, LandGetEvent};

/* Author : PS88
 *
 * This php file is modified by GoldBigDragon (OverTook).
 */

class MPMLand extends PluginBase implements Listener{

    public $prefix = "§l§f[§bMPMLand§f]";
    /** @var array*/
    private $c = [];

    private $con;
  /** @var array*/
  private $generators = [
    'Island' => IslandGenerator::class,
    'Skyland' => SkylandGenerator::class,
    'Field' => FieldGenerator::class
  ];


      public function onLoad(){
        $api = new LandAPI();
        $api->LoadConfig();
    }
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents(new Listener(), $this);
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
        /* foreach([
          "Landcmd", "Landbuycmd", "Landgivecmd", "LandSharecmd", "LandMovecmd"
        ] as $class){
          $class = "\\mpm\\Command\\".$class;
          $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), new $class($this, $this->c));
        } */
  }
    public function onDisable(){
      $api = new LandAPI();
      $api->UnLoadConfig();
    }

}
