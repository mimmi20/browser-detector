<?php
class Unister_View_Helper_HelpText extends Zend_View_Helper_Abstract
{

    private $_dbHelpText;

    private $_data;

    private $_field;

    private $_activator;

    public function helpText($fieldName, $activator = null)
    {
        $this->_field = strtolower($fieldName);
        $this->_activator = $activator;

        if (null !== $this->_data) {
            return $this;
        }

        $modelHelpText = new Model_HelpText();
        $rows = $modelHelpText->fetchAll(
            $modelHelpText->getAdapter()->quoteInto('HelpTextId > ?', 0)
        );
        if ($rows->count() <= 0) {
            return null;
        }

        while ($rows->valid()) {
            $this->_data[$rows->current()->FieldName]
                = $rows->current()->Text;
            $rows->next();
        }
        return $this;
    }

    public function __toString()
    {
        $helpText = trim($this->_data[$this->_field]);
        if (empty($helpText)) {
            return '';
        }

        if (null == $this->_activator) {
            $result = "<img class='HelpButton jqPercentInfo' src='";
            $result .= $this->view->mandantImage('hilfe.gif');
            $result .= "' alt='' title='' />";
        } else {
            $result = $this->_activator;
        }
        $result .= "<div class='PercentInfo jqZvHelpContainer' style='display:none'>";
        $result .= nl2br($helpText);
        $result .= "</div>";
        return $result;
    }

}