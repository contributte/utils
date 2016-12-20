<?php

namespace Contributte\Utils;

use Nette\Utils\Strings as NetteStrings;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class Strings extends NetteStrings
{

    /**
     * Replaces $s at the start with $replacement
     *
     * @param string $s
     * @param string $search
     * @param string $replacement
     * @return string
     */
    public static function replacePrefix($s, $search, $replacement = '')
    {
        if (strncmp($s, $search, strlen($search)) === 0) {
            $s = $replacement . substr($s, strlen($search));
        }

        return $s;
    }

    /**
     * Replaces $s at the end with $replacement
     *
     * @param string $s
     * @param string $search
     * @param string $replacement
     * @return string
     */
    public static function replaceSuffix($s, $search, $replacement = '')
    {
        if (substr($s, -strlen($search)) === $search) {
            $s = substr($s, 0, -strlen($search)) . $replacement;
        }

        return $s;
    }

    /**
     * Remove spaces from the beginning and end of a string
     * and between chars
     *
     * @param string $s
     * @return mixed
     */
    public static function spaceless($s)
    {
        $s = trim($s);
        $s = self::replace($s, '#\s#', '');

        return $s;
    }

    /**
     * Remove spaces from the beginning and end of a string
     * and convert double and more spaces between chars to one space
     *
     * @param string $s
     * @return mixed
     */
    public static function doublespaceless($s)
    {
        $s = trim($s);
        $s = self::replace($s, '#\s{2,}#', ' ');

        return $s;
    }

    /**
     * Remove spaces from the beginning and end of a string and remove dashes
     *
     * @param string $s
     * @return mixed
     */
    public static function dashless($s)
    {
        $s = trim($s);
        $s = self::replace($s, '#\-#', '');

        return $s;
    }

}
