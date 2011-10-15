<?php
/**
 * Class for adding inline javascript to the form
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
 * @version    SVN: $Id: Script.php 311435 2011-05-26 10:30:06Z avb $
 * @link       http://pear.php.net/package/HTML_QuickForm2
 */

/**
 * Class for static elements that only contain text or markup
 */
require_once 'HTML/QuickForm2/Element/Static.php';

/**
 * Class for adding inline javascript to the form
 *
 * Unlike scripts added to {@link HTML_QuickForm2_JavascriptBuilder} this is
 * intended for "volatile" scripts that can not be put into the separate .js
 * files and should always be rebuilt when the form is rendered. A good
 * example is setting the default values and corresponding visible options for
 * {@link HTML_QuickForm2_Element_Hierselect}
 *
 * @category   HTML
 * @package    HTML_QuickForm2
 * @author     Alexey Borzov <avb@php.net>
 * @author     Bertrand Mansion <golgote@mamasam.com>
 * @version    Release: 0.6.1
 */
class HTML_QuickForm2_Element_Script extends HTML_QuickForm2_Element_Static
{
    public function getType()
    {
        return 'script';
    }

   /**
    * Returns the element's content wrapped in <script></script> tags
    *
    * @return string
    */
    public function __toString()
    {
        $cr = HTML_Common2::getOption('linebreak');
        return "<script type=\"text/javascript\">{$cr}//<![CDATA[{$cr}"
               . $this->data['content'] . "{$cr}//]]>{$cr}</script>";
    }

   /**
    * Renders the element as the "hidden" one
    *
    * @param    HTML_QuickForm2_Renderer    Renderer instance
    * @return   HTML_QuickForm2_Renderer
    * @see      HTML_QuickForm2_Renderer::renderHidden()
    */
    public function render(HTML_QuickForm2_Renderer $renderer)
    {
        $renderer->renderHidden($this);
    }
}
?>
