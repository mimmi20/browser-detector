<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Log\Writer;

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * Class used for writing log messages to email via \Zend\Mail\Mail.
 *
 * Allows for emailing log messages at and above a certain level via a
 * \Zend\Mail\Mail object.  Note that this class only sends the email upon
 * completion, so any log entries accumulated are sent in a single email.
 *
 * @category   Zend
 * @package    Zend_Log
 * @subpackage Writer
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */
class Mail extends \Zend\Log\Writer\Mail
{
    /**
     * Array of formatted events to include in message body.
     *
     * @var array
     */
    protected $_eventsToMail = array();

    /**
     * Array of formatted lines for use in an HTML email body; these events
     * are formatted with an optional formatter if the caller is using
     * \Zend\Layout\Layout.
     *
     * @var array
     */
    protected $_layoutEventsToMail = array();

    /**
     * \Zend\Mail\Mail instance to use
     *
     * @var \Zend\Mail\Mail
     */
    protected $_mail;

    /**
     * \Zend\Layout\Layout instance to use; optional.
     *
     * @var \Zend\Layout\Layout
     */
    protected $_layout;

    /**
     * Optional formatter for use when rendering with \Zend\Layout\Layout.
     *
     * @var Zend_Log_Formatter_Interface
     */
    protected $_layoutFormatter;

    /**
     * Array keeping track of the number of entries per priority level.
     *
     * @var array
     */
    protected $_numEntriesPerPriority = array();

    /**
     * Subject prepend text.
     *
     * Can only be used of the \Zend\Mail\Mail object has not already had its
     * subject line set.  Using this will cause the subject to have the entry
     * counts per-priority level appended to it.
     *
     * @var string|null
     */
    protected $_subjectPrependText;

    /**
     * MethodMap for \Zend\Mail\Mail's headers
     *
     * @var array
     */
    protected static $_methodMapHeaders = array(
        'from' => 'setFrom',
        'to'   => 'addTo',
        'cc'   => 'addCc',
        'bcc'  => 'addBcc',
    );

    /**
     * @var KreditCore_Class_Mail
     */
    private $_mailer = null;

    /**
     * Class constructor.
     *
     * Constructs the mail writer; requires a \Zend\Mail\Mail instance, and takes an
     * optional \Zend\Layout\Layout instance.  If \Zend\Layout\Layout is being used,
     * $this->_layout->events will be set for use in the layout template.
     *
     * @param  \Zend\Mail\Mail     $mail   Mail instance
     * @param  \Zend\Layout\Layout $layout Layout instance; optional
     * @return void
     */
    public function __construct(\Zend\Mail\Mail $mail, \Zend\Layout\Layout $layout = null)
    {
        parent::__construct($mail, $layout);

        $this->_mailer = new \AppCore\Mail();
    }

    /**
     * Create a new instance of Zend_Log_Writer_Mail
     *
     * @param  array|Zend_Config $config
     * @return Zend_Log_Writer_Mail
     */
    static public function factory($config)
    {
        $config = self::_parseConfig($config);
        $mail = self::_constructMailFromConfig($config);
        $writer = new self($mail);

        if (isset($config['layout']) || isset($config['layoutOptions'])) {
            $writer->setLayout($config);
        }
        if (isset($config['layoutFormatter'])) {
            $layoutFormatter = new $config['layoutFormatter'];
            $writer->setLayoutFormatter($layoutFormatter);
        }
        if (isset($config['subjectPrependText'])) {
            $writer->setSubjectPrependText($config['subjectPrependText']);
        }

        return $writer;
    }

    /**
     * Set the layout
     *
     * @param \Zend\Layout\Layout|array $layout
     * @return Zend_Log_Writer_Mail
     * @throws \Zend\Log\Exception
     */
    public function setLayout($layout)
    {
        if (is_array($layout)) {
            $layout = $this->_constructLayoutFromConfig($layout);
        }

        if (!$layout instanceof \Zend\Layout\Layout) {
            throw new \Zend\Log\Exception(
                'Mail must be an instance of \\Zend\\Layout\\Layout or an array'
            );
        }
        $this->_layout = $layout;

        return $this;
    }

