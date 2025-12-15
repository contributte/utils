<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\Exception\Runtime\FileNotFoundException;
use Contributte\Utils\File;
use Contributte\Utils\Http\FileResponse;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

$tempDir = __DIR__ . '/../temp/file-test';
FileSystem::createDir($tempDir);

// File::getName
Toolkit::test(function (): void {
	$file = new File('/path/to/test.txt');
	Assert::same('test.txt', $file->getName());

	$file2 = new File('/another/path/document.pdf');
	Assert::same('document.pdf', $file2->getName());
});

// File::getTitle
Toolkit::test(function (): void {
	$file = new File('/path/to/test.txt', 'My Document');
	Assert::same('My Document', $file->getTitle());

	$fileWithoutTitle = new File('/path/to/test.txt');
	Assert::null($fileWithoutTitle->getTitle());
});

// File::getPath
Toolkit::test(function (): void {
	$path = '/path/to/test.txt';
	$file = new File($path);
	Assert::same(str_replace('/', DIRECTORY_SEPARATOR, $path), $file->getPath());
});

// File::exists
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/existing.txt';
	FileSystem::write($filePath, 'test content');

	$file = new File($filePath);
	Assert::true($file->exists());

	$nonExisting = new File($tempDir . '/non-existing.txt');
	Assert::false($nonExisting->exists());
});

// File::getSize
Toolkit::test(function () use ($tempDir): void {
	$content = 'Hello, World!';
	$filePath = $tempDir . '/size-test.txt';
	FileSystem::write($filePath, $content);

	$file = new File($filePath);
	Assert::same(strlen($content), $file->getSize());
});

// File::getSize throws on non-existing file
Toolkit::test(function () use ($tempDir): void {
	$file = new File($tempDir . '/non-existing.txt');

	Assert::exception(function () use ($file): void {
		$file->getSize();
	}, FileNotFoundException::class);
});

// File::move
Toolkit::test(function () use ($tempDir): void {
	$originalPath = $tempDir . '/original.txt';
	$newPath = $tempDir . '/moved.txt';
	FileSystem::write($originalPath, 'test content');

	$file = new File($originalPath);
	$result = $file->move($newPath);

	Assert::same($file, $result);
	Assert::same(str_replace('/', DIRECTORY_SEPARATOR, $newPath), $file->getPath());
	Assert::true($file->exists());
	Assert::false(file_exists($originalPath));
});

// File::move throws on non-existing file
Toolkit::test(function () use ($tempDir): void {
	$file = new File($tempDir . '/non-existing.txt');

	Assert::exception(function () use ($file, $tempDir): void {
		$file->move($tempDir . '/destination.txt');
	}, FileNotFoundException::class);
});

// File::toImage
Toolkit::test(function () use ($tempDir): void {
	$imagePath = $tempDir . '/test.png';
	$image = Image::fromBlank(100, 100, Image::rgb(255, 0, 0));
	$image->save($imagePath);

	$file = new File($imagePath);
	$loadedImage = $file->toImage();

	Assert::type(Image::class, $loadedImage);
	Assert::same(100, $loadedImage->getWidth());
	Assert::same(100, $loadedImage->getHeight());
});

// File::toImage throws on non-existing file
Toolkit::test(function () use ($tempDir): void {
	$file = new File($tempDir . '/non-existing.png');

	Assert::exception(function () use ($file): void {
		$file->toImage();
	}, FileNotFoundException::class);
});

// File::toResponse
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/download.txt';
	FileSystem::write($filePath, 'downloadable content');

	$file = new File($filePath, 'My Download');
	$response = $file->toResponse();

	Assert::type(FileResponse::class, $response);
});

// File::toResponse with custom name
Toolkit::test(function () use ($tempDir): void {
	$filePath = $tempDir . '/download2.txt';
	FileSystem::write($filePath, 'downloadable content');

	$file = new File($filePath);
	$response = $file->toResponse('custom-name.txt');

	Assert::type(FileResponse::class, $response);
});

// File::toResponse throws on non-existing file
Toolkit::test(function () use ($tempDir): void {
	$file = new File($tempDir . '/non-existing.txt');

	Assert::exception(function () use ($file): void {
		$file->toResponse();
	}, FileNotFoundException::class);
});

// File path normalization
Toolkit::test(function (): void {
	$file = new File('/path/to\\mixed/separators.txt');
	$path = $file->getPath();

	if (DIRECTORY_SEPARATOR === '\\') {
		Assert::same('\\path\\to\\mixed\\separators.txt', $path);
	} else {
		Assert::same('/path/to/mixed/separators.txt', $path);
	}
});

FileSystem::delete($tempDir);
