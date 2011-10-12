<?php
declare(ENCODING = 'utf-8');
namespace HTML\Entities;
/* vim: set noai expandtab ts=4 st=4 sw=4: */

/**
 * Exception class used by HTML_Entities package.
 *
 * PHP versions 5
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  * Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  * Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *  * The names of its contributors may not be used to endorse or promote
 *    products derived from this software without specific prior written
 *    permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category HTML
 * @package  HTML_Entities
 * @author   Charles Brunet <charles.fmj@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.html BSD License
 * @version  CVS: $Id$
 * @link     http://pear.php.net/package/HTML_Entities
 */

require_once "PEAR/Exception.php";

/**
 * Exeption class for the HTML_Entities package.
 *
 * @category HTML
 * @package  HTML_Entities
 * @author   Charles Brunet <charles.fmj@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.html BSD License
 * @version  Release: 0.2.2
 * @link     http://pear.php.net/package/HTML_Entities
 */
class Exception extends \Exception
{
}