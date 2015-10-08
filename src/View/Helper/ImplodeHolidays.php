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

use IntlDateFormatter,
    Zend\View\Helper\AbstractHelper,
    CmsCalendar\Stdlib\CalendarUtils;

/**
 * View helper for printing holidays.
 */
class ImplodeHolidays extends AbstractHelper
{
    /**
     * @var string
     */
    protected $separator = ', ';

    /**
     * @var string
     */
    protected $format = IntlDateFormatter::LONG;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @param array|Traversable $holidays
     * @param string $separator
     * @param string $format
     * @param string $locale
     * @return self|string
     */
    public function __invoke($holidays = null, $separator = null, $format = null, $locale = null)
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

        return $this->render($holidays, $separator, $format, $locale);
    }

    /**
     * @param array|Traversable $holidays
     * @param string $separator
     * @param string $format
     * @param string $locale
     * @return string
     */
    public function render($holidays, $separator = null, $format = null, $locale = null)
    {
        return CalendarUtils::implodeHolidays(
            $holidays,
            $separator ?: $this->getSeparator(),
            $format ?: $this->getFormat(),
            $locale ?: $this->getLocale()
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
}
