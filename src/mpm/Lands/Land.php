<?php
namespace mpm\Lands;

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
