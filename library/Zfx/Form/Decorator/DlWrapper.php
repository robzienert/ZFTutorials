<?php
class Zfx_Form_Decorator_DlWrapper extends Zend_Form_Decorator_Abstract
{
    /**
     * @var string Default placement; surround content
     */
    protected $_placement = null;

    /**
     * Wrap a DL tag around content
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        $elementName = $this->getElement()->getName();
        return '<dl id="' . $elementName . '-wrapper">' . $content . '</dl>';
    }
}