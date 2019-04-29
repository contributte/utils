<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\InvalidArgumentException;
use Nette\IOException;
use Nette\StaticClass;
use Nette\Utils\FileSystem as NetteFileSystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class FileSystem
{

	use StaticClass;

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
				rmdir((string) $entry->getRealPath());
			} else {
				unlink((string) $entry->getRealPath());
			}
		}
	}

	/**
	 * Creates a directory.
	 *
	 * @throws IOException
	 */
	public static function createDir(string $dir, int $mode = 0777): void
	{
		NetteFileSystem::createDir($dir, $mode);
	}

	/**
	 * Copies a file or directory.
	 *
	 * @throws IOException
	 */
	public static function copy(string $source, string $dest, bool $overwrite = true): void
	{
		NetteFileSystem::copy($source, $dest, $overwrite);
	}

	/**
	 * Deletes a file or directory.
	 *
	 * @throws IOException
	 */
	public static function delete(string $path): void
	{
		NetteFileSystem::delete($path);
	}

	/**
	 * Renames a file or directory.
	 *
	 * @throws IOException
	 * @throws InvalidArgumentException if the target file or directory already exist
	 */
	public static function rename(string $name, string $newName, bool $overwrite = true): void
	{
		NetteFileSystem::rename($name, $newName, $overwrite);
	}

	/**
	 * Reads file content.
	 *
	 * @throws IOException
	 */
	public static function read(string $file): string
	{
		return NetteFileSystem::read($file);
	}

	/**
	 * Writes a string to a file.
	 *
	 * @throws IOException
	 */
	public static function write(string $file, string $content, int $mode = 0666): void
	{
		NetteFileSystem::write($file, $content, $mode);
	}

	/**
	 * Is path absolute?
	 */
	public static function isAbsolute(string $path): bool
	{
		return NetteFileSystem::isAbsolute($path);
	}

}
