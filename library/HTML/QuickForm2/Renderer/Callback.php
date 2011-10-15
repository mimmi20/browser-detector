<?php
/**
 * Callback renderer for HTML_QuickForm2
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2006-2011, Alexey Borzov <avb@php.net>,
 *                          Bertrand Mansion <golgote@mamasam.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *    * Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the
 *      documentation and/or other materials provided with the distribution.
 *    * The names of the authors may not be used to endorse or promote products
 *      derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     Alexey Borzov <avb@php.net>
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @license    http://opensource.org/licenses/bsd-license.php New BSD License
 * @version    SVN: $Id: Callback.php 316761 2011-09-14 16:08:37Z mansion $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Abstract base class for QuickForm2 renderers
 */
require_once 'HTML/QuickForm2/Renderer.php';

/**
 * Callback renderer for QuickForm2
 *
 * This renderer uses PHP callbacks to render form elements
 *
 * While almost everything in this class is defined as public, its properties
 * and those methods that are not published (i.e. not in array returned by
 * exportMethods()) will be available to renderer plugins only.
 *
 * The following methods are published:
 *   - {@link reset()}
 *   - {@link setCallbackForClass()}
 *   - {@link setCallbackForId()}
 *   - {@link setErrorGroupCallback()}
 *   - {@link setElementCallbackForGroupClass()}
 *   - {@link setElementCallbackForGroupId()}
 *   - {@link setHiddenGroupCallback()}
 *   - {@link setRequiredNoteCallback()}
 *   - {@link setLabelCallback()}
 *
 * Using a callback to render a Submit button and a Cancel link:
 * <code>
 * function renderSubmitCancel($renderer, $submit) {
 *   $data = $submit->getData();
 *   $url = !empty($data['cancel']) ? $data['cancel'] : '/';
 *   return '<div>'.$submit.' or <a href="'.$url.'">Cancel</a></div>';
 * }
 * $renderer = HTML_QuickForm2_Renderer::factory('callback');
 * $renderer->setCallbackForId($submit->getId(), 'renderSubmitCancel');
 * </code>
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     Alexey Borzov <avb@php.net>
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @version    Release: 0.6.1
 */
class HTML_QuickForm2_Renderer_Callback extends HTML_QuickForm2_Renderer
{
   /**
    * Whether the form contains required elements
    * @var  bool
    */
    public $hasRequired = false;

   /**
    * HTML generated for the form
    * @var  array
    */
    public $html = array(array());

   /**
    * HTML for hidden elements if 'group_hiddens' option is on
    * @var  string
    */
    public $hiddenHtml = '';

   /**
    * HTML for hidden elements if 'group_hiddens' option is on
    * @var  string
    */
    public $hidden = array();

   /**
    * Array of validation errors if 'group_errors' option is on
    * @var  array
    */
    public $errors = array();

    /**
    * Callback used to render errors if 'group_errors' is on
    * @var  mixed
    */
    public $errorGroupCallback = array('HTML_QuickForm2_Renderer_Callback', '_renderErrorsGroup');

    /**
    * Callback used to render hidden elements
    * @var  mixed
    */
    public $hiddenGroupCallback = array('HTML_QuickForm2_Renderer_Callback', '_renderHiddenGroup');

    /**
    * Callback used to render required note
    * @var  mixed
    */
    public $requiredNoteCallback = array('HTML_QuickForm2_Renderer_Callback', '_renderRequiredNote');

    /**
    * Callback used to render labels
    * @var  mixed
    */
    public $labelCallback = array('HTML_QuickForm2_Renderer_Callback', '_renderLabel');

   /**
    * Array of callbacks defined using an element or container ID
    * @var  array
    */
    public $callbacksForId = array();

