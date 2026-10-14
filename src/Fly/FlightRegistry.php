<?php

declare(strict_types=1);

namespace Fly;

final class FlightRegistry{
	/** @var array<string, true> */
	private array $activePlayers = [];
	/** @var array<string, bool> */
	private array $previousAllowFlight = [];

	public function activate(string $playerId, bool $allowFlightBeforePlugin) : void{
		$this->activePlayers[$playerId] = true;
		$this->previousAllowFlight[$playerId] = $allowFlightBeforePlugin;
	}

	public function isActive(string $playerId) : bool{
		return isset($this->activePlayers[$playerId]);
	}

	public function deactivate(string $playerId) : ?bool{
		if(!isset($this->activePlayers[$playerId])){
			return null;
		}
		unset($this->activePlayers[$playerId]);
		$allowFlightBeforePlugin = $this->previousAllowFlight[$playerId];
		unset($this->previousAllowFlight[$playerId]);
		return $allowFlightBeforePlugin;
	}
}
