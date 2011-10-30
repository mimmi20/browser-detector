<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2006-2007 Thomas Mueller <thomas.mueller@telemotive.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Plugin 'Telemotive Classes' for the 'tm_classes' extension.
 *
 * PHP version 5
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        PFileTree.inc.php
 * @created        Feb 22, 2007
 * @version        2.2
 * @author        Ciprian Voicu  <pictoru@autoportret.ro>
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 2.2
 * @see            http://www.phpclasses.org/browse/package/3744.html
 */

// {{{ Initialisation

set_time_limit(300);

// }}}
// {{{ GLOBALS

// changed by Thomas Mueller - Start
define('PTree_SERVER_NAME',        $_SERVER['HOST']);    //$_SERVER['SERVER_NAME']);
define('PTree_HTTP',            'http');            //($_SERVER['HTTPS'])?"https":"http");
// changed by Thomas Mueller - End
define('PTree_ALLOWED_KEYS',    'mtime|mdate|atime|adate|fullpath|dirname|basename|url|size|ext|perms|children|type|filename');

// }}}
// {{{ PFileTree

/**
 * Filetree Functions
 *
 * Retrieve the list of files and folders and their info from a specified location
 * and return it as array of arrays or as array of objects 
 *
 * @category    misc
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        PFileTree.inc.php
 * @author        Ciprian Voicu  <pictoru@autoportret.ro>
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 2.2
 */
class PFileTree
{
    // {{{ PFileTree
    
    /**
     * Function PFileTree
     * 
     * This is the Constructor in this Class
     *
     * @param    string        $fullpath:    the root path for searching files
     * @param    string        $subdir:    the sub folder inside the root path for link creation
     * @return    object        the object return itself
     * @access    public
     */
    public function PFileTree($fullpath = null, $subdir = null)
    {
        if ( !defined( 'PTree_SUBFOLDER' ) && $subdir !== null ) {
            define( 'PTree_SUBFOLDER', $subdir );
        }
        
        if ( !defined( 'PTree_SITE_PATH' ) && $fullpath !== null ) {
            define( 'PTree_SITE_PATH', $fullpath );
        }
    }
    
    // }}}
    // {{{ Keys
    
    /**
     * Function Keys
     * 
     * sets the keys for the information
     *
     * @return    array        the Keys
     *
     * @access    private
     */
    private function Keys()
    {
        if ( defined( 'PTree_KEYS' ) ) {
            $str    = preg_replace( '/[^a-z]+/', '|', strtolower( PTree_KEYS ) );
            $arr    = explode( '|', trim( $str, '|' ) );
            
            foreach ( $arr as $key => $val ) {
                $all    = explode( '|', PTree_ALLOWED_KEYS );
                
                if ( !in_array( $val, $all ) ) {
                    unset( $arr[$key] );
                }
            }
        } else {
            $arr    = explode( '|', PTree_ALLOWED_KEYS );
        }
        
        if ( is_array( $arr ) ) {
            return $arr;
        } else {
            return array();
        }
    }
    
    // }}}
    // {{{ ListFiles
    
