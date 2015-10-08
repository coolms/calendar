<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar\Stdlib;

use DateTime,
    IntlDateFormatter,
    Locale,
    Traversable,
    CmsCommon\Stdlib\ArrayUtils,
    CmsCalendar\Holiday,
    CmsCalendar\HolidayInterface,
    CmsCalendar\HolidayRuleInterface;

/**
 * Declared abstract, as we have no need for instantiation.
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
abstract class CalendarUtils
{
    /**
     * @var string
     */
    protected static $defaultHolidayClass = Holiday::class;

    /**
     * @var array
     */
    protected static $dowMap = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    /**
     * @param  int $year
     * @return DateTime
     */
    public static function gregorianEasterDate($year = null)
    {
        if (null === $year) {
            $year = date('Y');
        }

        /* $g is the Golden Number-1 */
        $g = $year % 19;
        $c = (int)($year / 100);
        /* $h is 23-Epact (modulo 30) */
        $h = (int)($c - (int)($c / 4) - (int)((8 * $c + 13) / 25) + 19 * $g + 15) % 30;
        /* $i is the number of days from 21 March to the Paschal full moon */
        $i = (int)$h - (int)($h / 28) * (1 - (int)($h / 28) * (int)(29 / ($h + 1)) * ((int)(21 - $g) / 11));
        /* $j is the weekday for the Paschal full moon (0=Sunday,1=Monday, etc.) */
        $j = ($year + (int)($year/4) + $i + 2 - $c + (int)($c/4)) % 7;
        /* $l is the number of days from 21 March to the Sunday on or before
         * the Paschal full moon (a number between -6 and 28) */
        $l = $i - $j;

        $month = 3 + (int)(($l + 40) / 44);
        $day   = $l + 28 - 31 * ((int)($month / 4));
        $date  = (new DateTime)->setTimestamp(mktime(0,0,0, $month, $day, $year));

        return $date;
    }

    /**
     * @param  int $year
     * @return DateTime
     */
    public static function julianEasterDate($year = null)
    {
        if (null === $year) {
            $year = date('Y');
        }

        $a = $year % 4;
        $b = $year % 7;
        $c = $year % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;

        $month = floor(($d + $e + 114) / 31);
        $day   = (($d + $e + 114) % 31) + 1;
        $date  = (new DateTime)->setTimestamp(mktime(0, 0, 0, $month, $day + 13, $year));

        return $date;
    }

    /**
     * @param  array<HolidayRuleInterface>|Traversable $holidayRules
     * @param  DateTime|string|int $startDate
     * @param  DateTime|string|int $endDate
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function getHolidays($holidayRules, $startDate = null, $endDate = null)
    {
        $startDate = static::normalizeDateTime($startDate);

        if (null === $endDate) {
            $endDate = $startDate->createFromFormat('1 year', $startDate);
        } else {
            $endDate = static::normalizeDateTime($endDate);
        }

        if ($startDate > $endDate) {
            throw new \InvalidArgumentException('Start date must be earlier or equal to end date');
        }

        if ($holidayRules instanceof Traversable) {
            $holidayRules = ArrayUtils::iteratorToArray($holidayRules, false);
        }

        if (!is_array($holidayRules)) {
            throw new \InvalidArgumentException(sprintf(
                    'Holidays must be type of array or Traversable; %s given',
                    is_object($holidayRules) ? get_class($holidayRules) : gettype($holidayRules)
                ));
        }

        $interval = $startDate->diff($endDate);
        $years    = $interval->format('%y');
        $year     = $startDate->format('Y');
        $holidays = [];
        $holiday  = static::$defaultHolidayClass;

        for ($i = 0; $i <= $years; $i++) {

            /* @var $holidayRule HolidayRuleInterface */
            foreach ($holidayRules as $holidayRule) {

                if (!$holidayRule instanceof HolidayRuleInterface) {
                    throw new \InvalidArgumentException(sprintf(
                            '$holidayRule must be instance of %s; %s given',
                            HolidayRuleInterface::class,
                            is_object($holidayRule) ? get_class($holidayRule) : gettype($holidayRule)
                        ));
                }

                $date = $holidayRule->getDate($year);
                if ($date >= $startDate && $date <= $endDate) {
                    $index = $date->format('Y-m-d');
                    $holidays[$index][] = new $holiday($holidayRule, $year);
                }
            }

            $year++;
        }

        ksort($holidays);

        return $holidays;
    }

    /**
     * @param array|Traversabel $holidays
     * @param string $separator
     * @param int|string $format,
     * @param string $locale
     * @return string
     */
    public static function implodeHolidays(
        $holidays,
        $separator = ', ',
        $format = IntlDateFormatter::SHORT,
        $locale = null
    ) {
        if ($holidays instanceof Traversable) {
            $holidays = ArrayUtils::iteratorToArray($holidays);
        }

        if (!$holidays) {
            return;
        }

        if (!is_array($holidays)) {
            throw new \InvalidArgumentException('Argument 1 must be type of an array or ' .
                'an instance of Traversable');
        }

        $holidayDateFormatter = new IntlDateFormatter(
            $locale ?: Locale::getDefault(),
            is_numeric($format) ? $format : IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            null,
            IntlDateFormatter::GREGORIAN,
            is_numeric($format) ? null : $format
        );

        $formatted = [];
        foreach ($holidays as $index => $holiday) {
            if (is_numeric($index) && !$holiday instanceof HolidayInterface || !static::validate($index, 'Y-m-d')) {
                throw new \InvalidArgumentException('Argument 1 must be type of an array or ' .
                    'an instance of Traversable');
            }

            if (!is_array($holiday)) {
                $holiday = [$holiday];
            }

            foreach ($holiday as $subHolidays) {
                $date = clone $subHolidays->getDate();

                if (static::validate($index, 'Y-m-d')) {
                    $date->modify($index);
                }

                $formatted[$index] = $holidayDateFormatter->format($date);
            }
        }

        return implode($separator, $formatted);
    }

    /**
     * @param  array<HolidayRuleInterface>|Traversable $holidayRules
     * @param  DateTime|string|int $date
     * @return array<HolidayInterface>
     */
    public static function getNextHoliday($holidayRules, $date = null)
    {
        $date      = static::normalizeDateTime($date);
        $endDate   = clone $date;

        $param_arr = array_slice(func_get_args(), 2);
        $param_arr = array_merge([$holidayRules, $date, $endDate->modify('1 year')], $param_arr);

        $holidays = call_user_func_array('static::getHolidays', $param_arr);

        $indexDate = new DateTime();
        foreach ($holidays as $index => $holiday) {
            if ($date < $indexDate->modify($index)) {
                return $holiday;
            }
        }

        return [];
    }

    /**
     * @param  array<HolidayRuleInterface>|Traversable $holidayRules
     * @param  DateTime|string|int $date
     * @return array<HolidayInterface>
     */
    public static function getPreviousHoliday($holidayRules, $date = null)
    {
        $date      = static::normalizeDateTime($date);
        $startDate = clone $date;

        $param_arr = array_slice(func_get_args(), 2);
        $param_arr = array_merge([$holidayRules, $startDate->modify('-1 year'), $date], $param_arr);

        $holidays  = call_user_func_array('static::getHolidays', $param_arr);
        $holidays  = array_reverse($holidays, true);

        $indexDate  = new DateTime();
        foreach ($holidays as $index => $holiday) {
            if ($date > $indexDate->modify($index)) {
                return $holiday;
            }
        }

        return [];
    }

    /**
     * @param  DateTime|string|int $startDate
     * @param  DateTime|string|int $endDate
     * @param  array $weekend
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function getWeekendDays($startDate, $endDate, array $weekend)
    {
        $startDate = static::normalizeDateTime($startDate);
        $endDate   = static::normalizeDateTime($endDate);

        if ($startDate > $endDate) {
            throw new \InvalidArgumentException('Start date must be earlier or equal to end date');
        }

        $days = [];
        $flipped_weekend = array_flip($weekend);
        $date = clone $startDate;

        while ($date <= $endDate) {
            $dow = $date->format('w');
            if (isset($flipped_weekend[$dow])) {
                $index = $date->format('Y-m-d');
                $days[$index] = $dow;
            }

            $date->modify('1 day');
        }

        ksort($days);

        return $days;
    }

    /**
     * @param  array $weekend
     * @param  DateTime|string|int $date
     * @return DateTime
     */
    public static function getNextWeekendDay(array $weekend, $date = null)
    {
        $date = static::normalizeDateTime($date);
    }

    /**
     * @param  array $weekend
     * @param  DateTime|string|int $date
     * @return DateTime
     */
    public static function getPreviousWeekendDay(array $weekend, $date = null)
    {
        $date = static::normalizeDateTime($date);
    }

    /**
     * @param array|Traversable $weekdays
     * @param string $separator
     * @param string $format
     * @param string $locale
     * @param string|int $firstDayOfWeek
     * @return string
     */
    public static function implodeWeekdays(
        $weekdays,
        $separator = ', ',
        $format = 'ccc',
        $locale = null,
        $firstDayOfWeek = null
    ) {
        if ($weekdays instanceof Traversable) {
            $weekdays = ArrayUtils::iteratorToArray($weekdays);
        }

        if (!$weekdays) {
            return;
        }

        if (!is_array($weekdays)) {
            throw new \InvalidArgumentException('Argument 1 must be type of an array or ' .
                'an instance of Traversable');
        }

        if (is_numeric($firstDayOfWeek)) {
            $firstDayOfWeek = static::$dowMap[$firstDayOfWeek];
        }

        $startDate = (new DateTime('now'))->modify($firstDayOfWeek ?: static::getFirstDayOfWeek($locale));
        $endDate   = clone $startDate;
        $endDate   = $endDate->modify('7 days');

        $weekdayFormat = new IntlDateFormatter(
            $locale ?: Locale::getDefault(),
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            $startDate->getTimezone()->getName(),
            IntlDateFormatter::GREGORIAN,
            $format
        );

        $formatted = [];
        while ($startDate <= $endDate) {
            $dow = $startDate->format('w'); // 0 = Sunday, 6 = Saturday
            if (in_array($dow, $weekdays) && !isset($formatted[$dow])) {
                $formatted[$dow] = $weekdayFormat->format($startDate);
            }

            $startDate->modify('+1 day'); // add one day to time
        }

        return implode($separator, $formatted);
    }

    /**
     * @param string $locale
     * @param string $format
     * @return string
     * @throws \RuntimeException
     */
    public static function getFirstDayOfWeek($locale = null, $format = 'D', $calendar = IntlDateFormatter::GREGORIAN)
    {
        $date = new DateTime('now');
        $dow = (new IntlDateFormatter(
            $locale ?: Locale::getDefault(),
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            $date->getTimezone()->getName(),
            $calendar,
            'c'
        ))->format($date);

        if (!is_numeric($dow)) {
            throw new \RuntimeException("Can't get a numeric value of current day of week for giving locale");
        }

        $dow--;
        $dow = $date->modify("-{$dow} days")->format($format);

        return $dow;
    }

    /**
     * @param mixed $date
     * @param string $format
     * @return bool
     */
    public static function validate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param DateTime|string|int $dateTime
     * @throws \InvalidArgumentException
     * @return DateTime
     */
    protected static function normalizeDateTime($dateTime)
    {
        if ($dateTime instanceof DateTime) {
            return $dateTime;
        }

        if (null === $dateTime) {
            $dateTime = 'now';
        }

        if (is_int($dateTime)) {
            $dateTime = "@$dateTime";
        }

        if (!is_string($dateTime)) {
            throw new \InvalidArgumentException('Argument 1 expected to be type of string, integer or ' .
                'an instance of DateTime object');
        }

        return new DateTime($dateTime);
    }
}
