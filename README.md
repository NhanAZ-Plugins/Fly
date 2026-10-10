# Fly

Fly is a legacy PocketMine-MP plugin snapshot with a `/fly` command and a PvP restriction for players tracked as flying. Its manifest declares plugin API 2.0.0, and the source uses the old `pocketmine\Player` class. This code has not been verified on Axolotl-PM 5.x and is not a current Axolotl-PM plugin release.

The manifest credits DragonPlayzMC as author and Ghast Noob for editing and Vietnamese localization. Those credits are preserved. The repository has no LICENSE file or documented grant to redistribute modified builds. No Axolotl-PM 5 port, PHAR, CI build or stable release is provided here.

The existing command implementation also calls `setAllowFlight(true)` when turning its tracked fly state off. Its displayed off message therefore does not prove that flight is disabled. This behavior has not been changed in this archival documentation update.

See [plugin.yml](plugin.yml) and [the source](src/Fly/Main.php) for the historical implementation. Redistribution or a modern port needs a verified license or permission from the relevant rightsholders first.
