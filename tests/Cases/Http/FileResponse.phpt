<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Exception\Runtime\FileNotFoundException;
use Contributte\Utils\Http\FileResponse;
use Nette\Utils\FileSystem;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

$tempDir = __DIR__ . '/../../temp/file-response-test';
FileSystem::createDir($tempDir);

// FileResponse::__construct
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/test.txt';
	FileSystem::write($filePath, 'content');

	$response = new FileResponse($filePath);
	Assert::same($filePath, $response->getFile());
	Assert::same('test.txt', $response->getName());
});

// FileResponse::__construct with custom name
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/test2.txt';
	FileSystem::write($filePath, 'content');

	$response = new FileResponse($filePath, 'custom.txt');
	Assert::same('custom.txt', $response->getName());
});

// FileResponse::__construct throws on non-existing file
Toolkit::test(function () use ($tempDir): void {
	Assert::exception(function () use ($tempDir): void {
		new FileResponse($tempDir . '/non-existing.txt');
	}, FileNotFoundException::class);
});

// FileResponse::getContentType
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/test3.txt';
	FileSystem::write($filePath, 'text content');

	$response = new FileResponse($filePath);
	$contentType = $response->getContentType();
	Assert::contains('text', $contentType);
});

// FileResponse::getContentType with custom type
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/test4.txt';
	FileSystem::write($filePath, 'content');

	$response = new FileResponse($filePath, null, 'application/custom');
	Assert::same('application/custom', $response->getContentType());
});

// FileResponse::isForceDownload
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/test5.txt';
	FileSystem::write($filePath, 'content');

	$responseForce = new FileResponse($filePath, null, null, true);
	Assert::true($responseForce->isForceDownload());

	$responseInline = new FileResponse($filePath, null, null, false);
	Assert::false($responseInline->isForceDownload());
});

FileSystem::delete($tempDir);
