<?php
class Zfx_Form_DisplayGroup extends Zend_Form_DisplayGroup
{
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        // The only change between this and it's parent is that the HtmlTag
        // decorator for the dl tag has been removed.
        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                ->addDecorator('Fieldset');
        }
    }
}