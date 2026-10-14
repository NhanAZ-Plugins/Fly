<?php

declare(strict_types=1);

namespace Fly;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

final class Main extends PluginBase implements Listener{
	private FlightRegistry $flightRegistry;

	/** @var array<string, Player> */
	private array $players = [];

	protected function onEnable() : void{
		$this->flightRegistry = new FlightRegistry();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info(TextFormat::GREEN . "Plugin Fly v2 enabled");
	}

	protected function onDisable() : void{
		foreach($this->players as $playerId => $player){
			$allowFlightBeforePlugin = $this->flightRegistry->deactivate($playerId);
			if($allowFlightBeforePlugin !== null){
				$this->restoreFlight($player, $allowFlightBeforePlugin);
			}
		}
		$this->players = [];
		$this->getLogger()->info(TextFormat::RED . "Plugin Fly disabled");
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if(strtolower($command->getName()) !== "fly"){
			return false;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage(TextFormat::RED . "Lệnh này chỉ dùng trong game.");
			return true;
		}

		$playerId = $sender->getUniqueId()->toString();
		if(!$this->flightRegistry->isActive($playerId)){
			$this->flightRegistry->activate($playerId, $sender->getAllowFlight());
			$sender->setAllowFlight(true);
			$this->players[$playerId] = $sender;
			$sender->sendMessage(TextFormat::YELLOW . "§e༺§l§bＦＬＹ§r§e༻§a§l Chế Độ Fly Đã Kích Hoạt");
			return true;
		}

		$allowFlightBeforePlugin = $this->flightRegistry->deactivate($playerId);
		if($allowFlightBeforePlugin !== null){
			$this->restoreFlight($sender, $allowFlightBeforePlugin);
		}
		unset($this->players[$playerId]);
		$sender->sendMessage(TextFormat::YELLOW . "§e༺§l§bＦＬＹ§r§e༻§c§l Chế Độ Fly Đã Vô Hiệu Hóa");
		return true;
	}

	public function onEntityDamageByEntity(EntityDamageByEntityEvent $event) : void{
		if($event->isCancelled()){
			return;
		}
		$damager = $event->getDamager();
		if($damager instanceof Player && $this->flightRegistry->isActive($damager->getUniqueId()->toString())){
			$damager->sendTip("§e༺§l§bＦＬＹ§r§e༻§l§c Vui Lòng Tắt Fly Để PvP. Cám Ơn!");
			$event->cancel();
		}
	}

	public function onPlayerQuit(PlayerQuitEvent $event) : void{
		$player = $event->getPlayer();
		$playerId = $player->getUniqueId()->toString();
		$allowFlightBeforePlugin = $this->flightRegistry->deactivate($playerId);
		if($allowFlightBeforePlugin !== null){
			$this->restoreFlight($player, $allowFlightBeforePlugin);
		}
		unset($this->players[$playerId]);
	}

	private function restoreFlight(Player $player, bool $allowFlightBeforePlugin) : void{
		if($allowFlightBeforePlugin){
			$player->setAllowFlight(true);
			return;
		}
		$player->setFlying(false);
		$player->setAllowFlight(false);
	}
}
