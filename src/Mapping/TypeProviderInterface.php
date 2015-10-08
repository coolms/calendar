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

use Traversable,
    Doctrine\Common\Collections\Collection;

/**
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface TypeProviderInterface
{
    /**
     * @param array|Traversable $types
     */
    public function setTypes($types);

    /**
     * @param array|Traversable $types
     */
    public function addTypes($types);

    /**
     * @param TypeInterface $type
     */
    public function addType(TypeInterface $type);

    /**
     * @param array|Traversable $types
     */
    public function removeTypes($types);

    /**
     * @param TypeInterface $type
     */
    public function removeType(TypeInterface $type);

    /**
     * Removes all types
     */
    public function clearTypes();

    /**
     * @return Collection
     */
    public function getTypes();
}