    /**
    * Array of callbacks defined using an element class
    * @var  array
    */
    public $callbacksForClass = array(
        'html_quickform2'                     => array('HTML_QuickForm2_Renderer_Callback', '_renderForm'),
        'html_quickform2_element'             => array('HTML_QuickForm2_Renderer_Callback', '_renderElement'),
        'html_quickform2_element_inputhidden' => array('HTML_QuickForm2_Renderer_Callback', '_renderHidden'),
        'html_quickform2_container'           => array('HTML_QuickForm2_Renderer_Callback', '_renderContainer'),
        'html_quickform2_container_group'     => array('HTML_QuickForm2_Renderer_Callback', '_renderGroup'),
        'html_quickform2_container_fieldset'  => array('HTML_QuickForm2_Renderer_Callback', '_renderFieldset')
    );

    /**
    * Array of callbacks defined using a group ID
    * @var  array
    */
    public $elementCallbacksForGroupId = array();

    /**
    * Array of callbacks defined using a group class
    * @var  array
    */
    public $elementCallbacksForGroupClass = array();

   /**
    * Array containing IDs of the groups being rendered
    * @var  array
    */
    public $groupId = array();

    protected function exportMethods()
    {
        return array(
            'reset',
            'setCallbackForClass',
            'setCallbackForId',
            'setErrorGroupCallback',
            'setElementCallbackForGroupClass',
            'setElementCallbackForGroupId',
            'setHiddenGroupCallback',
            'setRequiredNoteCallback',
            'setLabelCallback'
        );
    }

    public static function _renderForm(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2 $form)
    {
        $break = HTML_Common2::getOption('linebreak');
        $html[] = '<div class="quickform">';
        $html[] = call_user_func($renderer->errorGroupCallback, $renderer, $form);
        $html[] = '<form'.$form->getAttributes(true).'><div>';
        $html[] = call_user_func($renderer->hiddenGroupCallback, $renderer, $form);
        $html[] = implode($break, array_pop($renderer->html));
        $html[] = '</div></form>';
        $html[] = call_user_func($renderer->requiredNoteCallback, $renderer, $form);
        $script = $renderer->getJavascriptBuilder()->getFormJavascript($form->getId());
        if (!empty($script)) {
            $html[] = $script;
        }
        $html[] = '</div>';
        return implode($break, $html) . $break;
    }

    public static function _renderElement(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2_Element $element)
    {
        $html[] = '<div class="row">';
        $html[] = $renderer->renderLabel($element);
        $error = $element->getError();
        if ($error) {
            $html[] = '<div class="element error">';
            if ($renderer->getOption('group_errors')) {
                $renderer->errors[] = $error;
            } else {
                $html[] = '<span class="error">'.$error.'</span><br />';
            }
        } else {
            $html[] = '<div class="element">';
        }
        $html[] = $element->__toString();
        $html[] = '</div>';
        $html[] = '</div>';
        return implode("", $html);
    }

    public static function _renderErrorsGroup(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2 $form)
    {
        $html = array();
        if (!empty($renderer->errors)) {
            $html[] = '<div class="errors">';
            if (($prefix = $renderer->getOption('errors_prefix')) && 
                !empty($prefix)) {
                $html[] = '<p>' . $prefix . '</p>';
            }
            $html[] = '<ul>';
            foreach ($renderer->errors as $error) {
                $html[] = '<li>' . $error . '</li>';
            }
            $html[] = '</ul>';
            if (($suffix = $renderer->getOption('errors_suffix')) && 
                !empty($suffix)) {
                $html[] = '<p>' . $suffix . '</p>';
            }
            $html[] = '</div>';
        }
        return implode("", $html);
    }

    public static function _renderHidden(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2_Element_InputHidden $hidden)
    {
        return '<div style="display: none;">'.$hidden->__toString().'</div>';
    }

    public static function _renderHiddenGroup(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2 $form)
    {
        if (empty($renderer->hidden)) {
            return '';
        }
        $html = array();
        foreach ($renderer->hidden as $hidden) {
            $html[] = $hidden->__toString();
        }
        return '<div style="display: none;">'.implode('', $html).'</div>';
    }

    public static function _renderRequiredNote(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2 $form)
    {
        if ($renderer->hasRequired && !$form->toggleFrozen(null)) {
            if (($note = $renderer->getOption('required_note')) && !empty($note)) {
                return '<div class="reqnote">'.$note.'</div>';
            }
        }
    }

