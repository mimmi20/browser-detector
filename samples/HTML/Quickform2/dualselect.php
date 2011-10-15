<?php
/*
 * Usage example for HTML_QuickForm2 package: custom element and renderer plugin
 *
 * The example demonstrates a custom element with special rendering needs and
 * shows how it can be output via a renderer plugin. The example element is
 * a (much) simpler version of HTML_QuickForm_advmultiselect.
 *
 * It also demonstrates how to plug in element's javascript and how to use
 * client-side validation with custom element.
 *
 * $Id: dualselect.php 310540 2011-04-27 07:28:25Z avb $
 */

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once 'HTML/QuickForm2/Renderer.php';
require_once 'HTML/QuickForm2/Renderer/Plugin.php';

/**
 * "Dualselect" element
 *
 * This element can be used instead of a normal multiple select. It renders as
 * two multiple selects and two buttons for moving options between them.
 * The values that end up in the "to" select are considered selected.
 */
class HTML_QuickForm2_Element_DualSelect extends HTML_QuickForm2_Element_Select
{
    protected $attributes = array('multiple' => 'multiple');

    protected $watchedAttributes = array('id', 'name', 'multiple');

    protected function onAttributeChange($name, $value = null)
    {
        if ('multiple' == $name && 'multiple' != $value) {
            throw new HTML_QuickForm2_InvalidArgumentException(
                "Required 'multiple' attribute cannot be changed"
            );
        }
        parent::onAttributeChange($name, $value);
    }

    public function __toString()
    {
        if ($this->frozen) {
            return $this->getFrozenHtml();
        } else {
            require_once 'HTML/QuickForm2/Renderer.php';

            return $this->render(
                HTML_QuickForm2_Renderer::factory('default')
                    ->setTemplateForId(
                        $this->getId(),
                        "<table class=\"dualselect\" id=\"{id}\">\n" .
                        "    <tr>\n" .
                        "       <td style=\"vertical-align: top;\">{select_from}</td>\n" .
                        "       <td style=\"vertical-align: middle;\">{button_from_to}<br />{button_to_from}</td>\n" .
                        "       <td style=\"vertical-align: top;\">{select_to}</td>\n" .
                        "    </tr>\n" .
                        "</table>"
                    )
            )->__toString();
        }
    }

    public function render(HTML_QuickForm2_Renderer $renderer)
    {
        // render as a normal select when frozen
        if ($this->frozen) {
            $renderer->renderElement($this);
        } else {
            $jsBuilder = $renderer->getJavascriptBuilder();
            $this->renderClientRules($jsBuilder);
            $jsBuilder->addLibrary('dualselect', 'dualselect.js', 'js/',
                                   dirname(__FILE__) . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR);
            $keepSorted = empty($this->data['keepSorted'])? 'false': 'true';
            $jsBuilder->addElementJavascript("qf.elements.dualselect.init('{$this->getId()}', {$keepSorted});");
            // Fall back to using the Default renderer if custom one does not have a plugin
            if ($renderer->methodExists('renderDualSelect')) {
                $renderer->renderDualSelect($this);
            } else {
                $renderer->renderElement($this);
            }
        }
        return $renderer;
    }

