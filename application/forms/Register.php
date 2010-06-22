<?php
class Application_Form_Register extends Zfx_Form
{
    public function init()
    {
        parent::init();
        
        $this->addElement('text', 'full_name', array(
            'label' => 'Full Name',
            'required' => true,
        ));
        $this->addElement('dateSelect', 'birthdate', array(
            'label' => 'Birthdate',
            'required' => true,
        ));

        // Display groups are completely unnecessary at this point; but added
        // just for good measure to show how the source is structured when
        // rendered with these in the mix.
        $this->addDisplayGroup(array('full_name', 'birthdate'),
            'basic_info', array('legend' => 'Basic Info'));
    }
}