    /**
     * Function ListFiles
     * 
     * creates a list of files
     *
     * @param    string        $dir:        the root path for searching files
     * @param    boolean        $recursive:    if TRUE, the function will work recursive
     * @param    boolean        $object:    if TRUE, the function will create objects
     *                                    if FALSE, the function will create arrays
     * @param    string        $subdir:    the sub folder inside the root path for link creation
     * @return    array        the object return itself
     *
     * @access    public
     */
    public function ListFiles($dir = null, $recursive = true, $object = true, $keys = null)
    {
        $recursive    = (boolean)    $recursive;
        $object        = (boolean)    $object;
        
        if ( $keys !== null && !defined( 'PTree_KEYS' ) ) {
            define( 'PTree_KEYS', (string) $keys );
        }
        
        if ( $dir === null ) {
            $this->PushError( 'No location has been provided for scaning!' );
            exit;
        }
        
        $dir    = (string)    $dir;
        
        $dir    = realpath( $dir );
        $list    = array();
        
        if ( is_dir( $dir ) ) {
            $d  = opendir( $dir );
            
            while ( false !== ( $filename = readdir( $d ) ) ) {
                if ( $filename != '.' && $filename != '..' ) {
                    $path    = realpath( $dir . '/' . $filename );
                    
                    switch ( $object ) {
                        case true:
                            $list[$filename]    = new FileInfo( $path, $recursive, $object );
                            break;
                        default:
                            $list[$filename]    = $this->Info(  $path, $recursive, $object );
                            break;
                    }
                }
            }
            
            closedir( $d );
        } elseif ( is_file( $dir ) ) {
            $path    = realpath( $dir );
            
            switch ( $object ) {
                case true:
                    $list[$dir]    = new FileInfo( $path, false, $object );
                    break;
                default:
                    $list[$dir]    = $this->Info(  $path, false, $object );
                    break;
            }
        }
        
        ksort( $list );
        
        return $list;
    }
    
    // }}}
    // {{{ Info
    
    /**
     * Function Info
     * 
     * reads Information about the files
     *
     * @param    string        $file:        the root path for searching files
     * @param    boolean        $recursive:    if TRUE, the function will work recursive
     * @param    boolean        $object:    if TRUE, the function will create objects
     *                                    if FALSE, the function will create arrays
     * @return    array        the Information about the files
     *
     * @access    private
     */
    private function Info($file, $recursive = false, $object = true)
    {
        $file        = (string)    $file;
        $recursive    = (boolean)    $recursive;
        $object        = (boolean)    $object;
        
        $keys        = $this->Keys();
        $path        = pathinfo( $file );
        
        $info        = array();
        
        if ( in_array( 'mtime', $keys ) ) {
            $info['mtime']            = filemtime( $file );
        }
        
        if ( in_array( 'mdate', $keys ) ) {
            $info['mdate']            = date( 'Y-m-d H:i:s', $info['mtime'] );
        }
        
        if ( in_array( 'atime', $keys ) ) {
            $info['atime']            = fileatime( $file );
        }
        
        if ( in_array( 'adate', $keys ) ) {
            $info['adate']            = date( 'Y-m-d H:i:s', $info['atime'] );
        }
        
        if ( isset( $path['dirname'] ) && isset( $path['basename'] ) ) {
            $info['fullpath']        = realpath( $path['dirname'] . '/' . $path['basename'] );
        }
        
        if ( in_array( 'dirname', $keys ) && isset( $path['dirname'] ) ) {
            $info['dirname']        = $path['dirname'];
        }
        
        if ( in_array( 'basename', $keys ) && isset( $path['basename'] ) ) {
            $info['basename']        = $path['basename'];
        }
        
        if ( in_array( 'type', $keys ) ) {
            $info['type']            = filetype( $file );
        }
        
        if ( is_file( $file ) ) {
            if ( in_array( 'size', $keys ) ) {
                $info['size']        = filesize( $file );
            }
            
            if ( in_array( 'ext', $keys ) && isset( $path['extension'] ) ) {
                $info['ext']        = strtolower( $path['extension'] );
            }
            
            if ( in_array( 'filename', $keys ) && isset( $path['filename'] ) ) {
                $info['filename']    = strtolower( $path['filename'] );
            }
            
            if ( in_array( 'url', $keys ) && !is_dir( $file ) ) {
                if ( defined( 'PTree_SITE_PATH' ) ) {
                    $info['url']    = $this->FileURL( $file );
                }
            }
        }
        
        if ( in_array( 'perms', $keys ) ) {
            $info['perms']            = substr( sprintf( '%o', fileperms( $file ) ), -4 );
        }
        
        if ( is_dir( $file ) ) {
            if ( in_array( 'filename', $keys ) && isset( $path['basename'] ) ) {
                $info['filename']    = strtolower( $path['basename'] );
            }
            
            if ( $recursive === true ) {
                $info['children']    = $this->ListFiles( $file, $recursive, $object );
            }
        }
        
        clearstatcache();
        
        return $info;
    }
    
