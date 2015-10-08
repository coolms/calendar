<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar\Mapping\Traits;

use ArrayObject,
    Traversable,
    Zend\Form\Annotation as Form,
    CmsCalendar\Mapping\TypeInterface;

trait TypeProviderTrait
{
    /**
     * @var TypeInterface[]
     *
     * @Form\Type("ObjectSelect")
     * @Form\Attributes({"multiple":true,"size":5})
     * @Form\Options({
     *      "target_class":"CmsCalendar\Mapping\TypeInterface",
     *      "label":"Select types",
     *      "empty_option":"Select types"})
     */
    protected $types = [];

    /**
     * __construct
     */
    public function __construct()
    {
        $this->types = new ArrayObject($this->types);
    }

    /**
     * @param array|Traversable $types
     */
    public function setTypes($types)
    {
        $this->clearTypes();
        $this->addTypes($types);
    }

    /**
     * @param array|Traversable $types
     */
    public function addTypes($types)
    {
        foreach ($types as $type) {
            $this->addType($type);
        }
    }

    /**
     * @param TypeInterface $type
     */
    public function addType(TypeInterface $type)
    {
        $this->types[] = $type;
    }

    /**
     * @param array|Traversable $types
     */
    public function removeTypes($types)
    {
        foreach ($types as $type) {
            $this->removeType($type);
        }
    }

    /**
     * @param TypeInterface $type
     */
    public function removeType(TypeInterface $type)
    {
        foreach ($this->types as $key => $data) {
            if ($data === $type) {
                unset($this->types[$key]);
            }
        }
    }

    /**
     * Removes all types
     */
    public function clearTypes()
    {
        foreach ($this->types as $type) {
            $this->removeType($type);
        }
    }

    /**
     * @return TypeInterface[]
     */
    public function getTypes()
    {
        return $this->types;
    }
}