    public function toArray()
    {
        $id    = $this->getId();
        $name = $this->getName();

        $selectFrom = new HTML_QuickForm2_Element_Select(
            "_{$name}", array('id' => "{$id}-from") + $this->attributes
        );
        $selectTo   = new HTML_QuickForm2_Element_Select(
            $name, array('id' => "{$id}-to") + $this->attributes
        );
        $strValues = array_map('strval', $this->values);
        foreach ($this->optionContainer as $option) {
            // We don't do optgroups here
            if (!is_array($option)) {
                continue;
            }
            $value = $option['attr']['value'];
            unset($option['attr']['value']);
            if (in_array($value, $strValues, true)) {
                $selectTo->addOption($option['text'], $value,
                                     empty($option['attr'])? null: $option['attr']);
            } else {
                $selectFrom->addOption($option['text'], $value,
                                       empty($option['attr'])? null: $option['attr']);
            }
        }

        $buttonFromTo = HTML_QuickForm2_Factory::createElement(
            'button', "{$name}_fromto",
            array('type' => 'button', 'id' => "{$id}-fromto") +
                (empty($this->data['from_to']['attributes'])? array(): self::prepareAttributes($this->data['from_to']['attributes'])),
            array('content' => (empty($this->data['from_to']['content'])? ' &gt;&gt; ': $this->data['from_to']['content']))
        );
        $buttonToFrom = HTML_QuickForm2_Factory::createElement(
            'button', "{$name}_tofrom",
            array('type' => 'button', 'id' => "{$id}-tofrom") +
                (empty($this->data['to_from']['attributes'])? array(): self::prepareAttributes($this->data['to_from']['attributes'])),
            array('content' => (empty($this->data['to_from']['content'])? ' &lt;&lt; ': $this->data['to_from']['content']))
        );
        return array(
            'select_from'    => $selectFrom->__toString(),   'select_to'      => $selectTo->__toString(),
            'button_from_to' => $buttonFromTo->__toString(), 'button_to_from' => $buttonToFrom->__toString()
        );
    }

   /**
    * Returns Javascript code for getting the element's value
    *
    * All options in "to" select are considered dualselect's values,
    * we need to use an implementation different from that for a standard
    * select-multiple. When returning a parameter for getContainerValue()
    * we should also provide the element's name.
    *
    * @param  bool  Whether it should return a parameter for qf.form.getContainerValue()
    * @return   string
    */
    public function getJavascriptValue($inContainer = false)
    {
        if ($inContainer) {
            return "{name: '{$this->getName()}[]', value: qf.elements.dualselect.getValue('{$this->getId()}-to')}";
        } else {
            return "qf.elements.dualselect.getValue('{$this->getId()}-to')";
        }
    }

    public function getJavascriptTriggers()
    {
        $id = $this->getId();
        return array("{$id}-from", "{$id}-to", "{$id}-fromto", "{$id}-tofrom");
    }
}

/**
 * Renderer plugin for outputting dualselect
 *
 * A plugin is needed since we want to control outputting the selects and
 * buttons via the template. Also default template contains placeholders for
 * two additional labels.
 */
class HTML_QuickForm2_Renderer_Default_DualSelectPlugin
    extends HTML_QuickForm2_Renderer_Plugin
{
    public function setRenderer(HTML_QuickForm2_Renderer $renderer)
    {
        parent::setRenderer($renderer);
        if (empty($this->renderer->templatesForClass['html_quickform2_element_dualselect'])) {
            $this->renderer->templatesForClass['html_quickform2_element_dualselect'] = <<<TPL
<div class="row">
    <label for="{id}-from" class="element"><qf:required><span class="required">* </span></qf:required>{label}</label>
    <div class="element<qf:error> error</qf:error>">
        <qf:error><span class="error">{error}<br /></span></qf:error>
        <table class="dualselect" id="{id}">
            <tr>
                <td style="vertical-align: top;">{select_from}</td>
                <td style="vertical-align: middle;">{button_from_to}<br />{button_to_from}</td>
                <td style="vertical-align: top;">{select_to}</td>
            </tr>
            <qf:label_2>
            <qf:label_3>
            <tr>
                <th>{label_2}</th>
                <th>&nbsp;</th>
                <th>{label_3}</th>
            </tr>
            </qf:label_3>
            </qf:label_2>
        </table>
    </div>
</div>
TPL;
        }
    }

    public function renderDualSelect(HTML_QuickForm2_Node $element)
    {
        $elTpl = $this->renderer->prepareTemplate($this->renderer->findTemplate($element), $element);
        foreach ($element->toArray() as $k => $v) {
            $elTpl = str_replace('{' . $k . '}', $v, $elTpl);
        }
        $this->renderer->html[count($this->renderer->html) - 1][] = str_replace('{id}', $element->getId(), $elTpl);
    }
}

// Now we register both the element and the renderer plugin
HTML_QuickForm2_Factory::registerElement('dualselect', 'HTML_QuickForm2_Element_DualSelect');
HTML_QuickForm2_Renderer::registerPlugin('default', 'HTML_QuickForm2_Renderer_Default_DualSelectPlugin');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <style type="text/css">
/* Set up custom font and form width */
body {
    margin-left: 10px;
    font-family: Arial,sans-serif;
    font-size: small;
}