    // }}}
    // {{{ PushError
    
    /**
     * Function PushError
     * 
     * displays an Error Message
     *
     * @param    string        $err:        the Error Message
     * 
     * @access    private
     */
    private function PushError($err)
    {
        $err    = (string) $err;
        
        $str    = '<div style="padding:10px;background:#FFFDE6;border:1px dotted #0000A0;font-family:Verdana;font-size:11px;color:#BF4300;">';
        $str    .='<b>PFileTree:</b> '.$err.'</div>';
        
        print $str;
        
        exit;
    }
    
    // }}}
    // {{{ FileURL
    
    /**
     * Function FileURL
     * 
     * creates an URL for a given file path
     *
     * @param    string        $file:        the path for the files
     * @return    string        the URL for the file
     *
     * @access    private
     */
    private function FileURL($file)
    {
        $file        = str_replace( '\\', '/', $file );
        $site_path    = str_replace( '\\', '/', PTree_SITE_PATH );
        $file        = str_replace( $site_path, '', $file );
        $url        = PTree_HTTP . '://' . PTree_SERVER_NAME;
        
        if ( defined( 'PTree_SUBFOLDER' ) ) {
            $url  .= '/' . PTree_SUBFOLDER;
        }
        
        $url .= $file;
        
        return $url;
    }
    
    // }}}
    // {{{ Delete
    
    /**
     * Function Delete
     * 
     * deletes a file or a path
     *
     * @param    string        $path:        the path that should removed
     * @return    boolean        FALSE, if removing failed
     *
     * @access    private
     * @deprecated
     */
    private function Delete($path)
    {
        $path    = (string) $path;
        
        if ( is_file( $path ) ) {
            @unlink( $path );
            
            return true;
        } elseif ( is_dir( $path ) ) {
            $o    = $this->ListFiles( $path, true, true, 'type fullpath' );
            
            foreach ( $o as $key=>$obj ) {
                if ( $obj->type == 'file' ) {
                    @unlink( $obj->fullpath );
                } elseif ( $obj->type == 'dir' ) {
                    $this->Delete( $obj->fullpath );
                }
            }
            
            @rmdir( $path );
            
            return true;
        } else {
            return false;
        }
    }
}

// }}}
// {{{ FileInfo

/**
 * FileInfo Functions
 *
 * Retrieve the info from a specified location and stores it
 *
 * @category    Extension
 * @package        TYPO3
 * @subpackage    tm_classes
 * @file        PFileTree.inc.php
 * @author        Ciprian Voicu  <pictoru@autoportret.ro>
 * @author        Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright    2006-2007 Telemotive AG, Germany, Munich
 * @license        http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @since        Version 2.2
 */
class FileInfo extends PFileTree
{
    // {{{ properties
    
    /**
     * times and dates of the File
     *
     * @var            string
     * @access        public
     */
    public $mtime        = null;
    public $mdate        = null;
    public $atime        = null;
    public $adate        = null;
    
    /**
     * the full path of the File
     *
     * @var            string
     * @access        public
     */
    public $fullpath    = null;
    
    /**
     * the directory part of the full path
     *
     * @var            string
     * @access        public
     */
    public $dirname        = null;
    
    /**
     * the file name without extension
     *
     * @var            string
     * @access        public
     */
    public $basename    = null;
    
    /**
     * the complete file name
     *
     * @var            string
     * @access        public
     */
    public $filename    = null;
    
    /**
     * the URL, to the file
     *
     * @var            string
     * @access        public
     */
    public $url            = null;
    
    /**
     * the Image Object
     *
     * @var            pointer
     * @access        public
     */
    public $type        = null;
    
    /**
     * the file size
     * 'N/A', if the file size is not available
     *
     * @var            mixed
     * @access        public
     */
    public $size        = 'N/A';
    
    /**
     * the file extension
     *
     * @var            string
     * @access        public
     */
    public $ext            = 'N/A';
    
