<?php
/**
 * @author Ahmed F. Shark <ahmad360pro@gmail.com>
 * @version 1.0.4
 * @link https://github.com/AhaTheGhost/php-patchit/
 */

  class Patch {

    private $FindBinary;
    private $ReplaceBinary;
    private $ByteArray;
    private $UnpackType;

    public function __construct($file, $unpackType) {

      $this->UnpackType = $unpackType;

      $handle = fopen($file['tmp_name'], "r+b") or die("Unable to read file!");
      $fsize = filesize($file['tmp_name']);
      $contents = fread($handle, $fsize);
      $this->ByteArray = unpack($this->UnpackType, $contents);
      $this->ByteArray = str_split(strtoupper($this->ByteArray[1]), 2);
      fclose($handle);

    }

    public function patchFile($array) {

      if($this->isArraySizeVaild($array))
        $this->buffer($array);

    }

    private function isArraySizeVaild($array) {

      if(sizeof($array) % 2 != 0) {
        echo 'The array must contain as many "find" sub arraies as "replace" sub arraies. Size of Find and Replace Jagged Array: ' . sizeof($array);
        return false;
      }

      return true;

    }

    private function buffer($array) {

      for ($i = 0; $i < sizeof($array); $i += 2) {

        $this->FindBinary = $array[$i];
        $this->ReplaceBinary = $array[$i + 1];

        for ($buffIndex = 0; $buffIndex <= sizeof($this->ByteArray) - 1; $buffIndex++){

          if (!$this->isSequenceVaild($this->ByteArray, $buffIndex))
            continue;

          else {

            for ($R = 0; $R <= sizeof($this->FindBinary) - 1; $R++)
              $this->ByteArray[$buffIndex + $R] = $this->ReplaceBinary[$R];

            break;

          }

        }

      }

    }

    private function isSequenceVaild($seq, $pos) {

        if ($pos + sizeof($this->FindBinary) > sizeof($seq))
            return false;

        for ($i = 0; $i <= sizeof($this->FindBinary) - 1; $i++) {
            if ($this->FindBinary[$i] != $seq[$pos + $i])
                return false;
        }

        return true;
    }

    public function writePatchedData() {

      $data = '';

      foreach ($this->ByteArray as $i => $v)
        $data .= pack($this->UnpackType, $this->ByteArray[$i]);

      return $data;

    }

  }

?>
