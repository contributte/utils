<?php

namespace App\Core\Utils;

use Nette\Utils\Validators as NetteValidators;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Validators extends NetteValidators
{

	/**
	 * Validate RC
	 *
	 * @param string $rc
	 * @return bool
	 *
	 * @see http://latrine.dgx.cz/jak-overit-platne-ic-a-rodne-cislo
	 */
	public static function isRc($rc)
	{
		// "be liberal in what you receive"
		if (!preg_match('#^\s*(\d\d)(\d\d)(\d\d)[ /]*(\d\d\d)(\d?)\s*$#', $rc, $matches)) {
			return FALSE;
		}

		list(, $year, $month, $day, $ext, $c) = $matches;

		// till 1954 numbers of 9 digits cannot be validated
		if ($c === '') {
			return $year < 54;
		}

		// check number
		$mod = ($year . $month . $day . $ext) % 11;
		if ($mod === 10)
			$mod = 0;
		if ($mod !== (int) $c) {
			return FALSE;
		}

		// check date
		$year += $year < 54 ? 2000 : 1900;

		// 20, 50 or 70 can be added to month
		if ($month > 70 && $year > 2003)
			$month -= 70;
		elseif ($month > 50)
			$month -= 50;
		elseif ($month > 20 && $year > 2003)
			$month -= 20;

		if (!checkdate($month, $day, $year)) {
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Validate ICO
	 *
	 * @param string $inn
	 * @return bool
	 *
	 * @see http://latrine.dgx.cz/jak-overit-platne-ic-a-rodne-cislo
	 */
	public static function isIco($inn)
	{
		// "be liberal in what you receive"
		$inn = preg_replace('#\s+#', '', $inn);

		// has correct form?
		if (!preg_match('#^\d{8}$#', $inn)) {
			return FALSE;
		}

		// checksum
		$a = 0;
		for ($i = 0; $i < 7; $i++) {
			$a += $inn[$i] * (8 - $i);
		}

		$a = $a % 11;

		if ($a === 0)
			$c = 1;
		elseif ($a === 10)
			$c = 1;
		elseif ($a === 1)
			$c = 0;
		else $c = 11 - $a;

		return $c === (int) $inn[7];
	}

}
