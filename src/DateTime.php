<?php declare(strict_types = 1);

namespace Contributte\Utils;

use DateTimeInterface;
use DateTimeZone;
use Nette\Utils\DateTime as NetteDateTime;

/**
 * @phpstan-consistent-constructor
 */
class DateTime extends NetteDateTime
{

	public function __construct(string $time = 'now', ?DateTimeZone $timezone = null)
	{
		parent::__construct($time, $timezone);
	}

	public static function from(string|int|DateTimeInterface|null $time): static
	{
		return parent::from($time);
	}

	public static function createBy(?int $year = null, ?int $month = null, ?int $day = null, ?int $hour = null, ?int $minute = null, ?int $second = null): static
	{
		return self::create([
			'year' => $year,
			'month' => $month,
			'day' => $day,
			'hour' => $hour,
			'minute' => $minute,
			'second' => $second,
		]);
	}

	/**
	 * @param string[]|int[]|null[] $args
	 */
	public static function create(array $args): static
	{
		$date = new static();

		if (!isset($args['year'])) {
			$args['year'] = date('Y');
		}

		if (!isset($args['month'])) {
			$args['month'] = date('m');
		}

		if (!isset($args['day'])) {
			$args['day'] = date('d');
		}

		if (!isset($args['hour'])) {
			$args['hour'] = 0;
		}

		if (!isset($args['minute'])) {
			$args['minute'] = 0;
		}

		if (!isset($args['second'])) {
			$args['second'] = 0;
		}

		$date->setDate((int) $args['year'], (int) $args['month'], (int) $args['day']);
		$date->setTime((int) $args['hour'], (int) $args['minute'], (int) $args['second']);

		return $date;
	}

	public function modifyClone(string $modify = ''): static
	{
		return parent::modifyClone($modify);
	}

	/**
	 * Set time to current time
	 */
	public function setCurrentTime(): static
	{
		return $this->modifyClone()->setTime((int) date('H'), (int) date('i'), (int) date('s'));
	}

	/**
	 * Reset current time (00:00:00)
	 */
	public function resetTime(): static
	{
		return $this->modifyClone()->setTime(0, 0, 0);
	}

	/**
	 * Reset current time (00:00:00)
	 */
	public function setZeroTime(): static
	{
		return $this->resetTime();
	}

	/**
	 * Set time to midnight (23:59:59)
	 */
	public function setMidnight(): static
	{
		return $this->modifyClone()->setTime(23, 59, 59);
	}

	/**
	 * Set date to today
	 */
	public function setToday(): static
	{
		return $this->modifyClone()->setDate((int) date('Y'), (int) date('m'), (int) date('d'));
	}

	public function getFirstDayOfWeek(): static
	{
		return $this->modifyClone('this week')
			->setZeroTime();
	}

	public function getLastDayOfWeek(): static
	{
		return $this->modifyClone('this week +6 days')
			->setMidnight();
	}

	public function getFirstDayOfMonth(): static
	{
		return $this->modifyClone('first day of this month')
			->setZeroTime();
	}

	public function getLastDayOfMonth(): static
	{
		return $this->modifyClone('last day of this month')
			->setMidnight();
	}

	public function getFirstDayOfYear(): static
	{
		return $this->modifyClone(sprintf('first day of January %s', $this->format('Y')))
			->setZeroTime();
	}

	public function getLastDayOfYear(): static
	{
		return $this->modifyClone(sprintf('last day of December %s', $this->format('Y')))
			->setMidnight();
	}

}
