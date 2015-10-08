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

use CmsCommon\Mapping\Common\NameableInterface,
    CmsCommon\Mapping\Common\DescribableInterface,
    CmsCalendar\HolidayRuleInterface as GeneralHolidayRuleInterface;

interface HolidayRuleInterface extends GeneralHolidayRuleInterface, NameableInterface, DescribableInterface
{
    
}
