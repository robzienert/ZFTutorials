<?php
class Zfx_View_Helper_FormDateSelect extends Zend_View_Helper_Abstract
{
    /**
     * @var array Default date configuration
     */
    protected $_config = array(
        'attribs' => array(),
        'element_separator' => ' ',
        'order' => array(
            'month',
            'day',
            'year',
        ),
        'year_max' => null,
        'year_min' => 1900,
    );

    /**
     * Setup the date object
     * 
     */
    public function __construct()
    {
        $this->_date = new Zend_Date();
    }

    /**
     * Build the date select elements.
     *
     * @param string $name
     * @param null|string $value
     * @param array $config
     * @return string
     */
    public function formDateSelect($name, $value = null, $config = array())
    {
        $this->_config = array_merge($this->_config, $config);
        if (null === $this->_config['year_max']) {
            $this->_config['year_max'] = date('Y');
        }

        if (!$this->_date->isDate($value)) {
            $value = $this->_date->toString(Zend_Date::ISO_8601);
        }

        $this->_date->set($value);

        $year  = $this->_date->get(Zend_Date::YEAR);
        $month = $this->_date->get(Zend_Date::MONTH);
        $day   = $this->_date->get(Zend_Date::DAY);

        // For the sake of brevity; this example code does not include the
        // generation of days, so we'll mix it up and make the day element a
        // text element instead.
        $monthOptions = $this->_generateMonthOptions();
        $yearOptions  = $this->_generateYearOptions();

        // This is where we create the form elements. Bonus points for adding
        // support for the following:
        //  + Element-specific attribute configuration
        //  + Converting the following to public methods for generating the
        //    elements so the developer can use this easier in ViewScript
        //    use cases, like $helper->getYearSelect() and so-on.
        $elements = array();
        for ($i = 0; $i < 3; $i++) {
            $part = $this->_config['order'][$i];

            if ('day' == $part) {
                $attribs = $this->_config['attribs'] + array('maxlength' => 2);
                $elements[] = $this->view->formText(
                    $name . '_day',
                    $day,
                    $this->_config['attribs'],
                    $monthOptions);
            } else {
                $optionVar = "{$part}Options";
                $elements[] = $this->view->formSelect(
                    $name . '_' . $part,
                    $$part, // $year, $month
                    $this->_config['attribs'],
                    $$optionVar // $yearOptions, $monthOptions
                );
            }
        }

        $html = implode($this->_config['element_separator'], $elements);

        return $html;
    }

    /**
     * Creates an array of month options
     *
     * @return array
     */
    private function _generateMonthOptions()
    {
        $options = array();
        for ($i = 1; $i < 13; $i++) {
            $idx = str_pad($i, 2, '0', STR_PAD_LEFT);
            $this->_date->set($i, Zend_Date::MONTH);
            $options[$idx] = $this->_date->toString(Zend_Date::MONTH_NAME);
        }
        return $options;
    }

    /**
     * Creates an array of year options
     *
     * @return array
     * @throws LogicException If minimum year is not an integer
     * @throws LogicException If maximum year is not an integer
     * @throws LogicException If minimum year is greater than the maximum year
     */
    private function _generateYearOptions()
    {
        $min = $this->_config['year_min'];
        $max = $this->_config['year_max'];

        if (0 === intval($min)) {
            throw new LogicException('Minimum year must be an integer');
        }
        if (0 === intval($max)) {
            // Null values are handled earlier in the execution and assigned to
            // the current year
            throw new LogicException('Maximum year must be an integer or null');
        }
        if ($min > $max) {
            throw new LogicException('Minimum year cannot be greater than the maximum year');
        }

        $range   = range($max, $min);
        $options = array_combine($range, $range);
        
        return $options;
    }
}