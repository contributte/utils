<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\Utils\FileSystem as NetteFileSystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class FileSystem extends NetteFileSystem
{

	/**
	 * Normalize path
	 */
	public static function pathalize(string $path): string
	{
		return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
	}

	/**
	 * Get file extension(.xxx)
	 */
	public static function extension(string $str): string
	{
		$pos = strripos($str, '.');
		if ($pos === false) {
			return pathinfo($str, PATHINFO_EXTENSION);
		}

		return substr($str, $pos);
	}

	/**
	 * Purges directory
	 */
	public static function purge(string $dir): void
	{
		if (!is_dir($dir)) {
			mkdir($dir);
		}

		/** @var SplFileInfo $entry */
		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $entry) {
			if ($entry->isDir()) {
				rmdir($entry->getRealPath());
			} else {
				unlink($entry->getRealPath());
			}
		}
	}

}