.quickform {
    min-width: 700px;
    max-width: 800px;
    width: 760px;
}

/* Use default styles included with the package */

<?php
if ('@data_dir@' != '@' . 'data_dir@') {
    $filename = '@data_dir@/HTML_QuickForm2/quickform.css';
} else {
    $filename = dirname(dirname(dirname(__FILE__))) . '/data/quickform.css';
}
readfile($filename);
?>
    </style>
    <title>HTML_QuickForm2 dualselect example: custom element and renderer plugin</title>
</head>
<body>
<?php

$options = array(
      4 => "Afghanistan",                              8 => "Albania",                 12 => "Algeria",                   20 => "Andorra",                        24 => "Angola",             28 => "Antigua and Barbuda",             32 => "Argentina",             51 => "Armenia",                                       36 => "Australia",                 40 => "Austria",
     31 => "Azerbaijan",                              44 => "Bahamas",                 48 => "Bahrain",                   50 => "Bangladesh",                     52 => "Barbados",          112 => "Belarus",                         56 => "Belgium",               84 => "Belize",                                       204 => "Benin",                     64 => "Bhutan",
     68 => "Bolivia",                                 70 => "Bosnia and Herzegovina",  72 => "Botswana",                  76 => "Brazil",                         96 => "Brunei Darussalam", 100 => "Bulgaria",                       854 => "Burkina Faso",         108 => "Burundi",                                      116 => "Cambodia",                 120 => "Cameroon",
    124 => "Canada",                                 132 => "Cape Verde",             140 => "Central African Republic", 148 => "Chad",                          152 => "Chile",             156 => "China",                          170 => "Colombia",             174 => "Comoros",                                      178 => "Congo",                    180 => "Congo, Democratic Republic of",
    184 => "Cook Islands",                           188 => "Costa Rica",             384 => "Cote D'Ivoire",            191 => "Croatia",                       192 => "Cuba",              196 => "Cyprus",                         203 => "Czech Republic",       208 => "Denmark",                                      262 => "Djibouti",                 212 => "Dominica",
    214 => "Dominican Republic",                     218 => "Ecuador",                818 => "Egypt",                    222 => "El Salvador",                   226 => "Equatorial Guinea", 232 => "Eritrea",                        233 => "Estonia",              231 => "Ethiopia",                                     242 => "Fiji",                     246 => "Finland",
    250 => "France",                                 266 => "Gabon",                  270 => "Gambia",                   268 => "Georgia",                       276 => "Germany",           288 => "Ghana",                          300 => "Greece",               308 => "Grenada",                                      320 => "Guatemala",                324 => "Guinea",
    624 => "Guinea-Bissau",                          328 => "Guyana",                 332 => "Haiti",                    336 => "Holy See (Vatican City State)", 340 => "Honduras",          348 => "Hungary",                        352 => "Iceland",              356 => "India",                                        360 => "Indonesia",                364 => "Iran",
    368 => "Iraq",                                   372 => "Ireland",                376 => "Israel",                   380 => "Italy",                         388 => "Jamaica",           392 => "Japan",                          400 => "Jordan",               398 => "Kazakhstan",                                   404 => "Kenya",                    296 => "Kiribati",
    408 => "Korea, Democratic People's Republic of", 410 => "Korea, Republic of",     414 => "Kuwait",                   417 => "Kyrgyz Republic",               418 => "Laos",              428 => "Latvia",                         422 => "Lebanon",              426 => "Lesotho",                                      430 => "Liberia",                  434 => "Libya",
    438 => "Liechtenstein",                          440 => "Lithuania",              442 => "Luxembourg",               807 => "Macedonia",                     450 => "Madagascar",        454 => "Malawi",                         458 => "Malaysia",             462 => "Maldives",                                     466 => "Mali",                     470 => "Malta",
    584 => "Marshall Islands",                       474 => "Martinique",             478 => "Mauritania",               480 => "Mauritius",                     484 => "Mexico",            583 => "Micronesia",                     498 => "Moldova",              492 => "Monaco",                                       496 => "Mongolia",                 499 => "Montenegro",
    504 => "Morocco",                                508 => "Mozambique",             104 => "Myanmar",                  516 => "Namibia",                       520 => "Nauru",             524 => "Nepal",                          528 => "Netherlands",          554 => "New Zealand",                                  558 => "Nicaragua",                562 => "Niger",
    566 => "Nigeria",                                570 => "Niue",                   578 => "Norway",                   512 => "Oman",                          586 => "Pakistan",          585 => "Palau",                          591 => "Panama",               598 => "Papua New Guinea",                             600 => "Paraguay",                 604 => "Peru",
    608 => "Philippines",                            616 => "Poland",                 620 => "Portugal",                 634 => "Qatar",                         642 => "Romania",           643 => "Russian Federation",             646 => "Rwanda",               882 => "Samoa",                                        674 => "San Marino",               678 => "Sao Tome and Principe",
    682 => "Saudi Arabia",                           686 => "Senegal",                688 => "Serbia",                   690 => "Seychelles",                    694 => "Sierra Leone",      702 => "Singapore",                      703 => "Slovakia",             705 => "Slovenia",                                      90 => "Solomon Islands",          706 => "Somalia",
    710 => "South Africa",                           724 => "Spain",                  144 => "Sri Lanka",                659 => "St. Kitts and Nevis",           662 => "St. Lucia",         670 => "St. Vincent and the Grenadines", 736 => "Sudan",                740 => "Suriname",                                     748 => "Swaziland",                752 => "Sweden",
    756 => "Switzerland",                            760 => "Syria",                  158 => "Taiwan",                   762 => "Tajikistan",                    834 => "Tanzania",          764 => "Thailand",                       626 => "Timor-Leste",          768 => "Togo",                                         776 => "Tonga",                    780 => "Trinidad and Tobago",
    788 => "Tunisia",                                792 => "Turkey",                 795 => "Turkmenistan",             798 => "Tuvalu",                        800 => "Uganda",            804 => "Ukraine",                        784 => "United Arab Emirates", 826 => "United Kingdom of Great Britain & N. Ireland", 840 => "United States of America", 858 => "Uruguay",
    860 => "Uzbekistan",                             548 => "Vanuatu",                862 => "Venezuela",                704 => "Viet Nam",                      732 => "Western Sahara",    887 => "Yemen",                          894 => "Zambia",               716 => "Zimbabwe"
);

