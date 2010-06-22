<?php
class Zfx_Form_Element_DateSelect extends Zend_Form_Element
{
    /**
     * @var string Form helper name
     */
    public $helper = 'formDateSelect';

    /**
     * Add a Date validator to the element, configuration can be made through
     * retrieving the validator through the element.
     * 
     */
    public function init()
    {
        $this->addValidator(new Zend_Validate_Date());
    }

    /**
     * Pieces the composite elements back together into a single value for
     * the purposes of validation.
     *
     * @param mixed $value
     * @param null|array $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        $stamp = array(
            'year' => '0000',
            'month' => '01',
            'day' => '01',
        );

        foreach ($stamp as $key => &$value) {
            $field = sprintf('%s_%s', $this->getName(), $key);
            if (array_key_exists($field, $context)) {
                $stamp[$key] = $context[$field];
            }
        }

        $date = sprintf('%c-%c-%c',
                        $stamp['year'],
                        $stamp['month'],
                        $stamp['day']);

        $this->setValue($date);

        return parent::isValid($this->getValue(), $context);
    }
}