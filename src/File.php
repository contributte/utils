<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Contributte\Utils\Exception\Runtime\FileNotFoundException;
use Contributte\Utils\Http\FileResponse;
use Nette\Utils\FileSystem as NetteFileSystem;
use Nette\Utils\Image;

class File
{

	private string $path;

	private string|null $title;

	public function __construct(string $path, string|null $title = null)
	{
		$this->path = FileSystem::pathalize($path);
		$this->title = $title;
	}

	public function getName(): string
	{
		return basename($this->path);
	}

	/**
	 * @throws FileNotFoundException
	 */
	public function getSize(): int
	{
		$this->assertExists();

		$size = filesize($this->path);

		return $size !== false ? $size : 0;
	}

	public function getTitle(): string|null
	{
		return $this->title;
	}

	public function getPath(): string
	{
		return $this->path;
	}

	public function exists(): bool
	{
		return file_exists($this->path) && is_file($this->path);
	}

	/**
	 * @throws FileNotFoundException
	 */
	public function move(string $destination, bool $overwrite = true): static
	{
		$this->assertExists();

		$destination = FileSystem::pathalize($destination);
		NetteFileSystem::rename($this->path, $destination, $overwrite);
		$this->path = $destination;

		return $this;
	}

	/**
	 * @throws FileNotFoundException
	 */
	public function toImage(): Image
	{
		$this->assertExists();

		return Image::fromFile($this->path);
	}

	/**
	 * @throws FileNotFoundException
	 */
	public function toResponse(string|null $name = null, string|null $contentType = null, bool $forceDownload = true): FileResponse
	{
		$this->assertExists();

		return new FileResponse(
			$this->path,
			$name ?? $this->title ?? $this->getName(),
			$contentType,
			$forceDownload
		);
	}

	/**
	 * @throws FileNotFoundException
	 */
	private function assertExists(): void
	{
		if (!$this->exists()) {
			throw new FileNotFoundException($this->path);
		}
	}

}
