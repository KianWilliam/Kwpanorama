<?php
/**
 * @package     com_kwpanorama
 * @version     1.0.0
 * @copyright   Copyright (C) 2025. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      KWProductions Co. <webarchitect@kwproductions121.ir> - https://componentgenerator.com
 */

namespace Joomla\Component\Kwpanorama\Site\Helper;

defined('_JEXEC') or die;

/**
 * Kwpanorama datetime helper
 */
class DatetimeHelper
{
    /**
     * @param string $format
     * @return string
     */
    public static function convertStrftimeToDateTimeFormat(string $format): string
    {
        $replacements = [
            '%a' => 'D', '%A' => 'l', '%d' => 'd', '%e' => 'j', '%j' => 'z',
            '%u' => 'N', '%w' => 'w', '%U' => 'W', '%V' => 'W', '%W' => 'W',
            '%b' => 'M', '%B' => 'F', '%m' => 'm', '%C' => 'y', '%g' => 'y',
            '%G' => 'o', '%y' => 'y', '%Y' => 'Y', '%H' => 'H', '%I' => 'h',
            '%l' => 'g', '%M' => 'i', '%p' => 'A', '%P' => 'a', '%r' => 'h:i:s A',
            '%R' => 'H:i', '%S' => 's', '%T' => 'H:i:s', '%X' => 'H:i:s', '%z' => 'O',
            '%Z' => 'T', '%%' => '%'
        ];

        return strtr($format, $replacements);
    }

    /**
     * @param string $value
     * @param string $strftimeFormat
     * @return string
     */
    public static function convertFromStrftimeFormat(string $value, string $strftimeFormat): string
    {
        $datetime = \DateTime::createFromFormat('Y-m-d', $value);
        if (!$datetime) {
            return '';
        }
        return $datetime->format(self::convertStrftimeToDateTimeFormat($strftimeFormat));
    }
}
