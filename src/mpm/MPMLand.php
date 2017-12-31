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
use mpm\Api\LandAPI;
use mpm\Generator\{FieldGenerator, IsLandGenerator, SkyLandGenerator};
use mpm\Command\{Landcmd, LandBuycmd, LandGivecmd, LandSharecmd, LandUnsharecmd, LandMovecmd};
use mpm\Tools\Island\{IslandAdd, IslandGive, IslandInfo, IslandShare, IslandUnshare, IslandWarp};
use mpm\Tools\Field\{FieldAdd, FieldGive, FieldInfo, FieldRegister, FieldShare, FieldUnshare, FieldWarp};
use mpm\Tools\Land\{LandAdd, LandGive, LandInfo, LandRegister, LandShare, LandUnshare, LandWarp};
use mpm\Tools\Skyland\{SkylandAdd, SkylandGive, SkylandInfo, SkylandShare, SkylandUnshare, SkylandWarp};
use mpm\Listener;

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
    'island' => IsLandGenerator::class,
    'skyland' => SkyLandGenerator::class,
    'field' => FieldGenerator::class
  ];


      public function onLoad(){
        $api = new LandAPI();

    }
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents(new Listener(), $this);

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
          "Landcmd", "LandBuycmd", "LandGivecmd", "LandSharecmd", "LandUnsharecmd","LandWarpcmd"
        ] as $class){
          $class = "\\mpm\\Command\\".$class;
          $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), new $class(new LandAPI(), $this->c));
        }
  }
    public function onDisable(){
      $api = new LandAPI();
      $api->UnLoadConfig();
    }

}
