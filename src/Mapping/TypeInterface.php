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

use CmsCommon\Mapping\Common\NameableInterface;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface TypeInterface extends NameableInterface
{
    const TYPE_NATIONAL     = 'national';
    const TYPE_RELIGIOUS    = 'religious';
    const TYPE_SCHOOL       = 'school';
    const TYPE_SECULAR      = 'secular';
}
