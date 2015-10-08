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

interface FixedInterface extends HolidayRuleInterface
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
     * @param int $day
     */
    public function setDayOfMonth($day);

    /**
     * @return int
     */
    public function getDayOfMonth();
}
