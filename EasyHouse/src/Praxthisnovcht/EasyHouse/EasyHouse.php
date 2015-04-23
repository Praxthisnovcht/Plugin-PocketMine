<?

namespace Praxthisnovcht\EasyHouse;

use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\level\Position;

class EasyHouse extends PluginBase implements Listener {
	
	private $config;
	
	private $viellePosition = array();	
	
	private $last = array( 'player' => array(), );
		 
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
			 $this->config = new Config($this->getDataFolder().'data.yml', Config::YAML , $this->last);
		         $this->getServer()->getLogger()->info(TextFormat::GREEN ."EasyHouse By Praxthisnovcht Enabled !");
	                 }
	
	public function onDisable(){
		 $this->config->save();
		     $this->getServer()->getLogger()->info(TextFormat::GREEN ."EasyHouse By Praxthisnovcht Disabled !");
	             }

	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){	
         if($player->hasPermission("signstats.commands.stats")){	
		     switch($command->getName()){			
			     case 'sethouse':
				     $this->config->player[$sender->getName()]['house']['x'] = $sender->x;
				         $this->config->player[$sender->getName()]['house']['y'] = $sender->y;
				             $this->config->player[$sender->getName()]['house']['z'] = $sender->z;
				                 $sender->sendMessage(TextFormat::GREEN .'[EasyHouse] House set.');
				                     break;			
			                             case 'delhouse':
				                             unset($this->config->player[$sender->getName()]['house']);
				                                 $sender->sendMessage(TextFormat::RED .'[EasyHouse] house Deleted');
				                                     break;			
			                                             case 'house':
				                                             if(isset($this->config->player[$sender->getName()]['house'])){
					                                             $this->viellePosition[$sender->getName()] = array($sender->x, $sender->y, $sender->z);
					                                                      $sender->teleport(new Vector3($this->config->player[$sender->getName()]['house']['x'], $this->config->player[$sender->getName()]['house']['y'], $this->config->player[$sender->getName()]['house']['z']));
					                                                         $sender->sendMessage(TextFormat::GREEN .'[EasyHouse] Teleported.');
				                                                                 } else {
					                                                                         $sender->sendMessage(TextFormat::RED .'House is not set.');
				                                                                                 }
				                                                                                     break;
			                                                                                             }			
			                                                                                                 }else{
				                                                                                                 $player->sendMessage(TextFormat::RED ."[EasyHouse] You don't have permissions!");
		                                                                                                             }
	                                                                                                                     }			
                                                                                                                             }
