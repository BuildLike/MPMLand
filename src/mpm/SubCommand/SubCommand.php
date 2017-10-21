<?php
namespace mpm\SubCommand;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use mpm\main;
use onebone\economyapi\EconomyAPI;

class SubCommand extends PluginBase implements Listener{
    public function __construct(CommandSender $pl, array $args){
        $this->pl = $pl;
        $this->args = $args;
        //parent::__construct($pl, $args);
    }
    public function execute() : bool{
        $main = new main();
        $pl = $this->pl;
        $args = $this->args;
        switch ($args[0]){
            /*case '����':
                if(! $pl->isOp()) return true;*/
            case '����':
                if(EconomyAPI::getInstance()->myMoney($pl->getName()) < 20000){
                    $pl->sendMessage($main->prefix."���� �����ϴ�.");
                    return true;
                }
                $as = [];
                for($i = 0; $i >= count($main->c->get('island')); $i++){
                    if($main->getIsOwner($i) !== $args[1]) return true;
                    array_push($as, $i);
                }
                if(count($as) >= 3){
                    $pl->sendMessage($main->prefix."����� �� ������ �ִ븦 ä�����ϴ�.");
                    return true;
                }
                $main->setIs($pl->getName(), count($main->c->get('island')));
                return true;
            case '�絵':
                if(! isset($args[1])){
                    $pl->sendMessage($main->prefix." /�� �絵 [�÷��̾�]");
                    return true;
                }
                if($main->getIsNum($pl) !== null){
                    $pl->sendMessage($main->prefix."����� �ƹ� ������ ���� �ʽ��ϴ�.");
                    return true;
                }
                if($main->getIsOwner($main->getIsNum($pl)) !== $pl->getName()){
                    $pl->sendMessage($main->prefix."����� ���� �ƴմϴ�.");
                    return true;
                }
                $main->c->get('island')[$main->getIsNum($pl)] ['owner'] = $args[1];
                $pl->sendMessage($main->prefix."�� ����".$args[1]."�Կ��� �絵�Ͽ����ϴ�.");
                return true;
            case '����':
                if(! isset($args[1])){
                    $pl->sendMessage($main->prefix." /�� ���� [�÷��̾�]");
                    return true;
                }elseif($main->getIsNum($pl) !== null){
                    $pl->sendMessage($main->prefix."����� �ƹ� ������ ���� �ʽ��ϴ�.");
                    return true;
                }elseif($main->getIsOwner($main->getIsNum($pl)) !== $pl->getName()){
                    $pl->sendMessage($main->prefix."����� ���� �ƴմϴ�.");
                    return true;
                }elseif(! $pl->isOp()){
                }
                for($i = 0; $i >= count($main->c->get('island')[$main->getIsNum($pl)] ['share']); $i++){
                    if ($main->c->get('island')[$main->getIsNum($pl)] ['share'][$i] !== $args[1]) return true;
                    $a = true;
                }
                if(isset($a)){
                    array_unshift($main->c->get('island')[$main->getIsNum($pl)] ['share'], $args[1]);
                    $pl->sendMessage($main->prefix.$args[1]."���� �� �����ڿ��� ��Ż��Ű�̽��ϴ�.");
                    return true;
                }
                array_push($main->c->get('island')[$main->getIsNum($pl)] ['share'], $args[1]);
                $pl->sendMessage($main->prefix."�� ����".$args[1]."�Կ��� �����Ͽ����ϴ�."); return true;
            case '�̵�':
                if(! is_numerick($args[1])){
                    $as = [];
                    for($i = 0; $i >= count($main->c->get('island')); $i++){
                        if($main->getIsOwner($i) !== $args[1]) return true;
                        array_push($as, "[".$i."]");
                    }
                    $pl->sendMessage($main->prefix.$args[1]."���� �� ����� ǥ���մϴ�.");
                    $pl->sendMessage($as);
                    return true;
                }
                $main->WarpIs($pl, $args[1]);
                return true;
        }
    }
}