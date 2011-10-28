<?php
class Unister_View_Helper_DepCycle extends Zend_View_Helper_Abstract
{

    private $_status = array();

    public function depCycle($value1, $value2, $close = false, $closeValue = '') {
        $key = md5($value1.$value2);

        //Init new cycle
        if (!isset($this->_status[$key])) {
            $this->_status[$key] = 1;
        }

        //Determine Result
        if ($this->_status[$key] == 2 && $close) {
            $result = $closeValue;
        } else {
            if ($this->_status[$key] == 1) {
                $result = $value1;
            } else {
                $result = $value2;
            }
        }

        //Cycle
        if ($this->_status[$key] == 1) {
            $this->_status[$key] = 2;
        } else {
            $this->_status[$key] = 1;
        }

        return $result;
    }

    public function isCycleValue() {
        return "123";
    }

}