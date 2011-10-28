<?php
class App_Mail_Queue
{
    /**
     * memberid of acceptor
     *
     * @var integer
     */
    public $MemberTo_Id = null;

    /**
     * memberid of sender
     *
     * @var integer
     */
    public $MemberFrom_Id = null;

    /**
     * email category
     *
     * @var string
     */
    public $Category = null;

    /**
     * type of email category
     *
     * @var string
     */
    public $Type = null;

    /**
     * email subject
     *
     * @var string
     */
    public $Subject = null;

    /**
     * email textpart
     *
     * @var string
     */
    public $Text = null;

    /**
     * email htmlpart
     *
     * @var string
     */
    public $Html = null;

    /**
     * emailaddress of acceptor
     *
     * @var string
     */
    public $Email = array();

    /**
     * Name of sender
     *
     * @var string
     */
    public $FromName = null;

    /**
     * emailaddress of sender
     *
     * @var string
     */
    public $FromEmail = null;

    /**
     * reply emailaddress
     *
     * @var string
     */
    public $ReplyTo = null;

    /**
     * cc emailaddresses (max 5)
     *
     * @var array
     */
    public $CC = array();

    /**
     * bcc emailaddresses (max 5)
     *
     * @var array
     */
    public $BCC = array();

    /**
     * email priority
     *
     * @var integer
     */
    public $Prio = null;

    /**
     * email portal
     *
     * @var string
     */
    public $Portal = null;

    /**
     * attachment content
     *
     * @var string
     */
    public $Attachment = null;

    /**
     * what mailtype (instant, compendium)
     *
     * @var string
     */
    public $MailType = null;

    /**
     * mail charset settings
     *
     * @var string
     */
    public $Charset = 'iso-8859-1';

    /**
     * contains allowed mail-charsets
     *
     * @var array
     */
    public $allowCharsets = array('utf-8','iso-8859-1');

    /**
     * contains all required params
     *
     * after params check it contains the results of checked params, if a error is found
     *
     * @var array
     */
    public $CheckParams = array(
                                'MemberTo_Id'   => '',
                                'MemberFrom_Id' => '',
                                'Category'      => '',
                                'Type'          => '',
                                'Subject'       => '',
                                'Text'          => '',
                                'Email'         => '',
                                'Portal'        => '',
                                'MailType'      => '',
                            );

    /**
     * ZEND Validator Object
     *
     * @var object
     */
    public $validator;

    public function __construct()
    {
    }

    /**
     * returns mailqueue model object
     *
     * @return unknown
     */
    protected function _getMailQueueModel()
    {
        return new Model_MailQueue();
    }

    /**
     * @param insert mail in mailqueue $Params
     * @return array
     */
    public function sendMail($Params)
    {
        $this->setEmailProperties($Params);
        if(count($this->CheckParams) == 0){
            $this->CheckParams['Insert'] = $this->_getMailQueueModel()->MailQueueInsert($this);
        }
        return $this->CheckParams;
    }

    /**
     * accept email-properties and proof validation
     *
     * @param array &$Params (
     *                          'MemberTo_Id'   -> required
     *                          'MemberFrom_Id' -> required
     *                          'Category'      -> required
     *                          'Type'          -> required
     *                          'Subject'       -> required
     *                          'Text'          -> required
     *                          'Html'
     *                          'Email'         -> required
     *                          'FromName'
     *                          'FromEmail'
     *                          'ReplyTo'
     *                          'CC'
     *                          'BCC'
     *                          'Prio'
     *                          'Portal'        -> required
     *                          'MailType'      -> required
     *                          'Attachment'
     *                      )
     */
    protected function setEmailProperties(&$Params)
    {
        /**
         * merge input params and required params
         */
        $Params = array_merge($this->CheckParams, $Params);
        /**
         * clean checkparams array, to save possible errors
         */
        $this->CheckParams = array();
        foreach($Params as $param=>$value){
            $this->validator = new Zend_Validate();
            $checkfunction = "check".$param;
            $this->$checkfunction($value);
            $this->$param = $value;
        }
    }

    /**
     * check attachment, no check
     *
     * @param array &$value
     */
    protected function checkAttachment(&$value)
    {
        return;
    }