    public static function _renderContainer(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2_Container $container)
    {
        $break  = HTML_Common2::getOption('linebreak');
        return implode($break, array_pop($renderer->html));
    }

    public static function _renderGroup(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2_Container_Group $group)
    {
        $break = HTML_Common2::getOption('linebreak');
        $html[] = '<div class="row">';
        $html[] = $renderer->renderLabel($group);
        $error = $group->getError();
        if ($error) {
            $html[] = '<div class="element group error">';
            if ($renderer->getOption('group_errors')) {
                $renderer->errors[] = $error;
            } else {
                $html[] = '<span class="error">'.$error.'</span><br />';
            }
        } else {
            $html[] = '<div class="element group">';
        }

        $separator = $group->getSeparator();
        $elements  = array_pop($renderer->html);
        if (!is_array($separator)) {
            $content = implode((string)$separator, $elements);
        } else {
            $content    = '';
            $cSeparator = count($separator);
            for ($i = 0, $count = count($elements); $i < $count; $i++) {
                $content .= (0 == $i? '': $separator[($i - 1) % $cSeparator]) .
                            $elements[$i];
            }
        }
        $html[] = $content;
        $html[] = '</div>';
        $html[] = '</div>';
        return implode($break, $html) . $break;
    }

    public static function _renderFieldset(HTML_QuickForm2_Renderer $renderer,
        HTML_QuickForm2_Container_Fieldset $fieldset)
    {
        $break = HTML_Common2::getOption('linebreak');
        $html[] = '<fieldset'.$fieldset->getAttributes(true).'>';
        $label = $fieldset->getLabel();
        if (!empty($label)) {
            $html[] = sprintf('<legend id="%s-legend">%s</legend>',
                $fieldset->getId(), $label);
        }
        $elements = array_pop($renderer->html);
        $html[] = implode($break, $elements);
        $html[] = '</fieldset>';
        return implode($break, $html) . $break;
    }

    public static function _renderLabel(HTML_QuickForm2_Renderer $renderer, 
        HTML_QuickForm2_Node $node)
    {
        $html = array();
        $label = $node->getLabel();
        if (!is_array($label)) {
            $label = array($label);
        }
        if ($node->isRequired()) {
            $renderer->hasRequired = true;
        }
        if (!empty($label[0])) {
            if ($node instanceof HTML_QuickForm2_Container) {
                $html[] = '<label class="element">';
            } else {
                $html[] = '<label for="'.$node->getId().'" class="element">';
            }
            if ($node->isRequired()) {
                $html[] = '<span class="required">* </span>';
            }
            $html[] = array_shift($label);
            $html[] = '</label>';
        }
        return implode('', $html);
    }

   /**
    * Renders a generic element
    *
    * @param    HTML_QuickForm2_Node    Element being rendered
    */
    public function renderElement(HTML_QuickForm2_Node $element)
    {
        $default = $this->callbacksForClass['html_quickform2_element'];
        $callback = $this->findCallback($element, $default);
        $res = call_user_func_array($callback, array($this, $element));
        $this->html[count($this->html) - 1][] = $res;
    }

    /**
     * Renders an element label
     *
     * @param    HTML_QuickForm2_Node    Element being rendered
     */
     public function renderLabel(HTML_QuickForm2_Node $element)
     {
         return call_user_func_array($this->labelCallback, array($this, $element));
     }

   /**
    * Renders a hidden element
    *
    * @param    HTML_QuickForm2_Node    Hidden element being rendered
    */
    public function renderHidden(HTML_QuickForm2_Node $element)
    {
        if ($this->getOption('group_hiddens')) {
            $this->hidden[] = $element;
        } else {
            $default = $this->callbacksForClass['html_quickform2_element_inputhidden'];
            $callback = $this->findCallback($element, $default);
            $this->html[count($this->html) - 1][] = call_user_func_array(
                $callback, array($this, $element));
        }
    }