$form = new HTML_QuickForm2('dualselect');
$form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
    'destinations' => array(4, 148, 180, 368, 706, 736, 716)
)));

$fs = $form->addElement('fieldset')
        ->setLabel('A custom "dualselect" element using a renderer plugin for output');

$ds = $fs->addElement(
    'dualselect', 'destinations',
    array('size' => 10, 'style' => 'width: 215px; font-size: 90%'),
    array(
        'options'    => $options,
        'keepSorted' => true,
        'from_to'    => array('content' => ' &gt;&gt; ', 'attributes' => array('style' => 'font-size: 90%')),
        'to_from'    => array('content' => ' &lt&lt; ', 'attributes' => array('style' => 'font-size: 90%')),
    )
)->setLabel(array(
    'Popular travel destinations:',
    'Available',
    'Chosen'
));

$ds->addRule('required', 'Select at least two destinations', 2,
             HTML_QuickForm2_Rule::ONBLUR_CLIENT_SERVER);

$fs->addElement('checkbox', 'doFreeze', null, array('content' => 'Freeze dualselect on form submit'));

$fs->addElement('submit', 'testSubmit', array('value' => 'Submit form'));

// outputting form values
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $value = $form->getValue();
    echo "<pre>\n";
    var_dump($value);
    echo "</pre>\n<hr />";

    if (!empty($value['doFreeze'])) {
        $ds->toggleFrozen(true);
    }
}

$renderer = HTML_QuickForm2_Renderer::factory('default');

$form->render($renderer);
echo $renderer->getJavascriptBuilder()->getLibraries(true, true);
echo $renderer;
?>
</body>
</html>