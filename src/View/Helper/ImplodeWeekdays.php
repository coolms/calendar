<?php
/**
 * CoolMS2 Calendar Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/calendar for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsCalendar\View\Helper;

use Zend\View\Helper\AbstractHelper,
    CmsCalendar\Stdlib\CalendarUtils;

/**
 * View helper for printing weekdays.
 */
class ImplodeWeekdays extends AbstractHelper
{
    /**
     * @var string
     */
    protected $separator = ', ';

    /**
     * @var string
     */
    protected $format = 'ccc';

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $firstDayOfWeek;

    /**
     * @param array|Traversable $weekdays
     * @param string $separator
     * @param string $format
     * @param string $locale
     * @param int|string $firstDayOfWeek
     * @return self|string
     */
    public function __invoke($weekdays = null, $separator = null, $format = null, $locale = null, $firstDayOfWeek = null)
    {
        if (func_num_args() === 0) {
            return $this;
        }

        if (null !== $separator) {
            $this->setSeparator($separator);
        }

        if (null !== $format) {
            $this->setForamt($format);
        }

        if (null !== $locale) {
            $this->setLocale($locale);
        }

        if (null !== $firstDayOfWeek) {
            $this->setFirstDayOfWeek($firstDayOfWeek);
        }

        return $this->render($weekdays, $separator, $format, $locale, $firstDayOfWeek);
    }

    /**
     * @param array|Traversable $weekdays
     * @param string $separator
     * @param int|string $format
     * @param string $locale
     * @param int|string $firstDayOfWeek
     * @return string
     */
    public function render($weekdays, $separator = null, $format = null, $locale = null, $firstDayOfWeek = null)
    {
        return CalendarUtils::implodeWeekdays(
            $weekdays,
            $separator ?: $this->getSeparator(),
            $format ?: $this->getFormat(),
            $locale ?: $this->getLocale(),
            $firstDayOfWeek ?: $this->getFirstDayOfWeek()
        );
    }

    /**
     * @param string $separator
     * @return self
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
        return $this;
    }

    /**
     * @return string
     */
    protected function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param string|int $format
     * @return self
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return string|int
     */
    protected function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $locale
     * @return self
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return string
     */
    protected function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param int|string $dow
     * @return self
     */
    public function setFirstDayOfWeek($dow)
    {
        $this->firstDayOfWeek = $dow;
        return $this;
    }

    /**
     * @return string
     */
    protected function getFirstDayOfWeek()
    {
        return $this->firstDayOfWeek;
    }
}
