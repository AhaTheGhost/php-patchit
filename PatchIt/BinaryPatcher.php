<?php

namespace PatchIt {

	/**
	 * Class BinaryPatcher
	 *
	 * A class for patching binary data.
	 *
	 * @package PatchIt
	 * @author Ahmed F. Shark<ahmad360pro@gmail.com>
	 * @version 1.1.0.0
	 * @link https://github.com/AhaTheGhost/php-patchit/
	 */

	class BinaryPatcher {

		// The array to be patched.
		private array $byteArray;
		private string $lastLog;
		private $unpackFormat;

		// Constant representing the library name.
		private const LIB_NAME = "PatchIt";

		// Constructor for initializing the BinaryPatcher.
		public function __construct($filePath, $unpackType) {

			// Check if the input byte array is null and throw an exception if it is.
			if ($filePath === null)
				throw new \InvalidArgumentException(\PatchIt\BinaryPatcher::LIB_NAME
					. ": Input byte array cannot be null.");

			$this->unpackFormat = $unpackType;

			$handle = fopen($filePath, "r+b") or die("Unable to read file!");
			$fsize = filesize($filePath);
			$contents = fread($handle, $fsize);

			// Unpack the binary data according to the specified format.
			$this->byteArray = unpack($this->unpackFormat, $contents);

			// Convert the unpacked data into an array of two-character strings in uppercase (Hex).
			$this->byteArray = str_split(strtoupper($this->byteArray[1]), 2);

			fclose($handle);

			$this->lastLog = "Initialized";
		}

		// Method to apply binary patches to the byte array.
		public function patchData($patchPairs) {
			$this->isPatchPairsSizeValid($patchPairs);

			try {
				$this->applyPatches($patchPairs);
				$this->lastLog = "Success";
			} catch (\Exception $e) {
				$this->lastLog = "Error: " . $e->getMessage();
			}
		}

		// Method to apply the patches to the byte array.
		private function applyPatches($patchPairs) {
			try {
				for ($i = 0; $i < count($patchPairs); $i += 2) {
					$findBinary = $patchPairs[$i];
					$replaceBinary = $patchPairs[$i + 1];

					// Iterate through the patchPairs and apply each patch.
					for ($j = 0; $j <= count($this->byteArray) - count($findBinary); $j++) {
						if ($this->isSequenceValid($this->byteArray, $j, $findBinary)) {
							for ($k = 0; $k < count($findBinary); $k++)
								$this->byteArray[$j + $k] = $replaceBinary[$k];
							break;
						}
					}
				}
			} catch (\Exception $e) {
				$this->lastLog = "Error: " . $e->getMessage();
			}
		}

		// Method to check if a sequence is valid at a given position in the byte array.
		private function isSequenceValid($byteArray, $startIndex, $sequenceToFind) {
			if ($startIndex + count($sequenceToFind) > count($byteArray))
				return false;

			// Check if the 'findBinary' sequence can fit within the 'byteArray' starting from 'startIndex'.
			for ($i = 0; $i < count($sequenceToFind); $i++)
				if ($sequenceToFind[$i] != $byteArray[$startIndex + $i])
					return false;

			return true;
		}

		// Method to check if the size of patchPairs is valid (even number of elements).
		public function isPatchPairsSizeValid($patchPairs) {
			if (count($patchPairs) % 2 !== 0)
				throw new \InvalidArgumentException(\PatchIt\BinaryPatcher::LIB_NAME
					. ": The patchPairs must contain an equal number of 'find' and 'replace' patterns,"
					. " size of array must be even.\nSize of array: " . count($patchPairs));

			return true;
		}

		// Returns the patched byte array.
		public function getPatchedBinary() {
			$data = '';
			foreach ($this->byteArray as $i => $v)
				$data .= pack($this->unpackFormat, $this->byteArray[$i]);

			return $data;
		}

		// Returns the last log message.
		public function getLastLog() {
			return $this->lastLog;
		}
	}
}
