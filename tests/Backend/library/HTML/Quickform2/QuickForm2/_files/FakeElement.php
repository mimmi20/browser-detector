<?php
/**
 * Class used to test creation of elements via HTML_QuickForm2_Factory::createElement()
 */
class FakeElement
{
    public $name;
    public $data;
    public $attributes;

    public function __construct($name = null, $attributes = null, $data = null)
    {
        $this->name         = $name;
        $this->data         = $data;
        $this->attributes   = $attributes;
    }
}
?>