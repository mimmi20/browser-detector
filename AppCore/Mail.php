<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore;

/**
 * sends email using the mailqueue
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * sends email using the mailqueue
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Mail
{
    private $_memberToId = 5180;
    private $_memberFromId = 7000;
    private $_category = 'GELD';
    private $_type = 'MAIL';
    private $_subject;
    private $_text;
    private $_html;
    private $_email;
    private $_fromEmail = 'service';
    private $_fromName;
    private $_replyTo;
    private $_cc;
    private $_bcc;
    private $_modSend = 5;
    private $_prio = 2;
    private $_portal = 'geld.de';
    private $_charset = 'iso-8859-1';

    /**
     * Set MemberTo_Id
     * is set by default to 5180
     *
     * @param string Member Id
     *
     * @return KreditCore_Class_Mail
     */
    public function setMemberToId($vId = 5180)
    {
        $this->_memberToId = (int) $vId;
        return $this;
    }

     /**
     * Set MemberFrom_Id
     *
     * @param string Member Id
     *
     * @return KreditCore_Class_Mail
     */
    public function setMemberFromId($vId = 7000)
    {
        $this->_memberFromId = (int) $vId;
        return $this;
    }

    /**
     * Set Category
     * Default GELD
     *
     * @param string
     * @return KreditCore_Class_Mail
     */
    public function setCategory($vCategory = 'GELD')
    {
        $this->_category = $vCategory;
        return $this;
    }

    /**
     * Set the Type
     * Default Mail
     *
     * @param String MimeType
     *
     * @return KreditCore_Class_Mail
     */
    public function setType($vType = 'MAIL')
    {
        $this->_type = $vType;
        return $this;
    }

    /**
     * Set Subject/Betreff
     * on the Mail
     *
     * @param String $vSubject
     * @return KreditCore_Class_Mail
     */
    public function setSubject($vSubject)
    {
        $this->_subject = $vSubject;
        return $this;
    }

    /**
     * Set the Mailcontent,
     * only Text not html
     *
     * @param String Text
     *
     * @return KreditCore_Class_Mail
     */
    public function setText($vText)
    {
        $this->_text = $vText;
        return $this;
    }

    /**
     * Set Html content of this mail
     *
     *
     * @param String $vHtml
     * @return KreditCore_Class_Mail
     */
    public function setHtml($vHtml)
    {
        $this->_html = $vHtml;
        return $this;
    }

    /**
     * Set receiver of the Mail
     * @param String Emailadress
     *
     * @return KreditCore_Class_Mail
     */
    public function setEmail($vMail)
    {
        if (is_array($vMail)) {
            $vMail = implode(';', $vMail);
        }

        $this->_email = $vMail;
        return $this;
    }

    /**
     * Set the sender of the Email adress
     *
     * @param string Emailadress
     *
     * @return KreditCore_Class_Mail
     */
    public function setFromMail($vFrom)
    {
        if (is_array($vFrom)) {
            $vFrom = implode(';', $vFrom);
        }

        $this->_fromEmail = $vFrom;
        return $this;
    }


     /**
     * Set the name of the sender
     *
     * @param string name
     *
     * @return KreditCore_Class_Mail
     */
    public function setFromName($vFromName)
    {
        $this->_fromName = $vFromName;
        return $this;
    }

    /**
     * Set the receiver mail for mailreply
     *
     * @param string mailadress
     *
     * @return KreditCore_Class_Mail
     */
    public function setReplyTo($vReply)
    {
        $this->_replyTo = $vReply;
        return $this;
    }


    /**
     * Set mail copy receiver(s)
     * receivers are seperated by a ';'
     *
     * @param string $vCC Mailadress
     * @return KreditCore_Class_Mail
     */
    public function setCC($vCC)
    {
        if (is_array($vCC)) {
            $vCC = implode(';', $vCC);
        }

        $this->_cc = $vCC;
        return $this;
    }

        /**
     * Set mail blindcopy receiver(s)
     * receivers are seperated by a ';'
     *
     * @param string $vBCC Mailadress
     * @return KreditCore_Class_Mail
     */
    public function setBCC($vBCC)
    {
        if (is_array($vBCC)) {
            $vBCC = implode(';', $vBCC);
        }

        $this->_bcc = $vBCC;
        return $this;
    }

    /**
     * Set the Mod10 param
     * is by default set to 5
     *
     * @param int 1-10
     *
     * @return KreditCore_Class_Mail
     */
    public function setMod10($vMod)
    {
        $this->_modSend = (int) $vMod;
        return $this;
    }

     /**
     * Set the priority
     * is by default on 2
     *
     * @param int priority
     *
     * @return KreditCore_Class_Mail
     */
    public function setPrio($vPrio)
    {
        $this->_prio = (int) $vPrio;
        return $this;
    }


    /**
     * Set the portal
     *
     * Default geld.de
     *
     * @param string
     * return KreditCore_Class_Mail
     */
    public function setPortal($vPortal = 'geld.de')
    {
        $this->_replyTo = $vPortal;
        return $this;
    }


    /**
     * Set Charset
     *
     * default on UTF-8
     *
     * @param string Charset
     *
     * @return KreditCore_Class_Mail
     *
     */
    public function setCharset($vCharset)
    {
        $this->_charset = $vCharset;
        return $this;
    }


    /**
     * Send the Mailobject into the Mailqueue
     *
     * It´s not controlled if the params are set proberly
     *
     * @return Boolean 'false' if an error occurs, 'true' otherwise
     */
    public function send()
    {
        if (!Zend_Registry::isRegistered('_config')) {
            /*
             * _config is not defined at the moment
             * the error occured before finishing bootstrapping
             */
            return false;
        }

        $config = Zend_Registry::get('_config');

        //check, if Email is enabled
        //-> do not try to send, if disabled (mostly it raises errors then)
        if (!isset($config->newmaildb->enabled)
            || !$config->newmaildb->enabled
        ) {
            return false;
        }

        //serialize the mail headers
        if (!is_array($email)) {
            $email = array($email);
        }

        $logger = \Zend\Registry::get('log');

        /**
         * instance DB Object
         */
        //$mailDbParams = \Zend\Registry::get('_config')->newmaildb->toArray();
        //$mailDbParams['profiler'] = false;//('1' == $mailDbParams['profiler']);

        try {
            $db = \Zend\Db\Db::factory($mailDbParams['type'], $mailDbParams);
        } catch (PDOException $e) {
            $logger->err($e);

            return false;
        }

        $sql = 'INSERT INTO
            mail_compendium (MemberTo_Id,MemberFrom_Id,Category,Type,Subject,
            Text,Html,Email,FromEmail,FromName,ReplyTo,CC,BCC,Mod10,Prio,Portal,
            Charset)
        VALUES (
            \'' . $this->_memberToId . '\',
            \'' . $this->_memberFromId . '\',
            \'' . $this->_category . '\',
            \'' . $this->_type . '\',
            \'' . $this->_subject . '\',
            \'' . addslashes($this->_text) . '\',
            \'' . addslashes($this->_html) . '\',
            \'' . $this->_email . '\',
            \'' . $this->_fromEmail . '\',
            \'' . $this->_fromName . '\',
            \'' . $this->_replyTo . '\',
            \'' . $this->_cc . '\',
            \'' . $this->_bcc . '\',
              ' . $this->_modSend . ',
              ' . $this->_prio . ',
            \'' . $this->_portal . '\',
            \'' . $this->_charset . '\')';

        try {
            $result = $db->exec($sql);

            if (!$result) {
                return false;
            }
        } catch (Exception $e) {
            $logger->err($e);

            return false;
        }

        return true;
    }
}