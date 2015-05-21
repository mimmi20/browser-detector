<?php
/**
 * Copyright (c) 2012-2014, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 * @package   BrowserDetector
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2014 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

return [
    [
        'rule' => '(Edge)',
        'name' => 'Edge'
    ],
    [
        'rule' => '(Presto|Opera)',
        'name' => 'Presto'
    ],
    [
        'rule' => '(Trident|like Gecko)',
        'name' => 'Trident'
    ],
    [
        'rule' => '(U2)',
        'name' => 'U2'
    ],
    [
        'rule' => '(U3)',
        'name' => 'U3'
    ],
    [
        'rule' => '(T5)',
        'name' => 'T5'
    ],
    [
        'rule' => '(Chrome)',
        'name' => 'Blink'
    ],
    [
        'rule' => '(AppleWebKit|WebKit|CFNetwork|Safari|Kindle)',
        'name' => 'WebKit'
    ],
    [
        'rule' => '(KHTML|Konqueror)',
        'name' => 'KHTML'
    ],
    [
        'rule' => '(Gecko|Firefox)',
        'name' => 'Gecko'
    ],
    [
        'rule' => '(NetFront\/|NF\/|NetFrontLifeBrowser\/|NF3)',
        'name' => 'NetFront'
    ],
    [
        'rule' => '(BlackBerry)',
        'name' => 'BlackBerry'
    ],
    [
        'rule' => '(Teleca|Obigo)',
        'name' => 'Teleca'
    ],
    [
        'rule' => '(MSIE)',
        'name' => 'Tasman'
    ],
    [
        'rule' => '(.*)',
        'name' => 'UnknownEngine'
    ]
];