    /**
     * the file rights on the server
     *
     * @var            string
     * @access        public
     */
    public $perms        = null;
    
    /**
     * a list of all child elements or 'N/A'
     *
     * @var            mixed
     * @access        public
     */
    public $children    = 'N/A';
    
    // }}}
    // {{{ FileInfo
    
    /**
     * Function FileInfo
     * 
     * This is the Constructor in this Class
     *
     * @param    string        $file:        the root path for searching files
     * @param    boolean        $recursive:    if TRUE, the function will work recursive
     * @param    boolean        $object:    if TRUE, the function will create objects
     *                                    if FALSE, the function will create arrays
     * @return    object        the object return itself
     * @access    public
     */
    public function FileInfo($file, $recursive, $object)
    {
        $path    = pathinfo( $file );
        $keys    = $this->Keys();
        
        if ( in_array( 'mtime', $keys ) ) {
            $this->mtime    = filemtime( $file );
        } else {
            unset( $this->mtime );
        }
        
        if ( in_array( 'mdate', $keys ) ) {
            $this->mdate    = date( 'Y-m-d H:i:s', filemtime( $file ) );
        } else {
            unset( $this->mdate );
        }
        
        if ( in_array( 'atime', $keys ) ) {
            $this->atime    = fileatime( $file );
        } else {
            unset( $this->atime );
        }
        
        if ( in_array( 'adate', $keys ) ) {
            $this->adate    = date( 'Y-m-d H:i:s', fileatime( $file ) );
        } else {
            unset( $this->adate );
        }
        
        if ( isset( $path['dirname'] ) && isset( $path['basename'] ) ) {
            $this->fullpath    = realpath( $path['dirname'] . '/' . $path['basename'] );
        } else {
            unset( $this->fullpath );
        }
        
        if ( in_array( 'dirname', $keys ) && isset( $path['dirname'] ) ) {
            $this->dirname    = $path['dirname'];
        } else {
            unset( $this->dirname );
        }
        
        if ( in_array( 'basename', $keys ) && isset( $path['basename'] ) ) {
            $this->basename    = $path['basename'];
        } else {
            unset( $this->basename );
        }
        
        if ( in_array( 'type', $keys ) ) {
            $this->type    = filetype( $file );
        } else {
            unset( $this->type );
        }
        
        if ( is_file( $file ) ) {
            if ( in_array( 'size', $keys ) ) {
                $this->size    = filesize( $file );
            } else {
                unset( $this->size );
            }
            
            if ( in_array( 'ext', $keys ) && isset( $path['extension'] ) ) {
                $this->ext    = strtolower( $path['extension'] );
            } else {
                unset( $this->ext );
            }
            
            if ( isset( $path['filename'] ) ) {
                if ( in_array( 'filename', $keys ) ) {
                    $this->filename    = strtolower( $path['filename'] );
                } else {
                    unset( $this->filename );
                }
            } elseif ( isset( $path['basename'] ) ) {
                $this->filename        = explode( '.', $path['basename'] );
                $this->filename        = $this->filename[0];
            }
            
            if( in_array( 'url', $keys ) && defined( 'PTree_SITE_PATH' ) ) {
                $this->url        = $this->FileURL( $file );
            }else{
                unset( $this->url );
            }
            
        } elseif ( is_dir( $file ) ) {
            unset( $this->size );
            unset( $this->ext );
            unset( $this->url );
            
            if ( in_array( 'filename', $keys ) && isset( $path['basename'] ) ) {
                $this->filename    = strtolower( $path['basename'] );
            } else {
                unset( $this->filename );
            }
        }
        
        if ( in_array( 'perms', $keys ) ) {
            $this->perms        = substr( sprintf( '%o', fileperms( $file ) ), -4 );
        } else {
            unset( $this->perms );
        }
        
        if ( is_dir( $file ) && $recursive ) {
            $this->children        = $this->ListFiles( $file, $recursive, $object );
        }else{
            unset( $this->children );
        }
        
        clearstatcache();
    }
    
    // }}}
}

// }}}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>