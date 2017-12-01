<?php
namespace mpm\Lands;

use mpm\Generator\{FieldGenerator, IsLandGenerator, SkyLandGenerator};
use mpm\Command\{Landcmd, LandBuycmd, Landgivecmd, LandSharecmd, LandMovecmd};
use mpm\Lands\{Field, IsLand, SkyLand};
use mpm\Event\{LandEvent};
use mpm\MPMLand;

interface Land{
//  public function setId($id); It's very Dangerous!!

  public function getId($id); //To Search About Land.

  public function __construct($id, $owner, Vector3 $vec, $shares = []);

  public function getOwnerName(); //return Ownername

  public function setOwner($owner);

  public function addShare($pname);

  public function getShares();

  public function outShare($pname);

  public function setPvp(bool $value = false);

  public function getPos() : Position;

  public function getWelcomeTitle();

  public function setWelcomeTitle($title);

  public function setOpend(bool $value = false);
}

 ?>
