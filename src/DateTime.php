<?php declare(strict_types = 1);

namespace Contributte\Utils;

use DateTimeInterface;
use DateTimeZone;
use Nette\Utils\DateTime as NetteDateTime;

class DateTime extends NetteDateTime
{

	public function __construct(string $time = 'now', ?DateTimeZone $timezone = null)
	{
		parent::__construct($time, $timezone);
	}

	/**
	 * @param string|int|DateTimeInterface $time
	 * @return static
	 */
	public static function from($time): self
	{
		return parent::from($time);
	}

	/**
	 * @return static
	 */
	public function modifyClone(string $modify = ''): self
	{
		return parent::modifyClone($modify);
	}

	/**
	 * Set time to current time
	 *
	 * @return static
	 */
	public function setCurrentTime(): self
	{
		return $this->modifyClone()->setTime((int) date('H'), (int) date('i'), (int) date('s'));
	}

	/**
	 * Reset current time (00:00:00)
	 *
	 * @return static
	 */
	public function resetTime(): self
	{
		return $this->modifyClone()->setTime(0, 0, 0);
	}

	/**
	 * Reset current time (00:00:00)
	 *
	 * @return static
	 */
	public function setZeroTime(): self
	{
		return $this->resetTime();
	}

	/**
	 * Set time to midnight (23:59:59)
	 *
	 * @return static
	 */
	public function setMidnight(): self
	{
		return $this->modifyClone()->setTime(23, 59, 59);
	}

	/**
	 * Set date to today
	 *
	 * @return static
	 */
	public function setToday(): self
	{
		return $this->modifyClone()->setDate((int) date('Y'), (int) date('m'), (int) date('d'));
	}

	/**
	 * @return static
	 */
	public static function createBy(?int $year = null, ?int $month = null, ?int $day = null, ?int $hour = null, ?int $minute = null, ?int $second = null): self
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
	 * @return static
	 */
	public static function create(array $args): self
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

	/**
	 * @return static
	 */
	public function getFirstDayOfWeek(): self
	{
		return $this->modifyClone('this week')
			->setZeroTime();
	}

	/**
	 * @return static
	 */
	public function getLastDayOfWeek(): self
	{
		return $this->modifyClone('this week +6 days')
			->setMidnight();
	}

	/**
	 * @return static
	 */
	public function getFirstDayOfMonth(): self
	{
		return $this->modifyClone('first day of this month')
			->setZeroTime();
	}

	/**
	 * @return static
	 */
	public function getLastDayOfMonth(): self
	{
		return $this->modifyClone('last day of this month')
			->setMidnight();
	}

	/**
	 * @return static
	 */
	public function getFirstDayOfYear(): self
	{
		return $this->modifyClone(sprintf('first day of January %s', $this->format('Y')))
			->setZeroTime();
	}

	/**
	 * @return static
	 */
	public function getLastDayOfYear(): self
	{
		return $this->modifyClone(sprintf('last day of December %s', $this->format('Y')))
			->setMidnight();
	}

}
