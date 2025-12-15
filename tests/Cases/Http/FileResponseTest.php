<?php declare(strict_types = 1);

namespace Tests\Cases\Http;

use Contributte\Utils\Exception\Runtime\FileNotFoundException;
use Contributte\Utils\Http\FileResponse;
use Nette\Utils\FileSystem;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';

class FileResponseTest extends TestCase
{

	private string $tempDir;

	protected function setUp(): void
	{
		$this->tempDir = __DIR__ . '/../../temp/file-response-test';
		FileSystem::createDir($this->tempDir);
	}

	protected function tearDown(): void
	{
		FileSystem::delete($this->tempDir);
	}

	public function testConstructor(): void
	{
		$filePath = $this->tempDir . '/test.txt';
		FileSystem::write($filePath, 'content');

		$response = new FileResponse($filePath);
		Assert::same($filePath, $response->getFile());
		Assert::same('test.txt', $response->getName());
	}

	public function testConstructorWithCustomName(): void
	{
		$filePath = $this->tempDir . '/test.txt';
		FileSystem::write($filePath, 'content');

		$response = new FileResponse($filePath, 'custom.txt');
		Assert::same('custom.txt', $response->getName());
	}

	public function testConstructorThrowsOnNonExistingFile(): void
	{
		Assert::exception(function (): void {
			new FileResponse($this->tempDir . '/non-existing.txt');
		}, FileNotFoundException::class);
	}

	public function testGetContentType(): void
	{
		$filePath = $this->tempDir . '/test.txt';
		FileSystem::write($filePath, 'text content');

		$response = new FileResponse($filePath);
		$contentType = $response->getContentType();
		Assert::contains('text', $contentType);
	}

	public function testGetContentTypeWithCustomType(): void
	{
		$filePath = $this->tempDir . '/test.txt';
		FileSystem::write($filePath, 'content');

		$response = new FileResponse($filePath, null, 'application/custom');
		Assert::same('application/custom', $response->getContentType());
	}

	public function testIsForceDownload(): void
	{
		$filePath = $this->tempDir . '/test.txt';
		FileSystem::write($filePath, 'content');

		$responseForce = new FileResponse($filePath, null, null, true);
		Assert::true($responseForce->isForceDownload());

		$responseInline = new FileResponse($filePath, null, null, false);
		Assert::false($responseInline->isForceDownload());
	}

}

(new FileResponseTest())->run();
