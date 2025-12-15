<?php declare(strict_types = 1);

namespace Tests\Cases;

use Contributte\Utils\Exception\Runtime\FileNotFoundException;
use Contributte\Utils\File;
use Contributte\Utils\Http\FileResponse;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class FileTest extends TestCase
{

	private string $tempDir;

	protected function setUp(): void
	{
		$this->tempDir = __DIR__ . '/../temp/file-test';
		FileSystem::createDir($this->tempDir);
	}

	protected function tearDown(): void
	{
		FileSystem::delete($this->tempDir);
	}

	public function testGetName(): void
	{
		$file = new File('/path/to/test.txt');
		Assert::same('test.txt', $file->getName());

		$file2 = new File('/another/path/document.pdf');
		Assert::same('document.pdf', $file2->getName());
	}

	public function testGetTitle(): void
	{
		$file = new File('/path/to/test.txt', 'My Document');
		Assert::same('My Document', $file->getTitle());

		$fileWithoutTitle = new File('/path/to/test.txt');
		Assert::null($fileWithoutTitle->getTitle());
	}

	public function testGetPath(): void
	{
		$path = '/path/to/test.txt';
		$file = new File($path);
		Assert::same(str_replace('/', DIRECTORY_SEPARATOR, $path), $file->getPath());
	}

	public function testExistsWithExistingFile(): void
	{
		$filePath = $this->tempDir . '/existing.txt';
		FileSystem::write($filePath, 'test content');

		$file = new File($filePath);
		Assert::true($file->exists());
		Assert::true($file->exist()); // deprecated alias
	}

	public function testExistsWithNonExistingFile(): void
	{
		$file = new File($this->tempDir . '/non-existing.txt');
		Assert::false($file->exists());
		Assert::false($file->exist()); // deprecated alias
	}

	public function testGetSize(): void
	{
		$content = 'Hello, World!';
		$filePath = $this->tempDir . '/size-test.txt';
		FileSystem::write($filePath, $content);

		$file = new File($filePath);
		Assert::same(strlen($content), $file->getSize());
	}

	public function testGetSizeThrowsOnNonExistingFile(): void
	{
		$file = new File($this->tempDir . '/non-existing.txt');

		Assert::exception(function () use ($file): void {
			$file->getSize();
		}, FileNotFoundException::class);
	}

	public function testMove(): void
	{
		$originalPath = $this->tempDir . '/original.txt';
		$newPath = $this->tempDir . '/moved.txt';
		FileSystem::write($originalPath, 'test content');

		$file = new File($originalPath);
		$result = $file->move($newPath);

		Assert::same($file, $result); // fluent interface
		Assert::same(str_replace('/', DIRECTORY_SEPARATOR, $newPath), $file->getPath());
		Assert::true($file->exists());
		Assert::false(file_exists($originalPath));
	}

	public function testMoveThrowsOnNonExistingFile(): void
	{
		$file = new File($this->tempDir . '/non-existing.txt');

		Assert::exception(function () use ($file): void {
			$file->move($this->tempDir . '/destination.txt');
		}, FileNotFoundException::class);
	}

	public function testToImage(): void
	{
		// Create a simple PNG image
		$imagePath = $this->tempDir . '/test.png';
		$image = Image::fromBlank(100, 100, Image::rgb(255, 0, 0));
		$image->save($imagePath);

		$file = new File($imagePath);
		$loadedImage = $file->toImage();

		Assert::type(Image::class, $loadedImage);
		Assert::same(100, $loadedImage->getWidth());
		Assert::same(100, $loadedImage->getHeight());
	}

	public function testToImageThrowsOnNonExistingFile(): void
	{
		$file = new File($this->tempDir . '/non-existing.png');

		Assert::exception(function () use ($file): void {
			$file->toImage();
		}, FileNotFoundException::class);
	}

	public function testToResponse(): void
	{
		$filePath = $this->tempDir . '/download.txt';
		FileSystem::write($filePath, 'downloadable content');

		$file = new File($filePath, 'My Download');
		$response = $file->toResponse();

		Assert::type(FileResponse::class, $response);
	}

	public function testToResponseWithCustomName(): void
	{
		$filePath = $this->tempDir . '/download.txt';
		FileSystem::write($filePath, 'downloadable content');

		$file = new File($filePath);
		$response = $file->toResponse('custom-name.txt');

		Assert::type(FileResponse::class, $response);
	}

	public function testToResponseThrowsOnNonExistingFile(): void
	{
		$file = new File($this->tempDir . '/non-existing.txt');

		Assert::exception(function () use ($file): void {
			$file->toResponse();
		}, FileNotFoundException::class);
	}

	public function testPathNormalization(): void
	{
		$file = new File('/path/to\\mixed/separators.txt');
		$path = $file->getPath();

		// Should use consistent separator
		if (DIRECTORY_SEPARATOR === '\\') {
			Assert::same('\\path\\to\\mixed\\separators.txt', $path);
		} else {
			Assert::same('/path/to/mixed/separators.txt', $path);
		}
	}

}

(new FileTest())->run();
