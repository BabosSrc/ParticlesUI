<?php

namespace Plate\Particle;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\math\Vector3;

use pocketmine\scheduler\Task;

use pocketmine\level\particle\DustParticle;

class Main extends PluginBase {

	public $red = [];
	public $blue = [];
	public $green = [];
	public $yellow = [];

	public function onEnable() {
		$this->getScheduler()->scheduleRepeatingTask(new ParticleTask($this), 5);
	}

	public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {

		switch($cmd->getName()){
			case "pc":
			 if($sender instanceof Player) {
			 	$this->formUI($sender);
			 } else {
			 	$sender->sendMessage("NO PLAYER YOU E");
			 }
			break;
		}
		return true;
	}

	public function formUI($player){
		$form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $player, int $data = null){
			if($data === null){
				return true;
			}
			switch($data){
				case 0:
				 if(in_array($player, $this->red)){
				 	$player->sendMessage("ALREADY ACTIVE RED PARTICLE IS UWU");
				 	return true;
				 } else {
				 	unset($this->blue[$player->getName()]);
				 	unset($this->green[$player->getName()]);
				 	unset($this->yellow[$player->getName()]);
				 	$this->red[$player->getName()] = $player->getName();
				 }
				break;

				case 1:
				 if(in_array($player, $this->red)){
				 	$player->sendMessage("ALREADY ACTIVE BLUE PARTICLE IS UWU");
				 	return true;
				 } else {
				 	unset($this->red[$player->getName()]);
				 	unset($this->green[$player->getName()]);
				 	unset($this->yellow[$player->getName()]);
				 	$this->blue[$player->getName()] = $player->getName();
				 }
				break;

				case 2:
				 if(in_array($player, $this->red)){
				 	$player->sendMessage("ALREADY ACTIVE GREEN PARTICLE IS UWU");
				 	return true;
				 } else {
				 	unset($this->blue[$player->getName()]);
				 	unset($this->red[$player->getName()]);
				 	unset($this->yellow[$player->getName()]);
				 	$this->green[$player->getName()] = $player->getName();
				 }
				break;

				case 3:
				 if(in_array($player, $this->red)){
				 	$player->sendMessage("ALREADY ACTIVE YELLOW PARTICLE IS UWU");
				 	return true;
				 } else {
				 	unset($this->blue[$player->getName()]);
				 	unset($this->green[$player->getName()]);
				 	unset($this->red[$player->getName()]);
				 	$this->yellow[$player->getName()] = $player->getName();
				 }
				break;

				case 4:
				 	unset($this->blue[$player->getName()]);
				 	unset($this->green[$player->getName()]);
				 	unset($this->red[$player->getName()]);
				 	unset($this->yellow[$player->getName()]);
				break;
			}
		});
		$form->setTitle("PARTICLE MENU UWU");
		$form->setContent("ALL THE PARTICLES IS UWU UWU WU SELECT NOW");
		$form->addButton("RED COLOR");
		$form->addButton("BLUE COLOR");
		$form->addButton("GREEN COLOR");
		$form->addButton("YELLOW COLOR");
		$form->addButton("CLEAR PARTICLE");
		$form->sendToPlayer($player);
		return $form;
	}

}

class ParticleTask extends Task {

	public function __construct($plugin){
		$this->plugin = $plugin;
	}

	public function onRun($tick){
		foreach($this->plugin->getServer()->getOnlinePlayers() as $p){
			$player = $p->getName();
			$level = $p->getLevel();

			$x = $p->getX();
			$y = $p->getY();
			$z = $p->getZ();
			if(in_array($player, $this->plugin->red)){
				$center = new Vector3($x, $y+0.5, $z);
				$particle = new DustParticle($center, 255,0,0);

				for ($yaw = 0, $y = $center->y; $y < $center->y + 2; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
					$x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$particle->setComponents($x, $y+0.5, $z);
					$level->addParticle($particle);
				}
			}

			if(in_array($player, $this->plugin->blue)){
				$center = new Vector3($x, $y+0.5, $z);
				$particle = new DustParticle($center, 0,0,255);

				for ($yaw = 0, $y = $center->y; $y < $center->y + 2; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
					$x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$particle->setComponents($x, $y+0.5, $z);
					$level->addParticle($particle);
				}
			}

			if(in_array($player, $this->plugin->green)){
				$center = new Vector3($x, $y+0.5, $z);
				$particle = new DustParticle($center, 0,255,0);

				for ($yaw = 0, $y = $center->y; $y < $center->y + 2; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
					$x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$particle->setComponents($x, $y+0.5, $z);
					$level->addParticle($particle);
				}
			}

			if(in_array($player, $this->plugin->yellow)){
				$center = new Vector3($x, $y+0.5, $z);
				$particle = new DustParticle($center, 255,255,0);

				for ($yaw = 0, $y = $center->y; $y < $center->y + 2; $yaw += (M_PI * 2) / 20, $y += 1 / 20){
					$x = -sin($yaw) + $center->x;
					$z = cos($yaw) + $center->z;
					$particle->setComponents($x, $y+0.5, $z);
					$level->addParticle($particle);
				}
			}
		}
	}

}