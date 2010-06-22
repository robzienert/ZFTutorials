<?php
class Zfx_Form extends Zend_Form
{
    public function init()
    {
        // Setup new prefix paths
        $this->addPrefixPath('Zfx_Form', 'Zfx/Form');
        $this->addElementPrefixPath('Zfx', 'Zfx');
        
        // Change the default form display group class
        $this->setDefaultDisplayGroupClass('Zfx_Form_DisplayGroup');

        // Set the default element decorators. There are only two differences
        // between this and the default that ZF provides: Added "DlWrapper" at
        // to wrap the entire element at the end (LIFO) and dropped the "id"
        // from the DD HtmlTag decorator, since it isn't necessary with the
        // DlWrapper.
        $this->setElementDecorators(array(
            'ViewHelper',
            'Errors',
            array(
                'decorator' => 'Description',
                'options' => array(
                    'tag' => 'p',
                    'class' => 'description',
                ),
            ),
            array(
                'decorator' => 'HtmlTag',
                'options' => array('tag' => 'dd'),
            ),
            array(
                'decorator' => 'Label',
                'options' => array('tag' => 'dt')
            ),
            'DlWrapper'
        ));

        // Set new default form decorators
        $this->setDecorators(array(
            'FormElements',
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }

    /**
     * Alternatively, if you don't like using $this->setElementDecorators()
     * as it was done in the init method above, you can also do something like
     * the following to acheive the same result.
     *
     */
//    public function addElement($element, $name = null, $options = null)
//    {
//        parent::addElement($element, $name, $options);
//
//        if (!$element instanceof Zend_Form_Element) {
//            $element = $this->getElement($name);
//        }
//        if (!$element->loadDefaultDecoratorsIsDisabled()) {
//            $element->addDecorator('DlWrapper');
//        }
//
//        return $this;
//    }
}