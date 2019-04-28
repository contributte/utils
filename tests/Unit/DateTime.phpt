<?php declare(strict_types = 1);

/**
 * Test: DateTime
 */

require_once __DIR__ . '/../bootstrap.php';

use Contributte\Utils\DateTime;
use Tester\Assert;

// DateTime::setCurrentTime()
test(function (): void {
	$dt = DateTime::from('2020-10-10');
	Assert::equal('10.10.2020 00:00:00', $dt->format('d.m.Y H:i:s'));

	$dt = $dt->setCurrentTime();
	Assert::equal(sprintf('10.10.2020 %s:%s:%s', date('H'), date('i'), date('s')), $dt->format('d.m.Y H:i:s'));
});

// DateTime::create
test(function (): void {
	$dt = DateTime::create(['year' => 2020]);
	Assert::equal(DateTime::from(sprintf('%s.%s.%s', date('d'), date('m'), 2020)), $dt);

	$dt = DateTime::create(['year' => 2020, 'month' => 5]);
	Assert::equal(DateTime::from(sprintf('%s.%s.%s', date('d'), 5, 2020)), $dt);

	$dt = DateTime::create(['year' => 2020, 'month' => 5, 'day' => 2]);
	Assert::equal(DateTime::from(sprintf('%s.%s.%s', 2, 5, 2020)), $dt);
});

// DateTime::createBy
test(function (): void {
	$dt = DateTime::createBy(2020, 6, 1);
	Assert::equal(DateTime::from('2020-06-01'), $dt);
});

// DateTime::getFirstDayOfMonth
// DateTime::getLastDayOfMonth
// DateTime::getFirstDayOfYear
// DateTime::getLastDayOfYear
// DateTime::getFirstDayOfMonth
test(function (): void {
	$dt = new DateTime('15.6.2020');
	Assert::equal(DateTime::from('1.6.2020 00:00:00'), $dt->getFirstDayOfMonth());
	Assert::equal(DateTime::from('30.6.2020 23:59:59'), $dt->getLastDayOfMonth());
	Assert::equal(DateTime::from('1.1.2020 00:00:00'), $dt->getFirstDayOfYear());
	Assert::equal(DateTime::from('31.12.2020 23:59:59'), $dt->getLastDayOfYear());
});
