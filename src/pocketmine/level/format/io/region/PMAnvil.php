<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\level\format\io\region;

use pocketmine\level\format\SubChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntArrayTag;

/**
 * This format is exactly the same as the PC Anvil format, with the only difference being that the stored data order
 * is XZY instead of YZX for more performance loading and saving worlds.
 */
class PMAnvil extends Anvil{

	public const REGION_FILE_EXTENSION = "mcapm";

	protected function serializeSubChunk(SubChunk $subChunk) : CompoundTag{
		return new CompoundTag("", [
			new IntArrayTag("Blocks",     $subChunk->getBlockIdArray()),
			new IntArrayTag("Data",       $subChunk->getBlockDataArray()),
			new IntArrayTag("SkyLight",   $subChunk->getBlockSkyLightArray()),
			new IntArrayTag("BlockLight", $subChunk->getBlockLightArray())
		]);
	}

	protected function deserializeSubChunk(CompoundTag $subChunk) : SubChunk{
		return new SubChunk(
			$subChunk->getIntArray("Blocks"),
			$subChunk->getIntArray("Data"),
			$subChunk->getIntArray("SkyLight"),
			$subChunk->getIntArray("BlockLight")
		);
	}

	public static function getProviderName() : string{
		return "pmanvil";
	}

	public static function getPcWorldFormatVersion() : int{
		return -1; //Not a PC format, only PocketMine-MP
	}
}