    /**
     * Construct a \Zend\Mail\Mail instance based on a configuration array
     *
     * @param array $config
     * @return \Zend\Mail\Mail
     * @throws \Zend\Log\Exception
     */
    protected static function _constructMailFromConfig(array $config)
    {
        $mailClass = '\\Zend\\Mail\\Mail';
        if (isset($config['mail'])) {
            $mailClass = $config['mail'];
        }

        if (!array_key_exists('charset', $config)) {
            $config['charset'] = null;
        }
        $mail = new $mailClass($config['charset']);
        if (!$mail instanceof \Zend\Mail\Mail) {
            throw new \Zend\Log\Exception($mail . 'must extend \\Zend\\Mail\\Mail');
        }

        if (isset($config['subject'])) {
            $mail->setSubject($config['subject']);
        }

        $headerAddresses = array_intersect_key($config, self::$_methodMapHeaders);
        if (count($headerAddresses)) {
            foreach ($headerAddresses as $header => $address) {
                $method = self::$_methodMapHeaders[$header];
                if (is_array($address) && isset($address['name'])
                    && !is_numeric($address['name'])
                ) {
                    $params = array(
                        $address['email'],
                        $address['name']
                    );
                } else if (is_array($address) && isset($address['email'])) {
                    $params = array($address['email']);
                } else {
                    $params = array($address);
                }
                call_user_func_array(array($mail, $method), $params);
            }
        }

        return $mail;
    }

    /**
     * Construct a \Zend\Layout\Layout instance based on a configuration array
     *
     * @param array $config
     * @return \Zend\Layout\Layout
     * @throws \Zend\Log\Exception
     */
    protected function _constructLayoutFromConfig(array $config)
    {
        $config = array_merge(array(
            'layout' => '\\Zend\\Layout\\Layout',
            'layoutOptions' => null
        ), $config);

        $layoutClass = $config['layout'];
        $layout = new $layoutClass($config['layoutOptions']);
        if (!$layout instanceof \Zend\Layout\Layout) {
            throw new \Zend\Log\Exception(
                $layout . 'must extend \\Zend\\Layout\\Layout'
            );
        }

        return $layout;
    }

    /**
     * Places event line into array of lines to be used as message body.
     *
     * Handles the formatting of both plaintext entries, as well as those
     * rendered with \Zend\Layout\Layout.
     *
     * @param  array $event Event data
     * @return void
     */
    protected function _write($event)
    {
        // Track the number of entries per priority level.
        if (!isset($this->_numEntriesPerPriority[$event['priorityName']])) {
            $this->_numEntriesPerPriority[$event['priorityName']] = 1;
        } else {
            $this->_numEntriesPerPriority[$event['priorityName']]++;
        }

        $formattedEvent = $this->_formatter->format($event);

        // All plaintext events are to use the standard formatter.
        $this->_eventsToMail[] = $formattedEvent;

        // If we have a \Zend\Layout\Layout instance, use a specific formatter for the
        // layout if one exists.  Otherwise, just use the event with its
        // default format.
        if ($this->_layout) {
            if ($this->_layoutFormatter) {
                $this->_layoutEventsToMail[] =
                    $this->_layoutFormatter->format($event);
            } else {
                $this->_layoutEventsToMail[] = $formattedEvent;
            }
        }
    }

    /**
     * Gets instance of \Zend\Log\Formatter used for formatting a
     * message using \Zend\Layout\Layout, if applicable.
     *
     * @return \Zend\Log\Formatter|null The formatter, or null.
     */
    public function getLayoutFormatter()
    {
        return $this->_layoutFormatter;
    }

    /**
     * Sets a specific formatter for use with \Zend\Layout\Layout events.
     *
     * Allows use of a second formatter on lines that will be rendered with
     * \Zend\Layout\Layout.  In the event that \Zend\Layout\Layout is not being used, this
     * formatter cannot be set, so an exception will be thrown.
     *
     * @param  \Zend\Log\Formatter $formatter
     * @return \AppCore\Log\Writer\Mail
     * @throws \Zend\Log\Exception
     */
    public function setLayoutFormatter(\Zend\Log\Formatter $formatter)
    {
        if (!$this->_layout) {
            throw new \Zend\Log\Exception(
                'cannot set formatter for layout; ' .
                'a \Zend\Layout\Layout instance is not in use');
        }

        $this->_layoutFormatter = $formatter;
        return $this;
    }

