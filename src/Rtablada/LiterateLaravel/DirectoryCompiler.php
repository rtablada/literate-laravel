<?php namespace Rtablada\LiterateLaravel;

use Illuminate\Filesystem\Filesystem;
use Rtablada\LiteratePhp\Parser;


class DirectoryCompiler
{
	public function __construct(Filesystem $file, Parser $parser)
	{
		$this->file = $file;
		$this->parser = $parser;
	}

	public function compile($inDir, $outDir)
	{
		$files = $this->getFiles($inDir);

		foreach ($files as $file) {
			if (strpos($file, '.php.md')) {
				$inPath = $file->__toString();
				$outPath = $this->getOutPath($outDir, $file);

				$literateSrc = $this->file->get($inPath);
				$compiledSrc = $this->parser->parse($literateSrc);

				$this->writeFile($outPath, $compiledSrc);
			} elseif (strpos($file, '.php')) {
				$inPath = $file->__toString();
				$outPath = $this->getOutPath($outDir, $file);
				$source = $this->file->get($inPath);

				$this->writeFile($outPath, $source);
			}
		}
	}

	protected function getFiles($dir)
	{
		return $this->file->allFiles($dir);
	}

	protected function getOutPath($outDir, $file)
	{
		$relativePath = $file->getRelativePath();
		$basename = $file->getBasename('.md');

		return "{$outDir}/{$relativePath}/{$basename}";
	}

	protected function writeFile($path, $contents)
	{
		$this->checkDirectory($path);

		$this->file->put($path, $contents);
	}

	protected function checkDirectory($path)
	{
		$outFile = new \SplFileInfo($path);
		$directory = $outFile->getPath();

		if (!$this->file->exists($directory)) {
			$this->file->makeDirectory($directory, 0777, true);
		}
	}
}
