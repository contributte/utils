<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Contributte\Utils\DateTime;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

// DateTime::setCurrentTime()
Toolkit::test(function (): void {
	$dt = DateTime::from('2020-10-10');
	Assert::equal('10.10.2020 00:00:00', $dt->format('d.m.Y H:i:s'));

	$dt = $dt->setCurrentTime();
	Assert::equal(sprintf('10.10.2020 %s:%s:%s', date('H'), date('i'), date('s')), $dt->format('d.m.Y H:i:s'));
});

// DateTime::create
Toolkit::test(function (): void {
	$dt = DateTime::create([]);
	Assert::equal(DateTime::from(sprintf('%s.%s.%s', date('d'), date('m'), date('Y'))), $dt);

	$dt = DateTime::create(['year' => 2020]);
	Assert::equal(DateTime::from(sprintf('%s.%s.%s', date('d'), date('m'), 2020)), $dt);

	$dt = DateTime::create(['year' => 2020, 'month' => 5]);
	Assert::equal(DateTime::from(sprintf('%s.%s.%s', date('d'), 5, 2020)), $dt);

	$dt = DateTime::create(['year' => 2020, 'month' => 5, 'day' => 2]);
	Assert::equal(DateTime::from(sprintf('%s.%s.%s', 2, 5, 2020)), $dt);
});

// DateTime::createBy
Toolkit::test(function (): void {
	$dt = DateTime::createBy(2020, 6, 1);
	Assert::equal(DateTime::from('2020-06-01'), $dt);
});

// DateTime::getFirstDayOfMonth
// DateTime::getLastDayOfMonth
// DateTime::getFirstDayOfYear
// DateTime::getLastDayOfYear
// DateTime::getFirstDayOfMonth
Toolkit::test(function (): void {
	$dt = new DateTime('15.6.2020');
	Assert::equal(DateTime::from('1.6.2020 00:00:00'), $dt->getFirstDayOfMonth());
	Assert::equal(DateTime::from('30.6.2020 23:59:59'), $dt->getLastDayOfMonth());
	Assert::equal(DateTime::from('1.1.2020 00:00:00'), $dt->getFirstDayOfYear());
	Assert::equal(DateTime::from('31.12.2020 23:59:59'), $dt->getLastDayOfYear());
});

// DateTime::getFirstDayOfWeek
// DateTime::getLastDayOfWeek
Toolkit::test(function (): void {
	$dt = new DateTime('18.6.2020');
	Assert::equal(DateTime::from('15.6.2020 00:00:00'), $dt->getFirstDayOfWeek());
	Assert::equal(DateTime::from('21.6.2020 23:59:59'), $dt->getLastDayOfWeek());

	$dt = new DateTime('31.7.2020');
	Assert::equal(DateTime::from('27.7.2020 00:00:00'), $dt->getFirstDayOfWeek());
	Assert::equal(DateTime::from('2.8.2020 23:59:59'), $dt->getLastDayOfWeek());
});

// DateTime::setToday
Toolkit::test(function (): void {
	$dt = DateTime::createBy(2020, 6, 1);
	$dt = $dt->setToday();
	Assert::equal(date('d.m.Y'), $dt->format('d.m.Y'));
});
