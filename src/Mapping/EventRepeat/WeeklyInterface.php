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

interface WeeklyInterface extends EventRepeatInterface
{
    /**
     * @param array $weeks
     */
    public function setWeeksOfMonth(array $weeks);

    /**
     * @return array
     */
    public function getWeeksOfMonth();

    /**
     * @param array $days
     */
    public function setDaysOfWeek(array $days);

    /**
     * @return array
     */
    public function getDaysOfWeek();
}
