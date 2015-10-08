<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar;

return [
    'view_helpers' => [
        'aliases' => [
            'cmsCalendarImplodeHolidays' => 'CmsCalendar\View\Helper\ImplodeHolidays',
            'cmsCalendarImplodeWeekdays' => 'CmsCalendar\View\Helper\ImplodeWeekdays',
        ],
        'invokables' => [
            'CmsCalendar\View\Helper\ImplodeHolidays' => 'CmsCalendar\View\Helper\ImplodeHolidays',
            'CmsCalendar\View\Helper\ImplodeWeekdays' => 'CmsCalendar\View\Helper\ImplodeWeekdays',
        ],
    ],
];
