<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * Chart Functions
 *
 * TODO
 *
 * PHP version 5
 *
 * @category  misc
 * @package   ?
 * @version   1.1
 * @author    Nguyen Duy Quang
 * @author    Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright ??
 * @license   http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see       http://www.phpclasses.org/browse/package/1571.html
 */

// {{{ QSDB_DrawChart

/**
 * Chart Functions
 *
 * This class is drawing the chart with two columns value
 *
 * @category  misc
 * @package   ?
 * @author    JWang
 * @author    Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright ??
 * @license   http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @changes
 * 20071110   TMu    - function parameter $img replaced by
 *                     internal Variable $this->_img
 *
 */
class QSDB_DrawChart
{
    // {{{ properties

    /**
     * the Width of the Chart Image
     *
     * @var    integer
     * @access private
     */
    private $_imgWidth = 0;

    /**
     * the Height of the Chart Image
     *
     * @var    integer
     * @access private
     */
    private $_imgHeight = 0;

    /**
     * the Zero position of the X-Axis against Image-Height
     *
     * @var    integer
     * @access private
     */
    private $_x1_0 = 0;

    /**
     * the Zero position of the Y-Axis against Image-Width
     *
     * @var    integer
     * @access private
     */
    private $_x2_0 = 0;

    /**
     * the Chart Colors, coded with RGB
     *
     * @var    object
     * @access private
     */
    private $_white    = null;
    private $_black    = null;
    private $_red      = null;
    private $_green    = null;
    private $_blue     = null;
    private $_yellow   = null;
    private $_bin      = null;
    private $_xam1     = null;
    private $_xam2     = null;
    private $_darkred  = null;
    private $_darknavy = null;

    /**
     * the Maximum and the Minimum Values for the X and the Y-Axis
     *
     * @var    float
     * @access private
     */
    private $_maxValueY = 0;
    private $_maxValueX = 0;
    private $_minValueY = 0;
    private $_minValueX = 0;

    /**
     * the number of Rows
     *
     * @var    integer
     * @access private
     */
    private $_countRows = 0;

    /**
     * all Values to display
     *
     * @var    array
     * @access private
     */
    private $_values = array();

    /**
     * the Zero position of the Y-Axis against Image-Zero
     *
     * @var    integer
     * @access private
     */
    private $_yZero = 0;

    /**
     * the Zero position of the X-Axis against Image-Zero
     *
     * @var    integer
     * @access private
     */
    private $_xZero = 0;

    /**
     * the titles, used in the Chart
     *
     * @var    array
     * @access private
     */
    private $_titles = array();

    /**
     * all Colors
     *
     * @var    array
     * @access private
     */
    private $_colours = array();

    /**
     * ?
     *
     * @var    integer
     * @access private
     */
    private $_imgn = 0;

    /**
     * the Chart Image
     *
     * @var    object
     * @access private
     */
    private $_img = null;

    // }}}
    // {{{ __construct

    /**
     * Class Constructor
     *
     * This is the Constructor in this Class
     *
     * @param integer $imgageWidth  the Width of the Chart
     * @param integer $imgageHeight the Height of the Chart
     * @param array   $titles       the titles for the Chart and all Axes
     *
     * @access public
     * @return void
     */
    public function __construct($imgageWidth, $imgageHeight, array $titles)
    {
        $this->_titles    = $titles;
        $this->_imgWidth  = (int) $imgageWidth;
        $this->_imgHeight = (int) $imgageHeight;
        $this->_x1_0      = $this->_imgHeight - 30;
        $this->_x2_0      = $this->_imgWidth - 10;

        //reset Max and Min Values
        $this->_maxValueY = null;
        $this->_maxValueX = null;
        $this->_minValueY = null;
        $this->_minValueX = null;
    }

    // }}} __construct
    // {{{ createImage