    /**
     * Allows caller to have the mail subject dynamically set to contain the
     * entry counts per-priority level.
     *
     * Sets the text for use in the subject, with entry counts per-priority
     * level appended to the end.  Since a \Zend\Mail\Mail subject can only be set
     * once, this method cannot be used if the \Zend\Mail\Mail object already has a
     * subject set.
     *
     * @param  string $subject Subject prepend text.
     * @return \AppCore\Log\Writer\Mail
     * @throws \Zend\Log\Exception
     */
    public function setSubjectPrependText($subject)
    {
        $this->_subjectPrependText = (string) $subject;
        return $this;
    }

    /**
     * Sends mail to recipient(s) if log entries are present.  Note that both
     * plaintext and HTML portions of email are handled here.
     *
     * @return void
     */
    public function shutdown()
    {
        // If there are events to mail, use them as message body.  Otherwise,
        // there is no mail to be sent.
        if (empty($this->_eventsToMail)) {
            return;
        }

        if ($this->_subjectPrependText !== null) {
            // Tack on the summary of entries per-priority to the subject
            // line and set it on the \Zend\Mail\Mail object.
            $numEntries = $this->_getFormattedNumEntriesPerPriority();
            $this->_mailer->setSubject(
                $this->_subjectPrependText . ' (' . $numEntries . ')'
            );
        }


        // Always provide events to mail as plaintext.
        $this->_mailer->setText(implode('', $this->_eventsToMail));

        // If a \Zend\Layout\Layout instance is being used, set its "events"
        // value to the lines formatted for use with the layout.
        if ($this->_layout) {
            // Set the required "messages" value for the layout.  Here we
            // are assuming that the layout is for use with HTML.
            $this->_layout->events =
                implode('', $this->_layoutEventsToMail);

            // If an exception occurs during rendering, convert it to a notice
            // so we can avoid an exception thrown without a stack frame.
            try {
                $this->_mailer->setHtml($this->_layout->render());
            } catch (\Exception $e) {
                trigger_error(
                    'exception occurred when rendering layout; ' .
                    'unable to set html body for message; ' .
                    'message = ' . $e->getMessage() . '; ' .
                    'code = ' . $e->getCode() . '; ' .
                    'exception class = ' . get_class($e),
                    E_USER_NOTICE);
            }
        }

        // Finally, send the mail.  If an exception occurs, convert it into a
        // warning-level message so we can avoid an exception thrown without a
        // stack frame.
        try {
            $this->_mailer->send();
        } catch (\Exception $e) {
            trigger_error(
                'unable to send log entries via email; ' .
                'message = ' . $e->getMessage() . '}; ' .
                'code = ' . $e->getCode() . '}; ' .
                'exception class = ' . get_class($e),
                E_USER_WARNING);
        }
    }

    /**
     * Gets a string of number of entries per-priority level that occurred, or
     * an emptry string if none occurred.
     *
     * @return string
     */
    protected function _getFormattedNumEntriesPerPriority()
    {
        $strings = array();

        foreach ($this->_numEntriesPerPriority as $priority => $numEntries) {
            $strings[] = $priority . '=' . $numEntries;
        }

        return implode(', ', $strings);
    }

    /**
     * Sets From-header and sender of the message
     *
     * @param  string    $email
     * @param  string    $name
     * @return \Zend\Mail\Mail Provides fluent interface
     * @throws \Zend\Mail\Mail_Exception if called subsequent times
     */
    public function setFrom($email, $name = null)
    {
        $this->_mailer->setFromMail($email);

        if (null !== $name) {
            $this->_mailer->setFromName($name);
        }

        return $this;
    }

    /**
     * Adds To-header and recipient, $email can be an array, or a single string address
     *
     * @param  string|array $email
     * @param  string $name
     * @return \Zend\Mail\Mail Provides fluent interface
     */
    public function addTo($email, $name = '')
    {
        $this->_mailer->setEmail($email);

        return $this;
    }
}
