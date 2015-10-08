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

use DateTime;

class Holiday implements HolidayInterface
{
    /**
     * @var HolidayRuleInterface
     */
    protected $rule;

    /**
     * @var int
     */
    protected $year;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * __construct
     *
     * @param HolidayRuleInterface $rule
     * @param int $year
     */
    public function __construct($rule, $year = null)
    {
        $this->setRule($rule);

        if (null !== $year) {
            $this->setYear($year);
        }
    }

    /**
     * @param HolidayRuleInterface $rule
     */
    protected function setRule(HolidayRuleInterface $rule)
    {
        $this->rule = $rule;
    }

    /**
     * {@inheritDoc}
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @param string $method
     * @param array  $param_arr
     */
    public function __call($method, $param_arr)
    {
        if (substr($method, 0, 3) === 'set') {
            $this->_reset();
        }

        return call_user_func_array([$this->rule, $method], $param_arr);
    }

    /**
     * {@inheritDoc}
     */
    public function getDate()
    {
        if (null === $this->date) {
            $this->date = clone $this->getRule()->getDate($this->getYear());
        }

        return $this->date;
    }

    /**
     * {@inheritDoc}
     */
    public function setYear($year)
    {
        $this->_reset();
        $this->year = null === $year ? $year : (int) $year;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getYear()
    {
        if (null === $this->year) {
            return (int) date('Y');
        }

        return $this->year;
    }

    /**
     * {@inheritDoc}
     */
    protected function _reset()
    {
        $this->date = null;
    }
}
