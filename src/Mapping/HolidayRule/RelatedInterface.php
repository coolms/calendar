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
 * Holidays and observances that related to another holiday, e.g. Easter and the holidays
 * that are related to it
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface RelatedInterface extends HolidayRuleInterface
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
