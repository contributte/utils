<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Contributte\Utils\Exception\LogicalException;

final class ServerTiming
{

	/** @var array<string, array{start: float, description: string|null}> */
	private array $runningTimers = [];

	/** @var array<array{start: float, end: float, description: string|null}> */
	private array $endedTimers = [];

	public function start(string $name, string|null $description = null): void
	{
		$this->runningTimers[$name] = [
			'start' => microtime(true),
			'description' => $description,
		];
	}

	public function end(string $name): void
	{
		if (!isset($this->runningTimers[$name])) {
			throw new LogicalException(sprintf('Timer "%s" is not running', $name));
		}

		// Update end time
		$timer = $this->runningTimers[$name];
		$timer['end'] = microtime(true);

		// Copy to ended
		$this->endedTimers[$name] = $timer;

		// Drop from running
		unset($this->runningTimers[$name]);
	}

	public function format(): string
	{
		$metrics = [];

		foreach ($this->endedTimers as $name => $timer) {
			$timeTaken = ($timer['end'] - $timer['start']) * 1000;
			$output = sprintf('%s;dur=%f', $name, $timeTaken);

			if ($timer['description'] !== null) {
				$output .= sprintf(';desc="%s"', addslashes($timer['description']));
			}

			$metrics[] = $output;
		}

		return implode(', ,', $metrics);
	}

}
