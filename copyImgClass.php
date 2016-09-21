<?php

/** 
Klasa kopiuje obrazki z podanego katalogu do innego i zmienia ich rozdzielczość
 
*/

class copyImgClass
{
	const WIDTH = 148; // Zadana szerokość obrazka [px]
	// const HEIGHT = 200;

	private $inputDir;
	private $outputDir;
	private $filesList;

	public function __construct()
	{
		echo "Jedziemy z tym koksem ..." . PHP_EOL;
	}

	public function goWork()
	{
		$this->setFilesList();
		$this->mainLoop();
	}

	public function setInputDir($dir)
	{
		// TODO: Check dir isset & have permission
		$this->inputDir = $dir;
	}

	public function setOutputDir($dir)
	{
		// TODO: Check dir isset & have permission
		$this->outputDir = $dir;
	}

	public function	copyImg()
	{

	}

	private function setFilesList()
	{
		// $files = scandir($this->inputDir);

		// glob("img/thumb/*.{jpg,png,gif}", GLOB_BRACE);
		$this->filesList = glob($this->inputDir . "*.png");

		// print_r($files);
	}

	private function mainLoop()
	{
		foreach ($this->filesList as $input) {

			$output = $this->outputDir . basename($input);
			$this->resizeImg($input, $output);
		}
	}

	// TODO: wywal
	private function filterFileList($fileList)
	{
		foreach ($fileList as &$file) {
			// if ($file)
		}
		unset($file);

		// $newList = [];

		return $fileList;
	}

	private function resizeImg($inputImg, $outputImg)
	{
		list($width, $height) = getimagesize($inputImg);

		$newwidth = self::WIDTH;
		$newheight = $this->getProportionalHeight($width, $height);

		print_r(basename($inputImg) . ": przed " . $this->getFileSize($inputImg) . " (" . $width . "x" . $height . ") ");
		// exit;

		// Load
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefrompng($inputImg);

		// Resize
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		// imagesavealpha($thumb, true);

		// Output if use in fly
		// imagepng($thumb);
		
		// Save
		imagepng($thumb, $outputImg);

		print_r("- po " . $this->getFileSize($outputImg) . " (" . $newwidth . "x" . $newheight . ")");
		echo PHP_EOL;
	}

	private function getProportionalHeight($width, $height)
	{
		$factor = self::WIDTH / $width;

		return round($factor * $height);
	}

	private function getFileSize($file)
	{
		$size = filesize($file);

		return $this->formatSizeUnits($size);
	}

	private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' kB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
}