   /**
    * Starts rendering a generic container, called before processing contained elements
    *
    * @param    HTML_QuickForm2_Node    Container being rendered
    */
    public function startContainer(HTML_QuickForm2_Node $container)
    {
        $this->html[]    = array();
        $this->groupId[] = false;
    }

   /**
    * Finishes rendering a generic container, called after processing contained elements
    *
    * @param    HTML_QuickForm2_Node    Container being rendered
    */
    public function finishContainer(HTML_QuickForm2_Node $container)
    {
        array_pop($this->groupId);
        $default = $this->callbacksForClass['html_quickform2_container'];
        $callback = $this->findCallback($container, $default);
        $res = call_user_func_array($callback, array($this, $container));
        $this->html[count($this->html) - 1][] = $res;
    }

   /**
    * Starts rendering a group, called before processing grouped elements
    *
    * @param    HTML_QuickForm2_Node    Group being rendered
    */
    public function startGroup(HTML_QuickForm2_Node $group)
    {
        $this->html[]    = array();
        $this->groupId[] = $group->getId();
    }

   /**
    * Finishes rendering a group, called after processing grouped elements
    *
    * @param    HTML_QuickForm2_Node    Group being rendered
    */
    public function finishGroup(HTML_QuickForm2_Node $group)
    {
        array_pop($this->groupId);
        $default = $this->callbacksForClass['html_quickform2_container_group'];
        $callback = $this->findCallback($group, $default);
        $res = call_user_func_array($callback, array($this, $group));
        $this->html[count($this->html) - 1][] = $res;
    }

   /**
    * Starts rendering a form, called before processing contained elements
    *
    * @param    HTML_QuickForm2_Node    Form being rendered
    */
    public function startForm(HTML_QuickForm2_Node $form)
    {
        $this->reset();
    }

   /**
    * Finishes rendering a form, called after processing contained elements
    *
    * @param    HTML_QuickForm2_Node    Form being rendered
    */
    public function finishForm(HTML_QuickForm2_Node $form)
    {
        $default = $this->callbacksForClass['html_quickform2'];
        $callback = $this->findCallback($form, $default);
        $this->html[0] = array(call_user_func_array(
                $callback, array($this, $form)));
    }

    private function _validateCallback($callback)
    {
        if (is_callable($callback) || is_null($callback)) {
            return true;
        }
        throw new HTML_QuickForm2_InvalidArgumentException(
                "Renderer callback is invalid"
                );
    }

    /**
    * Sets callback for rendering labels
    *
    * @param    mixed   PHP callback
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setLabelCallback($callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->labelCallback = $callback;
        }
        return $this;
    }

   /**
    * Sets callback for rendering hidden elements if option group_hiddens is true
    *
    * @param    mixed   PHP callback
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setHiddenGroupCallback($callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->hiddenGroupCallback = $callback;
        }
        return $this;
    }

   /**
    * Sets callback for rendering required note
    *
    * @param    mixed   PHP callback
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setRequiredNoteCallback($callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->requiredNoteCallback = $callback;
        }
        return $this;
    }

   /**
    * Sets callback for form elements that are instances of the given class
    *
    * When searching for a callback to use, renderer will check for callbacks
    * set for element's class and its parent classes, until found. Thus a more
    * specific callbacks will override a more generic one.
    *
    * @param    string  Class name
    * @param    mixed   Callback to use for elements of that class
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setCallbackForClass($className, $callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->callbacksForClass[strtolower($className)] = $callback;
        }
        return $this;
    }

   /**
    * Sets callback for form element with the given id
    *
    * If a callback is set for an element via this method, it will be used.
    * In the other case a generic callback set by {@link setCallbackForClass()}
    * or {@link setGroupedCallbackForClass()} will be used.
    *
    * @param    string  Element's id
    * @param    mixed   Callback to use for rendering of that element
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setCallbackForId($id, $callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->callbacksForId[$id] = $callback;
        }
        return $this;
    }

   /**
    * Sets callback for rendering validation errors
    *
    * This callback will be used if 'group_errors' option is set to true.
    *
    * @param    mixed   Callback for validation errors
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setErrorGroupCallback($callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->errorGroupCallback = $callback;
        }
        return $this;
    }

   /**
    * Sets grouped elements callbacks using group class
    *
    * Callbacks set via {@link setCallbackForClass()} will not be used for
    * grouped form elements. When searching for a callback to use, the renderer
    * will first consider callback set for a specific group id, then the
    * group callback set by group class.
    *
    * @param    string  Group class name
    * @param    string  Element class name
    * @param    mixed   Callback
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setElementCallbackForGroupClass($groupClass, $elementClass, $callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->elementCallbacksForGroupClass[strtolower($groupClass)][strtolower($elementClass)] = $callback;
        }
        return $this;
    }

   /**
    * Sets grouped elements callback using group id
    *
    * Callbacks set via {@link setCallbackForClass()} will not be used for
    * grouped form elements. When searching for a callback to use, the renderer
    * will first consider callback set for a specific group id, then the
    * group callbacks set by group class.
    *
    * @param    string  Group id
    * @param    string  Element class name
    * @param    mixed   Callback
    * @return   HTML_QuickForm2_Renderer_Callback
    */
    public function setElementCallbackForGroupId($groupId, $elementClass, $callback)
    {
        if ($this->_validateCallback($callback)) {
            $this->elementCallbacksForGroupId[$groupId][strtolower($elementClass)] = $callback;
        }
        return $this;
    }

