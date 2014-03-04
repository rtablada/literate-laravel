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

				$this->file->put($outPath, $compiledSrc);
			} elseif (strpos($file, '.php')) {
				$inPath = $file->__toString();
				$outPath = $this->getOutPath($outDir, $file);

				$this->file->put($outPath, $compiledSrc);
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
}
