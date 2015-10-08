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
    CmsCalendar\Mapping\EventRepeatInterface;

interface FixedInterface extends EventInterface
{
    /**
     * @param EventRepeatInterface $repeat
     */
    public function setRepeat(EventRepeatInterface $repeat);

    /**
     * @return EventRepeatInterface
     */
    public function getRepeat();
}
