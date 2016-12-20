<?php

namespace Contributte\Utils;

use DateTimeInterface;
use Nette\Utils\DateTime as NetteDateTime;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class DateTime extends NetteDateTime
{

	/**
	 * @param string|int|DateTimeInterface $time
	 * @return static
	 */
	public static function from($time)
	{
		return parent::from($time);
	}

	/**
	 * @param string $modify
	 * @return static
	 */
	public function modifyClone($modify = '')
	{
		return parent::modifyClone($modify);
	}

	/**
	 * TIMES *******************************************************************
	 */

	/**
	 * Set time to current time
	 *
	 * @return static
	 */
	public function setCurrentTime()
	{
		return $this->modifyClone()->setTime(date('H'), date('i'), date('s'));
	}

	/**
	 * Reset current time (00:00:00)
	 *
	 * @return static
	 */
	public function resetTime()
	{
		return $this->modifyClone()->setTime(0, 0, 0);
	}

	/**
	 * Reset current time (00:00:00)
	 *
	 * @return static
	 */
	public function setZeroTime()
	{
		return $this->resetTime();
	}

	/**
	 * Set time to midnight (23:59:59)
	 *
	 * @return static
	 */
	public function setMidnight()
	{
		return $this->modifyClone()->setTime(23, 59, 59);
	}

	/**
	 * DATES *******************************************************************
	 */

	/**
	 * Set date to today
	 *
	 * @return static
	 */
	public function setToday()
	{
		return $this->modifyClone()->setDate(date('Y'), date('m'), date('d'));
	}

	/**
	 * FACTORIES ***************************************************************
	 */

	/**
	 * @param int $year
	 * @param int $month
	 * @param int $day
	 * @param int $hour
	 * @param int $minute
	 * @param int $second
	 * @return static
	 */
	public static function createBy($year = NULL, $month = NULL, $day = NULL, $hour = NULL, $minute = NULL, $second = NULL)
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
	 * @param array $args
	 * @return static
	 */
	public static function create(array $args)
	{
		$date = new static();

		if (!isset($args['year'])) $args['year'] = date('Y');
		if (!isset($args['month'])) $args['month'] = date('m');
		if (!isset($args['day'])) $args['day'] = date('d');
		if (!isset($args['hour'])) $args['hour'] = 0;
		if (!isset($args['minute'])) $args['minute'] = 0;
		if (!isset($args['second'])) $args['second'] = 0;

		$date->setDate($args['year'], $args['month'], $args['day']);
		$date->setTime($args['hour'], $args['minute'], $args['second']);

		return $date;
	}

	/**
	 * MANIPULATORS ************************************************************
	 */

	/**
	 * @return static
	 */
	public function getFirstDayOfWeek()
	{
		return $this->modifyClone('first day of this week')
			->setZeroTime();
	}

	/**
	 * @return static
	 */
	public function getLastDayOfWeek()
	{
		return $this->modifyClone('last day of this week')
			->setMidnight();
	}

	/**
	 * @return static
	 */
	public function getFirstDayOfMonth()
	{
		return $this->modifyClone('first day of this month')
			->setZeroTime();
	}

	/**
	 * @return static
	 */
	public function getLastDayOfMonth()
	{
		return $this->modifyClone('last day of this month')
			->setMidnight();
	}

	/**
	 * @return static
	 */
	public function getFirstDayOfYear()
	{
		return $this->modifyClone(sprintf('first day of January %s', $this->format('Y')))
			->setZeroTime();
	}

	/**
	 * @return static
	 */
	public function getLastDayOfYear()
	{
		return $this->modifyClone(sprintf('last day of December %s', $this->format('Y')))
			->setMidnight();
	}

}