    /**
     * Function createImage
     *
     * creates the Chart Image
     *
     * @param array   $values     all Points to be displayed
     * @param boolean $showValues if TRUE, the Values of all Points will be displayed
     * @param string  $formatX    the Format for the X-Axis
     *
     * @access public
     * @return object the Chart Object
     */
    public function createImage(array $values, $showValues = true, $formatX = 'date' )
    {
        if ( !is_array( $values ) ) {
            return null;
        }

        $this->_values    = $values;
        $this->_countRows = count( $this->_values );


        foreach ( $this->_values as $dataRow ) {
            foreach ( $dataRow['points'] as $dataPoint ) {
                if( (float) $dataPoint['x'] > $this->_maxValueX || $this->_maxValueX === null ){
                    $this->_maxValueX = (float) $dataPoint['x'];
                }

                if( (float) $dataPoint['y'] > $this->_maxValueY || $this->_maxValueY === null ){
                    $this->_maxValueY = (float) $dataPoint['y'];
                }

                if( (float) $dataPoint['x'] < $this->_minValueX || $this->_minValueX === null ){
                    $this->_minValueX = (float) $dataPoint['x'];
                }
                if( (float) $dataPoint['y'] < $this->_minValueY || $this->_minValueY === null ){
                    $this->_minValueY = (float) $dataPoint['y'];
                }
            }
        }

        // Create the Image for the Chart
        $this->_img = ImageCreate($this->_imgWidth, $this->_imgHeight) or die('Could not create image');

        // Define the Colors
        $this->_white    = imagecolorallocate($this->_img, 255, 255, 255);
        $this->_black    = imagecolorallocate($this->_img, 0, 0, 0);
        $this->_red      = imagecolorallocate($this->_img, 255, 0, 0);
        $this->_green    = imagecolorallocate($this->_img, 0, 255, 0);
        $this->_blue     = imagecolorallocate($this->_img, 0, 0, 255);
        $this->_yellow   = imagecolorallocate($this->_img, 255, 255, 0);
        $this->_bin      = imagecolorallocate($this->_img, 255, 0, 128);
        $this->_xam1     = imagecolorallocate($this->_img, 211, 211, 211);
        $this->_xam2     = imagecolorallocate($this->_img, 128, 128, 128);
        $this->_darkred  = imagecolorallocate($this->_img, 0x90, 0x00, 0x00);
        $this->_darknavy = imagecolorallocate($this->_img, 0x00, 0x00, 0x50);

        $this->_colours = array(
            $this->_black,
            $this->_red,
            $this->_green,
            $this->_blue,
            $this->_yellow,
            $this->_bin,
            $this->_xam1,
            $this->_xam2,
            $this->_darkred,
            $this->_darknavy
        );

        // Background
        imagefill( $this->_img, 10, 20, $this->_white );

        // Y-Axis
        $_crr_blank_y = $this->_drawYAxis();

        // X-Axis
        $_crr_blank_x = $this->draw_line4x( $formatX );

        // Coordinate Cross
        $this->_drawCoordinateCross();

        // Legend
        $this->_drawLegend();

        // Chart Elements
        $this->_drawElements( $_crr_blank_y, $_crr_blank_x, $showValues );

        return $this->_img;
    }

    // }}}
    // {{{ createPNG

    /**
     * Function createPNG
     *
     * creates a PNG file from the Chart
     *
     * @param string $file_name the path for the file
     *
     * @access public
     * @return void
     */
    public function createPNG($file_name = '')
    {
        $file_name = (string) $file_name;

        if ( $file_name != '' ) {
            imagepng( $this->_img, $file_name );
        } else {
            imagepng( $this->_img );
        }

        ImageDestroy( $this->_img );
    }

    // }}}
    // {{{ _drawElements