   /**
    * Resets the accumulated data
    *
    * This method is called automatically by startForm() method, but should
    * be called manually before calling other rendering methods separately.
    *
    * @return HTML_QuickForm2_Renderer_Default
    */
    public function reset()
    {
        $this->html        = array(array());
        $this->hiddenHtml  = '';
        $this->errors      = array();
        $this->hidden      = array();
        $this->hasRequired = false;
        $this->groupId     = array();

        return $this;
    }

   /**
    * Returns generated HTML
    *
    * @return string
    */
    public function __toString()
    {
        return (isset($this->html[0][0])? $this->html[0][0]: '');
    }

   /**
    * Finds a proper callback for the element
    *
    * Callbacks are scanned in a predefined order. First, if a callback was
    * set for a specific element by id, it is returned, no matter if the
    * element belongs to a group. If the element does not belong to a group,
    * we try to match a callback using the element class.
    * But, if the element belongs to a group, callbacks are first looked up
    * using the containing group id, then using the containing group class.
    * When no callback is found, the provided default callback is returned.
    *
    * @param    HTML_QuickForm2_Node    Element being rendered
    * @param    mixed                   Default callback to use if not found
    * @return   mixed  Callback
    */
    public function findCallback(HTML_QuickForm2_Node $element, $default = null)
    {
        if (!empty($this->callbacksForId[$element->getId()])) {
            return $this->callbacksForId[$element->getId()];
        }
        $class          = strtolower(get_class($element));
        $groupId        = end($this->groupId);
        $elementClasses = array();
        do {
            if (empty($groupId) && !empty($this->callbacksForClass[$class])) {
                return $this->callbacksForClass[$class];
            }
            $elementClasses[$class] = true;
        } while ($class = strtolower(get_parent_class($class)));

        if (!empty($groupId)) {
            if (!empty($this->elementCallbacksForGroupId[$groupId])) {
                while (list($elClass) = each($elementClasses)) {
                    if (!empty($this->elementCallbacksForGroupId[$groupId][$elClass])) {
                        return $this->elementCallbacksForGroupId[$groupId][$elClass];
                    }
                }
            }

            $group = $element->getContainer();
            $grClass = strtolower(get_class($group));
            do {
                if (!empty($this->elementCallbacksForGroupClass[$grClass])) {
                    reset($elementClasses);
                    while (list($elClass) = each($elementClasses)) {
                        if (!empty($this->elementCallbacksForGroupClass[$grClass][$elClass])) {
                            return $this->elementCallbacksForGroupClass[$grClass][$elClass];
                        }
                    }
                }
            } while ($grClass = strtolower(get_parent_class($grClass)));
        }
        return $default;
    }
}
?>