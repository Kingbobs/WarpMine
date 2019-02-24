<?php
 
 namespace phuongaz;

  use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
  use pocketmine\event\Listener;
  use pocketmine\{Server, Player};
  use pocketmine\plugin\PluginBase; 

Class Main extends PluginBase implements Listener{
    public $tag = "§l§a[§c MINE §a]";
   
    public function onEnable(){
  $this->getLogger()->info($this->tag."§b Plugin Warp Mine By Phuongaz");
  $this->getServer()->getPluginManager()->registerEvents($this, $this);

}

  public function checkRank(Player $player){
		$rankUp = $this->getServer()->getPluginManager()->getPlugin("RankUp");
		if($rankUp !== null){
			$group = $rankUp->getRankUpDoesGroups()->getPlayerGroup($player);
			if($group !== false){
				return $group;
			}else{
				return false;
			}
		}
		return "Plugin not found";
 
}
  public function checkWarp(Player $player){
   $warpname = $this->checkRank($player);
  $simplewarp =  $this->getServer()->getPluginManager()->getPlugin("SimpleWarp");
 if($simplewarp == null || $this->checkRank($player)){
    return false;
 }else{
   if($warpname == false){
return false;
}
$warp = $simplewarp->getApi()->getWarpName($warpname);
  if($warp !== null){
    return $warp;
   }else{
 $warp = strtolower($warp);
 return $warp;
}
 }
}
private function getPlayerRank(Player $player): string{
		/** @var PurePerms $purePerms */
		$purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
		if($purePerms !== null){
			$group = $purePerms->getUserDataMgr()->getData($player)['group'];
			if($group !== null){
				return $group;
			}else{
				return "No Rank";
			}
		}else{
			return "Plugin not found";
		}
	}
  public function onCommand(CommandSender $sender,Command $cmd, string $label, array $args):bool{
 if($cmd->getName() == "tpmine"){
 if($this->checkWarp($sender) == "No Rank"){
  $this->getLogger()->warning($this->tag." Không tìm thấy [SimpleWarp]");
}
$warp = $this->getPlayerRank($sender);
$name = strtolower($sender->getName());
$this->getServer()->dispatchCommand($sender, "warp $warp");
}
return true;
}
}