    /**
     * Function _drawElements
     *
     * creates the Chart Image
     *
     * @param integer $_eac_blank_y all Points to be displayed
     * @param integer $_eac_blank_x the Format for the X-Axis
     * @param boolean $showValues   if TRUE, the Values of all Points will be displayed
     *
     * @access private
     * @return void
     */
    private function _drawElements($_eac_blank_y, $_eac_blank_x, $showValues = true )
    {
        $showValues = (boolean) $showValues;

        $max_value_y = $this->_maxValueY;
        $max_value_x = $this->_maxValueX;
        $min_value_y = $this->_minValueY;
        $min_value_x = $this->_minValueX;

        $diff_y = $max_value_y - $min_value_y;
        $diff_x = $max_value_x - $min_value_x;

        $x            = $this->_getMaxX() + 5;
        $_crr_blank_y = ( $this->_x1_0 - $x ) / $diff_y;
        $_crr_blank_x = ( $this->_x2_0 - 40 ) / $diff_x;

        $j = 0;
        foreach ( $this->_values as $row ) {
            $count_points = count( $row['points'] );
            $colour       = $row['colour'];

            if ( is_int( $colour ) ) {
                $color = $this->_colours[$colour];
            } else {
                $color = $this->$colour;
            }

            for ( $i = 0; $i < $count_points; $i++ ) {
                $point_start = $row['points'][$i];

                //Point 1
                if ( $min_value_y > 0 ) {
                    $_tem_y = ( $point_start['y'] - $min_value_y ) / $_eac_blank_y;
                } else {
                    $_tem_y = $point_start['y'] / $_eac_blank_y;
                }

                $_val_y = ( ( $point_start['y'] % $_eac_blank_y ) * $_crr_blank_y ) / $_eac_blank_y;
                $y1     = floor( $this->_yZero - ( $_tem_y * $_crr_blank_y + $_val_y ) );

                if ( $y1 > $this->_x1_0 ) {
                    $y1 = floor( $this->_x1_0 );
                }

                if ( $y1 < $x ) {
                    $y1 = floor( $x );
                }

                if ( $min_value_x > 0 ) {
                    $_tem_x = ( $point_start['x'] - $min_value_x ) / $_eac_blank_x;
                } else {
                    $_tem_x = $point_start['x'] / $_eac_blank_x;
                }

                $_val_x = ( ( $point_start['x'] % $_eac_blank_x ) * $_crr_blank_x ) / $_eac_blank_x;
                $x1     = floor( $this->_xZero + ( $_tem_x * $_crr_blank_x + $_val_x ) );

                if ( $x1 < 40 ) {
                    $x1 = 40;
                }

                if ( $x1 > $this->_x2_0 ) {
                    $x1 = $this->_x2_0;
                }

                imagearc(  $this->_img, $x1, $y1, 3, 3, 1, 360, $color );
                imagefill( $this->_img, $x1, $y1, $color );

                if ( $i < $count_points - 1 ) {
                    $point_end    = $row['points'][$i + 1];
                    //Point 2
                    if( $min_value_y > 0 ) {
                        $_tem_y    = ( $point_end['y'] - $min_value_y ) / $_eac_blank_y;
                    } else {
                        $_tem_y = $point_end['y']/$_eac_blank_y;
                    }

                    $_val_y        = ( ( $point_end['y'] % $_eac_blank_y ) * $_crr_blank_y ) / $_eac_blank_y;
                    $y2            = $this->_yZero - ( $_tem_y * $_crr_blank_y + $_val_y );

                    if ( $y2 > $this->_x1_0 ) {
                        $y2 = floor( $this->_x1_0 );
                    }

                    if ( $y2 < $x ) {
                        $y2 = floor( $x );
                    }

                    if ( $min_value_x > 0 ) {
                        $_tem_x = ( $point_end['x'] - $min_value_x ) / $_eac_blank_x;
                    } else {
                        $_tem_x = $point_end['x'] / $_eac_blank_x;
                    }

                    $_val_x        = ( ( $point_end['x'] % $_eac_blank_x ) * $_crr_blank_x ) / $_eac_blank_x;
                    $x2            = $this->_xZero + ( $_tem_x * $_crr_blank_x + $_val_x );

                    if ( $x2 < 40 ) {
                        $x2 = 40;
                    }

                    if ( $x2 > $this->_x2_0 ) {
                        $x2 = $this->_x2_0;
                    }

                    imageline( $this->_img, $x1, $y1, $x2, $y2, $color );
                }

                if ( $showValues === true ) {
                    $v         = $point_start['y'];// . ':' . $point_start['x'];
                    $text_size = 1;
                    $len       = $this->_getTextLength( $v, $text_size );
                    $height    = $this->_getTextHeight( $text_size );

                    imagestring( $this->_img, $text_size, $x1 - $len/2, $y1 - $height, $v, $color );
                }
            }

            $j++;
        }
    }

