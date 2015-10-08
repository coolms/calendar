<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar\Mapping\HolidayRule;

use CmsCalendar\Mapping\HolidayRuleInterface;

/**
 * Holidays and observances that occur on different days each year, e.g. days occurring on
 * a given weekday within a month (e.g. on the third Monday in January)
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface MoveableInterface extends HolidayRuleInterface
{
    /**
     * @param int $month
     */
    public function setMonthOfYear($month);

    /**
     * @return int
     */
    public function getMonthOfYear();

    /**
     * @param int $week
     */
    public function setWeekOfMonth($week);

    /**
     * @return int
     */
    public function getWeekOfMonth();

    /**
     * @param int $day
     */
    public function setDayOfWeek($day);

    /**
     * @return int
     */
    public function getDayOfWeek();
}