    /**
     * check mailtype
     *
     * @param string &$value
     */
    protected function checkMailType(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_NotEmpty(),true);
        if(!$this->validator->isValid($value)){
            $this->CheckParams['MailType'] = $this->validator->getMessages();
        }else{
            $value = strtolower($value);
            if($value != 'instant' && $value != 'compendium'){
                $this->CheckParams['MailType'] = "MailType is not 'instant' OR 'compendium'";
            }
        }
        return;
    }

    /**
     * check portal
     *
     * @param string &$value
     */
    protected function checkPortal(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_NotEmpty(),true);
        if(!$this->validator->isValid($value)){
            $this->CheckParams['Portal'] = $this->validator->getMessages();
        }
        $value = strtolower($value);
        return;
    }

    /**
     * check prio
     *
     * @param integer &$value
     */
    protected function checkPrio(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_Int(),true);
        if($this->validator->isValid($value)){
            $value = 1;
        }else{
            $value = 0;
        }
        return;
    }

    /**
     * check BCC
     *
     * @param array &$value
     */
    protected function checkBCC(&$value)
    {
        $tmp = array();
        if(is_array($value) && count($value) > 0){
            $this->validator->addValidator(new Zend_Validate_EmailAddress(),true);
            $bccs = min(5,count($value));
            foreach($value as $email){
                if($bccs == 0){
                    break;
                }
                if(!$this->validator->isValid($email)){
                    $this->CheckParams['BCC'] = $this->validator->getMessages();
                    return;
                }
                $tmp[] = $email;
                $bccs--;
            }
        }
        $value = $tmp;
        return;
    }

    /**
     * check CC
     *
     * @param array &$value
     */
    protected function checkCC(&$value)
    {
        $tmp = array();
        if(is_array($value) && count($value) > 0){
            $this->validator->addValidator(new Zend_Validate_EmailAddress(),true);
            $ccs = min(5,count($value));
            foreach($value as $email){
                if($ccs == 0){
                    break;
                }
                if(!$this->validator->isValid($email)){
                    $this->CheckParams['CC'] = $this->validator->getMessages();
                    return;
                }
                $tmp[] = $email;
                $ccs--;
            }
        }
        $value = $tmp;
        return;
    }

    /**
     * check ReplyTo
     *
     * @param string &$value
     */
    protected function checkReplyTo(&$value)
    {
        if(strlen($value) > 0){
            $this->validator->addValidator(new Zend_Validate_EmailAddress(),true);
            if(!$this->validator->isValid($value)){
                $this->CheckParams['ReplyTo'] = $this->validator->getMessages();
            }
        }
        return;
    }

    /**
     * check FromEmail
     *
     * @param string &$value
     */
    protected function checkFromEmail(&$value)
    {
        if(strlen($value) > 0){
            $this->validator->addValidator(new Zend_Validate_EmailAddress(),true);
            if(!$this->validator->isValid($value)){
                $this->CheckParams['FromEmail'] = $this->validator->getMessages();
            }
        }
        return;
    }

    /**
     * check FromName
     *
     * @param string &$value
     */
    protected function checkFromName(&$value)
    {
        return;
    }

    /**
     * check Email
     *
     * @param string &$value
     */
    protected function checkEmail(&$value)
    {
        $tmp = array();
        $this->validator->addValidator(new Zend_Validate_NotEmpty()     ,true);
        $this->validator->addValidator(new Zend_Validate_EmailAddress() ,true);
        if(!is_array($value)){
            $value = array(0=>$value);
        }
        $to = min(5,count($value));
        foreach ($value as $email){
            if($to == 0){
                break;
            }
            if(!$this->validator->isValid($email)){
                $this->CheckParams['Email'] = $this->validator->getMessages();
                return;
            }
            $tmp[] = $email;
            $to--;
        }
        $value = $tmp;
        return;
    }

    /**
     * check html
     *
     * @param string &$value
     */
    protected function checkHtml(&$value)
    {
        return;
    }

    /**
     * check text
     *
     * @param string &$value
     */
    protected function checkText(&$value)
    {
        return;
    }

    /**
     * check subject
     *
     * @param string &$value
     */
    protected function checkSubject(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_NotEmpty(),true);
        if(!$this->validator->isValid($value)){
            $this->CheckParams['Subject'] = $this->validator->getMessages();
        }
        return;
    }

    /**
     * check type
     *
     * @param string &$value
     */
    protected function checkType(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_NotEmpty(),true);
        if(!$this->validator->isValid($value)){
            $this->CheckParams['Type'] = $this->validator->getMessages();
        }else{
            $value = strtoupper($value);
        }
        return;
    }

    /**
     * check category
     *
     * @param string &$value
     */
    protected function checkCategory(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_NotEmpty(),true);
        if(!$this->validator->isValid($value)){
            $this->CheckParams['Category'] = $this->validator->getMessages();
        }else{
            $value = strtoupper($value);
        }
        return;
    }

    /**
     * check MemberTo_Id
     *
     * @param integer &$value
     */
    protected function checkMemberTo_Id(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_NotEmpty(),true);
        $this->validator->addValidator(new Zend_Validate_Int(),true);
        if(!$this->validator->isValid($value)){
            $this->CheckParams['MemberTo_Id'] = $this->validator->getMessages();
        }
        return;
    }

    /**
     * check MemberFrom_Id
     *
     * @param integer &$value
     */
    protected function checkMemberFrom_Id(&$value)
    {
        $this->validator->addValidator(new Zend_Validate_NotEmpty(),true);
        $this->validator->addValidator(new Zend_Validate_Int(),true);
        if(!$this->validator->isValid($value)){
            $this->CheckParams['MemberFrom_Id'] = $this->validator->getMessages();
        }
        return;
    }

    /**
     * check charset settings
     *
     * @param string &$value
     */
    protected function checkCharset(&$value)
    {
        if(!in_array($value,$this->allowCharsets)){
            $this->CheckParams['Charset'] = 'allowed charsets ('.implode(", ",$this->allowCharsets).')';
        }
        return;
    }

    /**
     * check text
     *
     * @param string &$value
     */
    protected function checkInsert(&$value)
    {
        return;
    }

    /**
     * get file infos, which are important to create an attachment
     *
     * @param string $pathtofile
     * @return array
     */
    public function getAttachmentParamsFromFile($pathtofile)
    {
        return array(
                        'AttachmentContent' => file_get_contents($pathtofile),
                        'AttachmentType'    => mime_content_type($pathtofile),
                        'AttachmentFile'    => substr(strrchr($pathtofile,"/"),1),
                    );
    }

    /**
     * save an attachment
     *
     * @param array $Attachments
     * @return boolean
     */
    public function saveAttachments($Attachments)
    {
        $return = array();
        return $this->_getMailQueueModel()->MailAttachmentInsert($Attachments);
    }
}