    // }}}
    // {{{ _drawYAxis

    /**
     * Function _drawYAxis
     *
     * draws the Y-Axis
     *
     * @access private
     * @return integer
     */
    private function _drawYAxis()
    {
        $max_value = $this->_maxValueY;
        if ( $max_value < 1 && $max_value >= 0 ) {
            $max_value = 1;
        }

        $min_value = $this->_minValueY;
        if ( $min_value > -1 && $min_value < 0 ) {
            $min_value = -1;
        }

        $x1b    = 35;
        $x1     = 44;
        $y1     = $this->_x1_0;//$this->_imgHeight-20; // +10
        $x2b    = 40;
        $x2     = $this->_imgWidth - 10;
        $y2     =  $this->_x1_0;//$this->_imgHeight-20; // +10 240
        $Tx     = 20;
        $Ty     = $this->_imgHeight - 15;
        $y1b    = $y1;
        $y2b    = $y2;
        $_blank = 25;
        $_val   = $min_value;

        $text_size = 2;

        $x = $this->_getMaxX() + 5;

        $diff = ( ( $max_value - $min_value > 0 ) ? $max_value - $min_value : 1 );

        if ( $diff < 6 ) {
            $this->_imgn = 1;
            $_devi       = 1;
        } else {
            for ( $n = $diff; $n < $diff * 6; $n++ ) {
                if ( $n % 6 == 0 && $n % 3 == 0 ) {
                    $this->_imgn = $n;
                    break;
                }
            }

            $diff  = 6;
            $_devi = 6;
        }

        $_blank    = ( $this->_x1_0 - $x ) / $diff;

        for ( $i = 0; $i <= $diff; $i++ ) {
            if ( $min_value < 0 && $_val < 0 && ( $_val + $this->_imgn / $_devi ) > 0 ) {
                $diff_pos     = $this->_imgn /$_devi;
                $zero_pos     = abs( $_val ) * $_blank / $diff_pos;
                $this->_yZero = floor( $y1b - $zero_pos );
            } elseif ( $_val == 0 && $min_value <= 0 ) {
                $this->_yZero = floor( $y1b );
            } elseif ( $_val == $min_value && $min_value > 0 ) {
                $this->_yZero = $this->_x1_0;
            }

            if ( $i > 0 ) {
                $y1   -= $_blank;
                $y2   -= $_blank;
                $y1b  -= $_blank;
                $y2b  -= $_blank;
                $Ty   -= $_blank;
                $_val += $this->_imgn / $_devi;
            }

            //Bien
            imageline( $this->_img, $x1b, $y1b, $x2, $y2b, $this->_xam1 );

            // line /
            //imageline( $this->_img, $x2b, $y2b, $x1, $y1-2, $this->_xam1 );

            //Main Lines height
            //imageline( $this->_img, $x1, $y1-2, $x2, $y2-2, $this->_xam1 );

            //Values Y
            $len = $this->_getTextLength( $_val, $text_size );
            imagestring( $this->_img, $text_size, $x1b - $len, $y1b - 1 - 3 * $text_size, $_val, $this->_black );
        }

        $this->_maxValueY = $_val;
        return 1;//($_val/$max_value);
    }

    // }}}
    // {{{ draw_line4x

