<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\FileSystem as UtilsFileSystem;
use Nette\Utils\FileSystem as NetteFileSystem;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

$tempDir = __DIR__ . '/../temp/filesystem-test';
NetteFileSystem::createDir($tempDir);

Toolkit::test(function (): void {
	Assert::same(
		str_replace(['/', '\\'], DIRECTORY_SEPARATOR, '/foo\\bar/baz'),
		UtilsFileSystem::pathalize('/foo\\bar/baz')
	);
});

Toolkit::test(function (): void {
	Assert::same('.gz', UtilsFileSystem::extension('archive.tar.gz'));
	Assert::same('', UtilsFileSystem::extension('README'));
});

Toolkit::test(function () use ($tempDir): void {
	$purgedDir = $tempDir . '/purged';

	UtilsFileSystem::purge($purgedDir);
	Assert::true(is_dir($purgedDir));

	NetteFileSystem::write($purgedDir . '/file.txt', 'content');
	NetteFileSystem::createDir($purgedDir . '/nested');
	NetteFileSystem::write($purgedDir . '/nested/child.txt', 'child');

	UtilsFileSystem::purge($purgedDir);

	$entries = scandir($purgedDir);
	Assert::same([], array_values(array_diff($entries !== false ? $entries : [], ['.', '..'])));
});

Toolkit::test(function () use ($tempDir): void {
	$ioDir = $tempDir . '/io';
	UtilsFileSystem::createDir($ioDir);

	$sourceFile = $ioDir . '/source.txt';
	UtilsFileSystem::write($sourceFile, 'Hello');
	Assert::same('Hello', UtilsFileSystem::read($sourceFile));

	$copiedFile = $ioDir . '/copy.txt';
	UtilsFileSystem::copy($sourceFile, $copiedFile);
	Assert::same('Hello', UtilsFileSystem::read($copiedFile));

	$renamedFile = $ioDir . '/renamed.txt';
	UtilsFileSystem::rename($copiedFile, $renamedFile);
	Assert::false(file_exists($copiedFile));
	Assert::true(file_exists($renamedFile));

	UtilsFileSystem::delete($renamedFile);
	Assert::false(file_exists($renamedFile));

	Assert::true(UtilsFileSystem::isAbsolute($sourceFile));
	Assert::false(UtilsFileSystem::isAbsolute('relative/path.txt'));
});

NetteFileSystem::delete($tempDir);
