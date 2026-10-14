# Fly

Fly provides the `/fly` command for players with the `fly.command` permission and blocks their attacks while the plugin-managed flight mode is active. Toggling the mode off, disconnecting, or disabling the plugin clears the in-memory mode and restores the player's previous flight permission state.

## Compatibility and validation

The manifest requires Axolotl-PM API 5.0.0. PHPStan max and reproducible PHAR builds are checked against pinned API 5.0.0 and 5.49.1 source revisions. Those test points do not claim compatibility with every API 5 release.

CI starts the generated PHAR on an isolated Axolotl-PM server and checks clean startup and shutdown. It does not verify flying or PvP behavior with a connected Bedrock client.

## Credits and distribution

The manifest retains DragonPlayzMC as author and Ghast Noob's editing/Vietnamese localization credit. The repository has no LICENSE file or verified grant to redistribute a modified build. No license was added and no stable release was published.

For questions about the NhanAZ ecosystem, use [NhanAZ Discord](https://discord.gg/j2X83ujT6c).