    /**
     * Function draw_line4x
     *
     * draws the X-Axis
     *
     * @param string $formatX the Format for the X-Axis
     *
     * @access private
     * @return integer
     */
    public function draw_line4x( $format_axis = 'date' )
    {
        $max_value = $this->_maxValueX;
        if ( $max_value < 1 && $max_value >= 0 ) {
            $max_value = 1;
        }

        $min_value = $this->_minValueX;
        if ( $min_value > -1 && $min_value < 0 ) {
            $min_value = -1;
        }

        $x1b    = 40;
        $x1     = 44;
        $y1     = $this->_x1_0;//$this->_imgHeight-20; // +10
        $x2b    = 40;
        $x2     = $this->_imgWidth - 10;
        $y2     =  $this->_x1_0 + 5;//$this->_imgHeight-20; // +10 240
        $Tx     = 20;
        $Ty     = $this->_imgHeight - 15;
        $y1b    = $y1;
        $y2b    = $y2;
        $_blank = 25;
        $_val   = $min_value;

        $text_size = 2;

        $y = $this->_x2_0 - 44;

        $diff = ( ( $max_value - $min_value > 0 ) ? $max_value - $min_value : 1 );

        if ( $diff < 12 ) {
            $this->_imgn = 1;
            $_devi       = 1;
        } else {
            for ( $n = $diff; $n < $diff * 12; $n++ ) {
                if ( $n % 12 == 0 && $n % 6 == 0 ) {
                    $this->_imgn = $n;
                    break;
                }
            }

            $diff  = 12;
            $_devi = 12;
        }

        $_blank = ( $y ) / $diff;

        for ( $i = 0; $i <= $diff; $i++ ) {
            if ( $min_value < 0 && $_val < 0 && ( $_val + $this->_imgn / $_devi ) > 0 ) {
                $diff_pos     = $this->_imgn /$_devi;
                $zero_pos     = abs( $_val ) * $_blank / $diff_pos;
                $this->_xZero = floor( $x2b + $zero_pos );
                //echo $this->_xZero;
            } elseif ( $_val == 0 && $min_value <= 0 ) {
                $this->_xZero = floor( $x2b );
            } elseif ( $_val == $min_value && $min_value > 0 ) {
                $this->_xZero = 40;
            }

            if ( $i > 0 ) {
                $x1   += $_blank;
                $x2   += $_blank;
                $x1b  += $_blank;
                $x2b  += $_blank;
                $Tx   += $_blank;
                $_val += $this->_imgn / $_devi;
            }

            //Bien
            imageline( $this->_img, $x1b, $y1b, $x2b, $y2b, $this->_xam1 );

            // line /
            //imageline( $this->_img, $x1b, $y1b, $x1, $y1-2, $this->_xam1 );

            //Main Lines height
            //imageline( $this->_img, $x1, $y1-2, $x2, $y2-2, $this->_xam1 );

            //Values Y
            if( $format_axis == 'date' ){
                $_val_time = date( 'd.m.Y', $_val );
            } elseif ( $format_axis == 'int' ) {
                $_val_time = (int) $_val;
            } else {
                $_val_time = $_val;
            }

            $len = $this->_getTextLength( $_val_time, $text_size );
            imagestring( $this->_img, $text_size, $x1b - ( $len / 2 ), $y2b + 1, $_val_time, $this->_black );
        }

        $this->_maxValueX = $_val;
        return 1;//($_val/$max_value);
    }

    // }}}
    // {{{ _drawLegend

    /**
     * Function _drawLegend
     *
     * draws the Legend
     *
     * @access private
     * @return void
     */
    private function _drawLegend()
    {
        $x  = 10;
        $x0 = 10;
        $y  = 0;

        $text_size = 2;

        for( $i = 0; $i < $this->_countRows; $i++ ){
            $str_com = $this->_values[$i]['title'];

            $len = $this->_getTextLength( $str_com, $text_size );

            if ( $len > $y ) {
                $y = $len;
            }
        }

        $len = $y + 40;

        for ( $i = 0; $i < $this->_countRows; $i++ ) {
            $str_com = $this->_values[$i]['title'];
            $colour  = $this->_values[$i]['colour'];

            if ( is_int( $colour ) ) {
                $color = $this->_colours[$colour];
            } else {
                $color = $this->$colour;
            }

            ImageFilledRectangle( $this->_img, $this->_x2_0 - $y - 30, $x, $this->_x2_0 - $y - 20, $x + 10, $color );
            /*
            if (($i % 2) == 0) {
                imageline( $this->_img, $this->_x2_0 - $y - 30, $x + 5,$this->_x2_0 - $y - 10, $x + 5, $color );
            } else {
                imagedashedline( $this->_img, $this->_x2_0 - $y - 30, $x + 5, $this->_x2_0 - $y - 10, $x + 5, $color );
            }
            */
            imagestring( $this->_img, $text_size, $this->_x2_0 - $y, $x - 1, $str_com, $this->_black );

            $x = $x + 15;

            if ( $x > $x0 ) {
                $x0 = $x;
            }

            if ( $i > 0 && ( ( $i + 1 ) % 4 ) == 0 ) {
                $x = 10;
                $y = $y + $len;
            }
        }
    }

