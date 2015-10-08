<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar\Mapping\EventRepeat;

use CmsCalendar\Mapping\EventRepeatInterface;

interface MonthlyInterface extends EventRepeatInterface
{
    /**
     * @param array $months
     */
    public function setMonthsOfYear(array $months);

    /**
     * @return array
     */
    public function getMonthsOfYear();

    /**
     * @param array $days
     */
    public function setDaysOfMonth(array $days);

    /**
     * @return array
     */
    public function getDaysOfMonth();
}
