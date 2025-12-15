<?php declare(strict_types = 1);

namespace Contributte\Utils\Http;

use Contributte\Utils\Exception\Runtime\FileNotFoundException;

class FileResponse
{

	private string $file;

	private string $name;

	private string|null $contentType;

	private bool $forceDownload;

	/**
	 * @throws FileNotFoundException
	 */
	public function __construct(
		string $file,
		string|null $name = null,
		string|null $contentType = null,
		bool $forceDownload = true
	)
	{
		if (!file_exists($file) || !is_file($file)) {
			throw new FileNotFoundException($file);
		}

		$this->file = $file;
		$this->name = $name ?? basename($file);
		$this->contentType = $contentType;
		$this->forceDownload = $forceDownload;
	}

	public function getFile(): string
	{
		return $this->file;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getContentType(): string
	{
		if ($this->contentType !== null) {
			return $this->contentType;
		}

		$mimeType = mime_content_type($this->file);

		return $mimeType !== false ? $mimeType : 'application/octet-stream';
	}

	public function isForceDownload(): bool
	{
		return $this->forceDownload;
	}

	/**
	 * Send file to output
	 */
	public function send(): void
	{
		$name = $this->name;
		$contentType = $this->getContentType();

		header('Content-Type: ' . $contentType);
		header('Content-Disposition: ' . ($this->forceDownload ? 'attachment' : 'inline') . '; filename="' . $name . '"; filename*=utf-8\'\'' . rawurlencode($name));
		header('Content-Length: ' . filesize($this->file));

		readfile($this->file);
	}

}