    // }}}
    // {{{ _drawCoordinateCross

    /**
     * Function _drawCoordinateCross
     *
     * draws the Coordinate Cross
     *
     * @access private
     * @return void
     */
    private function _drawCoordinateCross()
    {
        $x = $this->_getMaxX();

        $diff = $this->_maxValueY - $this->_minValueY;
        $max  = $this->_maxValueY;


        $rely = $this->_yZero;
        $relx = $this->_xZero;

        //Vertically line |
        imageline( $this->_img, 40, $this->_x1_0, 40, $x, $this->_xam1 );

        //Horizontally line ---------
        imageline( $this->_img, 40, $this->_x1_0, $this->_x2_0, $this->_x1_0, $this->_xam1 );
        //Border Picture
        imageRectangle( $this->_img, 0, 0, $this->_imgWidth-1, $this->_imgHeight-1, $this->_xam1 );
        //Zero-Point X-Axis
        if ( $this->_minValueY <= 0 ) {
            imageline( $this->_img, 30, $rely, $this->_x2_0, $rely, $this->_blue );
        }

        //Zero-Point X-Axis
        if ( $this->_minValueX <= 0 ) {
            imageline( $this->_img, $relx, $this->_x1_0 + 5, $relx, $x, $this->_blue );
        }

        //title y-axis
        ImageStringup( $this->_img, 3, 2, $this->_x1_0, $this->_titles['y'], $this->_black );

        //title x-axis
        $text_size = 3;
        $height    = $this->_getTextHeight( $text_size );
        imagestring( $this->_img, $text_size, 40, $this->_imgHeight-$height, $this->_titles['x'], $this->_black );

        $str_date = 'erstellt am ' . date( "d.m.Y \u\m H:i:s" );

        $text_size = 1;

        $len    = $this->_getTextLength( $str_date, $text_size );
        $height = $this->_getTextHeight( $text_size );

        imagestring( $this->_img, $text_size, $this->_x2_0 - $len, $this->_imgHeight-$height, $str_date, $this->_black );
    }

    // }}}
    // {{{ _getTextLength

    /**
     * Function _getTextLength
     *
     * calculates the Text Lenght based on a Text Size
     *
     * @param string $text      the Text, to get the Lenght from
     * @param string $text_size the Text Size
     *
     * @access private
     * @return integer the Text Lenght
     */
    private function _getTextLength( $text, $text_size )
    {
        $len = strlen( (string) $text ) * ( 4 + (int) $text_size );

        return (int) $len;
    }

    // }}}
    // {{{ _getTextHeight

    /**
     * Function _getTextHeight
     *
     * calculates the Text Height based on a Text Size
     *
     * @param integer $text_size the Text Size
     *
     * @access private
     * @return integer the Text Height
     */
    private function _getTextHeight( $text_size )
    {
        $height = 7 + ( 2 * (int) $text_size );

        return (int) $height;
    }

    // }}}
    // {{{ _getMaxX

    /**
     * Function _getMaxX
     *
     * seraches the Maximum Value on the X-Axis
     *
     * @access private
     * @return integer the maximum X-Value
     */
    private function _getMaxX()
    {
        $x = 10;
        for ( $i = 0; $i < $this->_countRows; $i++ ) {
            $x = $x + 15;

            if ( $i > 0 && ( ( $i + 1 ) % 4 ) == 0 ) {
                $x = $x + 5;
                break;
            }
        }

        return $x;
    }

    // }}}
}

// }}} QSDB_DrawChart

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>