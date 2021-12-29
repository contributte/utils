<?php declare(strict_types = 1);

namespace Contributte\Utils;

use Nette\Utils\Validators as NetteValidators;

class Validators extends NetteValidators
{

	/**
	 * Validate RC
	 *
	 * @see https://phpfashion.com/jak-overit-platne-ic-a-rodne-cislo
	 */
	public static function isRc(string $rc): bool
	{
		// "be liberal in what you receive"
		if (preg_match('#^\s*(\d\d)(\d\d)(\d\d)[ /]*(\d\d\d)(\d?)\s*$#', $rc, $matches) !== 1) {
			return false;
		}

		[, $year, $month, $day, $ext, $c] = $matches;

		$numberForModulo = (int) ($year . $month . $day . $ext);

		$year = (int) $year;
		$month = (int) $month;
		$day = (int) $day;

		// till 1954 numbers of 9 digits cannot be validated
		if ($c === '') {
			return $year < 54;
		}

		// check number
		$mod = $numberForModulo % 11;

		if ($mod === 10) {
			$mod = 0;
		}

		if ($mod !== (int) $c) {
			return false;
		}

		// check date
		$year += $year < 54
			? 2000
			: 1900;

		// 20, 50 or 70 can be added to month
		if ($month > 70 && $year > 2003) {
			$month -= 70;
		} elseif ($month > 50) {
			$month -= 50;
		} elseif ($month > 20 && $year > 2003) {
			$month -= 20;
		}

		return checkdate($month, $day, $year);
	}

	/**
	 * Validate ICO
	 *
	 * @see https://phpfashion.com/jak-overit-platne-ic-a-rodne-cislo
	 */
	public static function isIco(string $inn): bool
	{
		// "be liberal in what you receive"
		$res = (string) preg_replace('#\s+#', '', $inn);

		// has correct form?
		if (preg_match('#^\d{8}$#', $res) !== 1) {
			return false;
		}

		// checksum
		$a = 0;

		for ($i = 0; $i < 7; $i++) {
			$a += (int) $res[$i] * (8 - $i);
		}

		$a %= 11;

		if ($a === 0) {
			$c = 1;
		} elseif ($a === 10) {
			$c = 1;
		} elseif ($a === 1) {
			$c = 0;
		} else {
			$c = 11 - $a;
		}

		return $c === (int) $res[7];
	}

}
