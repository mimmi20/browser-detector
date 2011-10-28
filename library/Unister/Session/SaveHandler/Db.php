<?php
class Unister_Session_SaveHandler_Db implements Zend_Session_SaveHandler_Interface
{
    private $conn = null;
    private $params = array();


    public function __construct(Zend_Db_Adapter_Abstract $conn,array $params = array()) {
        $_params = array(
            'tablename'        => 'sessions',
            'idfield'        => 'session_id',
            'datafield'        => 'data',
            'expiresfield'    => 'expiry',
            'beginfield'    => 'begin',
            'uidfield'        => 'user_id',
            'max_lifetime'    =>    3600,
            'gc_max_lifetime'=>    3600,
        );
        if (is_array($params)) {
            $this->params = array_merge($_params,$params);
        } else {
            $this->params = $_params;
        }
        $this->conn = $conn;
    }
    /**
     * Open Session - retrieve resources
     *
     * @param string $save_path
     * @param string $name
     */
    public function open($save_path, $name)
    {return true;}

    /**
     * Close Session - free resources
     *
     */
    public function close()
    {return true;}

    /**
     * Read session data
     *
     * @param string $id
     */
    public function read($id){
        if (strlen($id) == 32){
            return
            $result =    $this    ->conn
                                ->fetchOne    (
                                        "SELECT ".$this->params['datafield']." FROM ".$this->params['tablename']." WHERE ".$this->params['idfield']." = :id AND ".$this->params['expiresfield']." > UNIX_TIMESTAMP() LIMIT 1;",
                                        array('id'    =>    $id)
                                                );
        }else{
            return null;
        }
    }
    /**
     * Write Session - commit data to resource
     *
     * @param string $id
     * @param mixed $data
     */
    public function write($id, $data){
        if (strlen($id) == 32){
            try {
                $this    ->conn
                        ->query("
                        INSERT INTO
                            ".$this->params['tablename']." ( ".$this->params['idfield'].", ".$this->params['datafield'].",".$this->params['expiresfield'].")
                        VALUES (:idi,:datai,:expiresi )
                        ON DUPLICATE KEY UPDATE
                        ".$this->params['datafield']." = :datau,
                        ".$this->params['expiresfield']." = :expiresu;",
                            array(
                            'idi'          => $id,
                            'datai'     => $data,
                            'expiresi'    => time() + $this->params['max_lifetime'],
                            'datau'        => $data,
                            'expiresu'    => time() + $this->params['max_lifetime']
                            )
                        );

            }
            catch(Exception $e) {
                @Zend_log::log($e->getMessage(), Zend_Log::LEVEL_SEVERE);
                return false;
            }
            return true;
        }else{
            return false;
        }
    }



    /**
     * Destroy Session - remove data from resource for
     * given session id
     *
     * @param string $id
     */
    public function destroy($id)
    {
        try {
            $this    ->conn
                    ->query(
                    "DELETE FROM ".$this->params['tablename']." WHERE ".$this->params['idfield']." = :id ;",
                        array(
                            'id'            =>    $id
                            )
                        );
        }
        catch(Exception $e) {
            @Zend_log::log($e->getMessage(), Zend_Log::LEVEL_SEVERE);
            return false;
        }
        return true;
    }
    /**
     * Garbage Collection - remove old session data older
     * than $maxlifetime (in seconds)
     *
     * @param int $maxlifetime
     */
    public function gc($maxlifetime)
    {
        return true;
    }
}
