<?php

declare(strict_types=1);

require dirname(__DIR__) . "/src/Fly/FlightRegistry.php";

use Fly\FlightRegistry;

$registry = new FlightRegistry();
$player = "550e8400-e29b-41d4-a716-446655440000";

if($registry->isActive($player)){
	throw new RuntimeException("Enabling flight mode must register the player.");
}
$registry->activate($player, false);
if(!$registry->isActive($player) || $registry->deactivate($player) !== false || $registry->isActive($player)){
	throw new RuntimeException("Disabling flight mode must restore the player's original disallowed state.");
}
$registry->activate($player, true);
if($registry->deactivate($player) !== true || $registry->isActive($player)){
	throw new RuntimeException("Disabling the plugin must preserve pre-existing flight permission.");
}
if($registry->deactivate($player) !== null){
	throw new RuntimeException("An inactive player must not have a previous state to restore.");
}

echo "Flight mode state checks passed.\n";
