<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar\Mapping\Event;

use CmsCalendar\Mapping\EventInterface,
    CmsCalendar\Mapping\HolidayRuleInterface;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface RelatedInterface extends EventInterface
{
    /**
     * @param HolidayRuleInterface $holidayRule
     */
    public function setBasedOn(HolidayRuleInterface $holidayRule);

    /**
     * @return HolidayRuleInterface
     */
    public function getBasedOn();

    /**
     * @param int $days
     */
    public function setRelativeDays($days);

    /**
     * @return int
     */
    public function getRelativeDays();
}
