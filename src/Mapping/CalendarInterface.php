<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar\Mapping;

use DateTime,
    Traversable,
    Doctrine\Common\Collections\Collection;

interface CalendarInterface
{
    /**
     * @param array|Traversable $holidayRules
     */
    public function setHolidayRules($holidayRules);

    /**
     * @param array|Traversable $holidayRules
     */
    public function addHolidayRules($holidayRules);

    /**
     * @param HolidayRuleInterface $holiday
     */
    public function addHolidayRule(HolidayRuleInterface $holiday);

    /**
     * @param array|Traversable $holidayRules
     */
    public function removeHolidayRules($holidayRules);

    /**
     * @param HolidayRuleInterface $holiday
     */
    public function removeHolidayRule(HolidayRuleInterface $holiday);

    /**
     * Removes all holiday rules
     */
    public function clearHolidayRules();

    /**
     * @return Collection
     */
    public function getHolidayRules();

    /**
     * @param DateTime|string|int $startDate
     * @param DateTime|string|int $endDate
     * @return array
     */
    public function getHolidays($startDate = null, $endDate = null);

    /**
     * @param DateTime|string|int $startDate
     * @return array<HolidayInterface>
     */
    public function getNextHoliday($date = null);

    /**
     * @param DateTime|string|int $date
     * @return array<HolidayInterface>
     */
    public function getPreviousHoliday($date = null);

    /**
     * @param array|Traversable $events
     */
    public function setEvents($events);

    /**
     * @param array|Traversable $events
     */
    public function addEvents($events);

    /**
     * @param EventInterface $event
     */
    public function addEvent(EventInterface $event);

    /**
     * @param array|Traversable $events
     */
    public function removeEvents($events);

    /**
     * @param EventInterface $event
     */
    public function removeEvent(EventInterface $event);

    /**
     * Removes all events
     */
    public function clearEvents();

    /**
     * @return Collection
     */
    public function getEvents();
}
