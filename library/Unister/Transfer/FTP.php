<?php

/**
 * Klasse für den Dateitransfer mittels FTP
 * 
 * @author Ruediger Matz <ruediger.matz@unister-gmbh.de>
 * 
 */

class Unister_Transfer_FTP
{
    protected $ftp_server;
    protected $ftp_user_name;
    protected $ftp_user_pass;
    protected $destination_file;
    protected $source_file;
    
        
    /**
     * magische Funktion gibt eine Uebersicht des Objektes aus
     */
    protected function __toString() 
    {
        echo '<pre>';
        echo 'Klassenname: Unister_Transfer_FTP' . chr(10);
        echo 'FTP-Server:' . $this->ftp_server . chr(10);
        echo 'FTP-Username:' . $this->ftp_user_name . chr(10);
        echo 'FTP-Password:' . $this->ftp_user_pass . chr(10);
        echo 'FTP-Destination:' . $this->destination_file . chr(10);
        echo 'FTP-Source:' . $this->source_file . chr(10);
        echo '...........................................................' . chr(10);
        echo '</pre>';
    }
    
    
    protected function FTP_Transfer()
    {
        // Verbindungsaufbau
        $conn_id = ftp_connect($this->ftp_server);

        // Login mit Username und Passwort
        $login_result = ftp_login($conn_id, $this->ftp_user_name, $this->ftp_user_pass);

        // passives FTP benutzen
        ftp_pasv($conn_id,1);

        if(!$login_result)
        {
            return false;
        }        
            else
        {
            $upload = ftp_put($conn_id, $this->destination_file, $this->source_file, FTP_BINARY);

            // Upload überprüfen
            if (!$upload) {
                    ftp_close($conn_id); 
                    return false;
                } 
                    else 
                {
                    ftp_close($conn_id); 
                    return true;
                }                    
        }
    }
}

?>
