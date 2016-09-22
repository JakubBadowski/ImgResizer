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
		// Validation
		$this->checkInputDir();
		$this->checkOutputDir();

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

	private function setFilesList()
	{
		// $this->filesList = glob($this->inputDir . "*.png");
		$this->filesList = glob($this->inputDir . "*.{jpg,png}", GLOB_BRACE);
	}

	private function mainLoop()
	{
		foreach ($this->filesList as $input) {

			$output = $this->outputDir . basename($input);
			$this->resizeImg($input, $output);
		}
	}

	private function resizeImg($inputImg, $outputImg)
	{
		// Find file extension
		$ext = pathinfo($inputImg, PATHINFO_EXTENSION);

		list($width, $height) = getimagesize($inputImg);

		$newwidth = self::WIDTH;
		$newheight = $this->getProportionalHeight($width, $height);

		print_r(basename($inputImg) . ": przed " . $this->getFileSize($inputImg) . " (" . $width . "x" . $height . ") ");

		// Load
		$thumb = imagecreatetruecolor($newwidth, $newheight);

		if ($ext === "jpg") {
			$source  = imagecreatefromjpeg($inputImg);
		} else if ($ext === "png") {
			$source = imagecreatefrompng($inputImg);
		} else {
			echo "Nieprawidłowy format!" . PHP_EOL;
			exit();
		}

		// Resize
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		// Output if use in fly
		// imagepng($thumb);
		
		// Save
		if ($ext === "jpg") {
			imagejpeg($thumb, $outputImg);
		} else if ($ext === "png") {
			imagepng($thumb, $outputImg);
		}

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

	private function checkInputDir()
	{
		if (!is_dir($this->inputDir)) {
			echo "Input dir is not exist!" . PHP_EOL; 
			exit();
		}
	}

	private function checkOutputDir()
	{
		if (!is_dir($this->outputDir)) {
			echo "Output dir is not exist!" . PHP_EOL;
			exit();
		}
	}
}