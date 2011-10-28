<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 set softtabstop=4: */

/**
 * PowerGraphic Functions
 *
 * PowerGraphic creates 6 different types of graphics with how many parameters you want. You can
 * change the appearance of the graphics in 3 different skins, and you can still cross data from 2
 * graphics in only 1! It's a powerful script, and I recommend you read all the instructions
 * to learn how to use all of this features. Don't worry, it's very simple to use it.
 *
 * PHP version 5
 *
 * @category  misc
 * @package   ?
 * @version   1.1
 * @author    Carlos Reche   <carlosreche@yahoo.com> Sorocaba, SP - Brazil
 * @author    Thomas Mueller <thomas.mueller@telemotive.de>
 * @copyright ??
 * @license   http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @see       http://www.phpclasses.org/browse/package/1993.html
 */

// {{{ PowerGraphic

/**
 * PowerGraphic Functions
 *
 * PowerGraphic creates 6 different types of graphics with how many parameters you want. You can
 * change the appearance of the graphics in 3 different skins, and you can still cross data from 2
 * graphics in only 1! It's a powerful script, and I recommend you read all the instructions
 * to learn how to use all of this features. Don't worry, it's very simple to use it.
 *
 * INSTRUNCTIONS OF HOW TO USE THIS SCRIPT  (Please, take a minute to read it. It's important!)
 *
 * NOTE: make sure that your PHP is compiled to work with GD Lib.
 *
 * NOTE: You may create test images using a form that comes with this script. Just add a "showform"
 * as a query string. (Example: "graphic.php?showform")
 *
 * PowerGraphic works with query strings (information sent after the "?" of an URL). Here is an
 * example of how you will have to send the graphic information. Let's suppose that you want to
 * show a graphic of your user's sex:
 *
 * <code>
 * <img src="graphic.php?title=Sex&type=5&x1=male&y1=50&x2=female&y2=55" />
 * </code>
 *
 * This will create a pie graphic (set by type=5) with title as "Sex" and default skin.
 * Let's see the other parameters:
 *
 *     x1 = male
 *     y1 = 50 (quantity of males)
 *     x2 = female
 *     y2 = 55 (quantity of females)
 *
 * See how it's simple! :)
 * For those who don't know, to create a query string you have to put an "?" at the end of the URL and join
 * the parameters with "&". Example: "graphic.php?Parameter_1=Value_1&Parameter_2=Value_2" (and so on). You
 * can set how many parameters you want.
 *
 * The boring step would be to create this query string. Well, 'would be', if I didn't create a function to do that. :)
 * Let's see an example of how you can use this function in a PHP document:
 *
 * ///// START OF EXAMPLE /////
 *
 * <code>
 * <?php
 *
 * require "class.graphics.php";
 * $PG = new PowerGraphic;
 *
 * $PG->title = 'Sex';
 * $PG->type  = '5';
 * $PG->x[0]  = 'male';
 * $PG->y[0]  = '50';
 * $PG->x[1]  = 'female';
 * $PG->y[1]  = '55';
 *
 * echo '<img src="graphic.php?' . $PG->create_query_string() . '" />';
 *
 * // If you're going to create more than 1 graphic, it'll be important to reset the values before
 * // create the next query string:
 * $PG->resetValues();
 *
 * ?>
 * </code>
 *
 * ///// END OF EXAMPLE /////
 *
 * Here is a list of all parameters you may set:
 * <samp>
 * title      =>  Title of the graphic
 * axis_x     =>  Name of values from Axis X
 * axis_y     =>  Name of values from Axis Y
 * graphic_1  =>  Name of Graphic_1 (only shown if you are gonna cross data from 2 different graphics)
 * graphic_2  =>  Name of Graphic_2 (same comment of above)
 *
 * type  =>  Type of graphic (values 1 to 6)
 *          1 => Vertical bars (default)
 *          2 => Horizontal bars
 *          3 => Dots
 *          4 => Lines
 *          5 => Pie
 *          6 => Donut
 *
 * skin   => Skin of the graphic (values 1 to 3)
 *          1 => Office (default)
 *          2 => Matrix
 *          3 => Spring
 *
 * credits => Only if you want to show my credits in the image. :)
 *          0 => doesn't show (default)
 *          1 => shows
 *
 * x[0]  =>  Name of the first parameter in Axis X
 * x[1]  =>  Name of the second parameter in Axis X
 * ... (etc)
 *
 * y[0]  =>  Value from "graphic_1" relative for "x[0]"
 * y[1]  =>  Value from "graphic_1" relative for "x[1]"
 * ... (etc)
 *
 * z[0]  =>  Value from "graphic_2" relative for "x[0]"
 * z[1]  =>  Value from "graphic_2" relative for "x[1]"
 * ... (etc)
 * </samp>
 * NOTE: You can't cross data between graphics if you use "pie" or "donut" graphic. Values for "z"
 * won't be considerated.
 *
 * @category  misc
 * @package   ?
 * @author    Carlos Reche   <carlosreche@yahoo.com> Sorocaba, SP - Brazil
 * @author    Thomas Mueller <thomas.mueller@telemotive.de> TMu
 * @copyright ??
 * @license   http://www.gnu.org/copyleft/gpl.html  GNU General Public License 2.0
 * @changes
 * 20071110   TMu    - the functions 'ersetze' and 'format_cash' are deleted
 *                     in this Class
 *                   - function 'erstze' is used from Class 'QSDB_functions'
 *                   - function 'format_cash' is used from Class 'QSDB_functions'
 *                   - direct Access to $_Request-Array replaced with t3lib_div::_GP()
 *
 */
class QSDB_PowerGraphic
{
    // {{{ properties

    /**
     * all Values for the X-Axis
     *
     * @var    array
     * @access public
     */
    public $x = array();

    /**
     * all Values for the Y-Axis
     *
     * @var    array
     * @access public
     */
    public $y = array();

    /**
     * all Values for the Z-Axis
     *
     * @var    array
     * @access public
     */
    public $z = array();

    /**
     * the Title for the Graphic
     *
     * @var    string
     * @access public
     */
    public $title = '';

    /**
     * the Name for the X-Axis
     *
     * @var    string
     * @access public
     */
    public $axis_x = '';

    /**
     * the Name for the Y-Axis
     *
     * @var    string
     * @access public
     */
    public $axis_y = '';

    /**
     * the Name for the 1. Graphic
     *
     * @var    string
     * @access public
     */
    public $graphic_1 = '';

    /**
     * the Name for the 2. Graphic
     *
     * @var    string
     * @access public
     */
    public $graphic_2 = '';

    /**
     * the Type Number, Numbers 1-6 possible
     *
     * @var    integer
     * @access public
     */
    public $type = 1;

    /**
     * the Skin Number, Numbers 1-3 possible
     *
     * @var    integer
     * @access public
     */
    public $skin = 1;

    /**
     * if TRUE, the Credits will be displayed
     *
     * @var    boolean
     * @access public
     */
    public $credits = false;

    /**
     * if TRUE, the Numbers will be formated in European Notation
     *
     * @var    boolean
     * @access public
     */
    public $latinNotation = true;

    /**
     * the Width of the Graphic
     *
     * @var    integer
     * @access public
     */
    public $width = 0;

    /**
     * the Height of the Graphic
     *
     * @var    integer
     * @access public
     */
    public $height = 0;

    /**
     * the Height of the Title
     *
     * @var    integer
     * @access public
     */
    public $heightTitle = 0;

    /**
     * if TRUE, an alternate X-Axis exists
     *
     * @var    boolean
     * @access public
     */
    public $alternate_x = false;

    /**
     * the Amount of all Parameters
     *
     * @var    integer
     * @access public
     */
    public $totalParameters = 0;

    /**
     * the Summary of all Y-Values
     *
     * @var    float
     * @access public
     */
    public $sumTotal = 1;

    /**
     * the Value of the biggest Parameter
     *
     * @var    float
     * @access public
     */
    public $biggest_value = 0.0;

    /**
     * the Name of the biggest Parameter
     *
     * @var    string
     * @access public
     */
    public $biggest_parameter = '';

    /**
     * the available Types
     *
     * @var    array
     * @access private
     */
    private $available_types = array();

    /**
     * the available Skins
     *
     * @var    array
     * @access private
     */
    private $available_skins = array();

    /**
     * the Image Object
     *
     * @var    pointer
     * @access private
     */
    private $img = null;

    /**
     * the Names of the Authors
     *
     * @var    string
     * @access private
     */
    private $author = 'Carlos Reche, Thomas Mueller';

    public $bgcolor = null;

    // }}}
    // {{{ PowerGraphic

    /**
     * Function PowerGraphic
     *
     * This is the Constructor in this Class
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        //initialise coordinates
        $this->resetValues();

        $this->available_types = array(
            1 => 'Vertical Bars',
            2 => 'Horizontal Bars',
            3 => 'Dots',
            4 => 'Lines',
            5 => 'Pie',
            6 => 'Donut',
        );

        $this->available_skins = array(
            1 => 'Office',
            2 => 'Matrix',
            3 => 'Spring',
        );
    }

    // }}}
    // {{{ start2

    /**
     * Function start2
     *
     * generates the HTML Output from the Coordinates Array
     *
     * @param string $file_name name of the file
     *
     * @access public
     * @return boolean the object return itself
     */
    public function start2($file_name = '')
    {
        $this->legendExists       = ((ereg('(5|6)', $this->type)) ? true : false);
        $this->biggestGraphicName = ((strlen($this->graphic_1) > strlen($this->graphic_2)) ? $this->graphic_1 : $this->graphic_2);
        $this->heightTitle        = ((!empty($this->title)) ? ($this->_stringHeight(5) + 15) : 0);
        $this->spaceBetweenBars   = (($this->type == 1) ? 40 : 30);        $this->graphic_area_y1    = 20 + $this->heightTitle;
        $this->graphic_area_x2    = $this->graphic_area_x1 + $this->graphic_area_width;
        $this->graphic_area_y2    = $this->graphic_area_y1 + $this->graphic_area_height;        $this->heightTitle        = ( ( !empty( $this->title ) ) ? ( $this->_stringHeight(5) + 15 ) : 0 );
        $this->graphic_area_y1    = 20 + $this->heightTitle;


        foreach ( $this->x as $i => $value ) {
            if (empty($value)) {
                continue;
            }

            if (strlen($value) > strlen($this->biggest_x)) {
                $this->biggest_x = $value;
            }

            if (!$this->graphic_2_exists && (!empty($this->z[$i])) && (ereg('(1|2|3|4)', $this->type))) {
                $this->graphic_2_exists = true;
            }

            $this->y[$i] = (float) $this->y[$i];

            if (!empty($this->y[$i]) && $this->y[$i] > 0.0) {
                if ($this->y[$i] > $this->biggest_y) {
                    $this->biggest_y = number_format(round($this->y[$i], 2), 1, '.', '');
                }
            }

            if ($this->graphic_2_exists) {
                $value       = ((!empty($this->z[$i])) ? (float) $this->z[$i] : 0);
                $this->z[$i] = $value;

                if ($value > $this->biggest_y) {
                    $this->biggest_y = number_format(round($value, 2), 1, '.', '');
                }
            }
        }

        $this->_startFinish($file_name);
    }

    // }}}
    // {{{ _startFinish

    /**
     * Function _startFinish
     *
     * finishs the start procedures
     *
     * @param string $file_name name of the file
     *
     * @access private
     * @return void
     * @since  Version 1.1
     */
    private function _startFinish($file_name = '')
    {
        $this->legendExists = false;
        /*
        if ($this->type == 1) {
            $this->type = 4;
        }
        */
        if ((ereg('(1|2|3|4)', $this->type)) && ($this->graphic_2_exists === true)  &&  ((!empty($this->graphic_1)) || (!empty($this->graphic_2)))) {
            $this->legendExists = true;
        } elseif (ereg('(5|6)', $this->type)) {
            $this->legendExists = true;
        }

        //$this->credits                = (boolean) t3lib_div::_GP('credits');
        //$this->latinNotation         = (boolean) t3lib_div::_GP('latinNotation');

        $this->biggestGraphicName = ((strlen($this->graphic_1) > strlen($this->graphic_2)) ? $this->graphic_1 : $this->graphic_2);
        $this->heightTitle        = ((!empty($this->title)) ? ($this->_stringHeight(5) + 15) : 0);
        $this->spaceBetweenBars   = (($this->type == 1) ? 40 : 30);

        $this->totalParameters   = count($this->x);
        $this->sumTotal          = array_sum($this->y);
        $this->spaceBetweenBars += (($this->graphic_2_exists === true) ? 10 : 0);

        $this->_calculateHigherValue();
        $this->_calculateWidth();
        $this->_calculateHeight();

        $this->createGraphic($file_name);
    }

    // }}}
    // {{{ createGraphic

    /**
     * Function createGraphic
     *
     * creates the Graphic with Background, Borders, Axes, Lines and Values
     *
     * @param string $file_name name of the file
     *
     * @access public
     * @return array the files array
     */
    public function createGraphic($file_name = '')
    {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $this->_loadColorPalette();

        // Fill Background
        //imagefill($this->img, 0, 0, $this->color['axis_values']);
        if (is_array($this->bgcolor)) {
            imagefill($this->img, 0, 0, imagecolorallocate($this->img, $this->bgcolor[0], $this->bgcolor[1], $this->bgcolor[2]));
        } else {
            imagefill($this->img, 0, 0, $this->color['background']);
        }

        // Draw Title
        if (!empty($this->title)) {
            $center = (int) ($this->width / 2) - ($this->_stringWidth($this->title, 5) / 2);
            imagestring($this->img, 5, $center, 10, $this->title, $this->color['title']);
        }

        // Draw Legend
        if ($this->legendExists == true) {
            $this->_drawLegend();
        }

        // Draw Axis
        if (ereg("^(1|3|4)$", $this->type)) {
            // Draw axis and background lines for "vertical bars", "dots" and "lines"

            $higher_value_y    = $this->graphic_area_y1 + ( 0.1 * $this->graphic_area_height );
            $higher_value_size = 0.9 * $this->graphic_area_height;

            $less  = $this->_stringWidth($this->higher_value_str, 3);

            imageline( $this->img, $this->graphic_area_x1, $higher_value_y, $this->graphic_area_x2, $higher_value_y, $this->color['bg_lines'] );
            imagestring( $this->img, 3, $this->graphic_area_x1 - $less - 7, $higher_value_y - 7, $this->higher_value_str, $this->color['axis_values'] );

            for ( $i = 1; $i < 10; $i++ ) {
                $dec_y    = (int) $i * ( $higher_value_size / 10 );
                $x1        = $this->graphic_area_x1;
                $y1        = $this->graphic_area_y2 - $dec_y;
                $x2        = $this->graphic_area_x2;
                $y2        = $this->graphic_area_y2 - $dec_y;

                imageline( $this->img, $x1, $y1, $x2, $y2, $this->color['bg_lines'] );

                if ( $i % 2 == 0 ) {
                    $value    = $this->_numberFormated( $this->higher_value * $i / 10 );
                    $less    = 7 * strlen( $value );
                    imagestring( $this->img, 3, $x1 - $less - 7, $y2 - 7, $value, $this->color['axis_values'] );
                }
            }

            // Axis X
            imagestring( $this->img, 3, $this->graphic_area_x2 + 10, $this->graphic_area_y2 + 3, $this->axis_x, $this->color['title'] );
            imageline( $this->img, $this->graphic_area_x1, $this->graphic_area_y2, $this->graphic_area_x2, $this->graphic_area_y2, $this->color['axis_line'] );

            // Axis Y
            imagestring( $this->img, 3, 20, $this->graphic_area_y1 - 20, $this->axis_y, $this->color['title'] );
            imageline( $this->img, $this->graphic_area_x1, $this->graphic_area_y1, $this->graphic_area_x1, $this->graphic_area_y2, $this->color['axis_line'] );
        } elseif ($this->type == 2) {
            // Draw axis and background lines for "horizontal bars"

            $higher_value_x    = $this->graphic_area_x2 - ( 0.2 * $this->graphic_area_width );
            $higher_value_size = 0.8 * $this->graphic_area_width;

            imageline($this->img, ($this->graphic_area_x1+$higher_value_size), $this->graphic_area_y1, ($this->graphic_area_x1+$higher_value_size), $this->graphic_area_y2, $this->color['bg_lines']);
            imagestring($this->img, 3, (($this->graphic_area_x1+$higher_value_size) - ($this->_stringWidth($this->higher_value, 3)/2)), ($this->graphic_area_y2+2), $this->higher_value_str, $this->color['axis_values']);

            for ( $i = 1, $alt = 15; $i < 10; $i++ ) {
                $dec_x = number_format( round( $i * ( $higher_value_size  / 10 ), 1 ), 1, '.', '' );

                imageline( $this->img, $this->graphic_area_x1 + $dec_x, $this->graphic_area_y1, $this->graphic_area_x1 + $dec_x, $this->graphic_area_y2, $this->color['bg_lines'] );

                if ( $i % 2 == 0 ) {
                    $alt   = ( ( strlen( $this->biggest_y ) > 4 && $alt != 15 ) ? 15 : 2 );
                    $value = $this->_numberFormated( $this->higher_value * $i / 10 );

                    imagestring( $this->img, 3, (int) ( ( $this->graphic_area_x1 + $dec_x ) - ( $this->_stringWidth( $this->higher_value, 3 ) / 2 ) ), $this->graphic_area_y2 + $alt, $value, $this->color['axis_values'] );
                }
            }

            // Axis X
            imagestring( $this->img, 3, $this->graphic_area_x2 + 10, $this->graphic_area_y2 + 3, $this->axis_y, $this->color['title'] );
            imageline( $this->img, $this->graphic_area_x1, $this->graphic_area_y2, $this->graphic_area_x2, $this->graphic_area_y2, $this->color['axis_line'] );

            // Axis Y
            imagestring( $this->img, 3, 20, $this->graphic_area_y1 - 20, $this->axis_x, $this->color['title'] );
            imageline( $this->img, $this->graphic_area_x1, $this->graphic_area_y1, $this->graphic_area_x1, $this->graphic_area_y2, $this->color['axis_line'] );
        }

        if ($this->type == 1) {
            /*
             * Draw graphic: VERTICAL BARS
             */

            $num = 1;
            $x   = $this->graphic_area_x1 + 20;

            foreach ($this->x as $i => $parameter) {
                if (isset($this->z[$i])) {
                    $size = round($this->z[$i] * $higher_value_size / $this->higher_value);
                    $x1   = $x + 10;
                    $y1   = ($this->graphic_area_y2 - $size) + 1;
                    $x2   = $x1 + 20;
                    $y2   = $this->graphic_area_y2 - 1;

                    imageline($this->img, $x1 + 1, $y1 - 1, $x2    , $y1 - 1, $this->color['2_shadow']);
                    imageline($this->img, $x2 + 1, $y1 - 1, $x2 + 1, $y2    , $this->color['2_shadow']);
                    imageline($this->img, $x2 + 2, $y1 - 1, $x2 + 2, $y2    , $this->color['2_shadow']);

                    imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $this->color['2']);
                }

                $size = round($this->y[$i] * $higher_value_size / $this->higher_value);
                $alt  = ((($num % 2 == 0) && (strlen($this->biggest_x) > 5)) ? 15 : 2);
                $x1   = $x;
                $y1   = ($this->graphic_area_y2 - $size) + 1;
                $x2   = $x1 + 20;
                $y2   = $this->graphic_area_y2 - 1;
                $x   += $this->spaceBetweenBars;
                $num++;

                imageline($this->img, $x1 + 1, $y1 - 1, $x2    , $y1 - 1, $this->color['1_shadow']);
                imageline($this->img, $x2 + 1, $y1 - 1, $x2 + 1, $y2    , $this->color['1_shadow']);
                imageline($this->img, $x2 + 2, $y1 - 1, $x2 + 2, $y2    , $this->color['1_shadow']);

                imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $this->color['1']);
                imagestring($this->img, 3, ((($x1 + $x2) / 2) - (strlen($parameter) * 7 / 2)), $y2 + $alt + 2, $parameter, $this->color['axis_values']);
            }
        } elseif ($this->type == 2) {
            /*
             * Draw graphic: HORIZONTAL BARS
             */

            $y = 10;

            foreach ($this->x as $i => $parameter) {
                if (isset($this->z[$i])) {
                    $size = round($this->z[$i] * $higher_value_size / $this->higher_value);
                    $x1   = $this->graphic_area_x1 + 1;
                    $y1   = $this->graphic_area_y1 + $y + 10;
                    $x2   = $x1 + $size;
                    $y2   = $y1 + 15;

                    imageline($this->img, $x1    , $y2 + 1, $x2    , $y2 + 1, $this->color['2_shadow']);
                    imageline($this->img, $x1    , $y2 + 2, $x2    , $y2 + 2, $this->color['2_shadow']);
                    imageline($this->img, $x2 + 1, $y1 + 1, $x2 + 1, $y2 + 2, $this->color['2_shadow']);

                    imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $this->color['2']);
                    imagestring($this->img, 3, $x2 + 7, $y1 + 7, $this->_numberFormated($this->z[$i], 2), $this->color['2_shadow']);
                }

                $size = round(($this->y[$i] / $this->higher_value) * $higher_value_size);
                $x1   = $this->graphic_area_x1 + 1;
                $y1   = $this->graphic_area_y1 + $y;
                $x2   = $x1 + $size;
                $y2   = $y1 + 15;
                $y   += $this->spaceBetweenBars;

                imageline($this->img, $x1    , $y2 + 1, $x2    , $y2 + 1, $this->color['1_shadow']);
                imageline($this->img, $x1    , $y2 + 2, $x2    , $y2 + 2, $this->color['1_shadow']);
                imageline($this->img, $x2 + 1, $y1 + 1, $x2 + 1, $y2 + 2, $this->color['1_shadow']);

                imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $this->color['1']);
                imagestring($this->img, 3, $x2 + 7, $y1 + 2, $this->_numberFormated($this->y[$i], 2), $this->color['1_shadow']);

                imagestring($this->img, 3, ($x1 - ((strlen($parameter) * 7) + 7)), $y1 + 2, $parameter, $this->color['axis_values']);
            }
        } elseif (ereg("^(3|4)$", $this->type)) {
            /*
             * Draw graphic: DOTS or LINE
             */
            $x = array();
            $y = array();

            $x[0]    = $this->graphic_area_x1 + 1;

            foreach ($this->x as $i => $parameter) {
                if ($this->graphic_2_exists === true) {
                    $size  = round($this->z[$i] * $higher_value_size / $this->higher_value);
                    $z[$i] = $this->graphic_area_y2 - $size;
                }

                $alt   = ((($i % 2 == 0) && (strlen($this->biggest_x) > 5)) ? 15 : 2);
                $size  = round($this->y[$i] * $higher_value_size / $this->higher_value);
                $y[$i] = $this->graphic_area_y2 - $size;

                if ($i != 0) {
                    imageline($this->img, $x[$i], $this->graphic_area_y1 + 10, $x[$i], $this->graphic_area_y2 - 1, $this->color['bg_lines']);
                }
                imagestring($this->img, 3, ($x[$i] - (strlen($parameter) * 7 / 2)), $this->graphic_area_y2 + $alt + 2, $parameter, $this->color['axis_values']);

                $x[$i+1] = $x[$i] + 40;
            }

            foreach ($x as $i => $value_x) {
                if ($this->graphic_2_exists == true) {
                    if (isset($z[$i + 1])) {
                        // Draw lines
                        if ($this->type == 4) {
                            imageline($this->img, $x[$i], $z[$i]    , $x[$i + 1], $z[$i + 1]    , $this->color['2']);
                            imageline($this->img, $x[$i], $z[$i] + 1, $x[$i + 1], $z[$i + 1] + 1, $this->color['2']);
                        }

                        imagefilledrectangle($this->img, $x[$i] - 1, $z[$i] - 1, $x[$i] + 2, $z[$i] + 2, $this->color['2']);
                    } else { // Draw last dot
                        imagefilledrectangle($this->img, $x[$i - 1] - 1, $z[$i - 1] - 1, $x[$i - 1] + 2, $z[$i - 1] + 2, $this->color['2']);
                    }
                }

                if (count($y) > 1) {
                    if (isset($y[$i + 1])) {
                        // Draw lines
                        if ($this->type == 4) {
                            imageline($this->img, $x[$i], $y[$i]    , $x[$i + 1], $y[$i + 1]    , $this->color['1']);
                            imageline($this->img, $x[$i], $y[$i] + 1, $x[$i + 1], $y[$i + 1] + 1, $this->color['1']);
                        }

                        imagefilledrectangle($this->img, $x[$i] - 1, $y[$i] - 1, $x[$i] + 2, $y[$i] + 2, $this->color['1']);
                    }
                    else { // Draw last dot
                        imagefilledrectangle($this->img, $x[$i - 1] - 1, $y[$i - 1] - 1, $x[$i - 1] + 2, $y[$i - 1] + 2, $this->color['1']);
                    }
                }
            }
        } elseif (ereg("^(5|6)$", $this->type)) {
            /*
             * Draw graphic: PIE or DONUT
             */
            //ImageFilledRectangle($this->img, $this->graphic_area_x1, $this->graphic_area_y1, $this->graphic_area_x2, $this->graphic_area_y2, $this->color[$color]);

            $center_x = (int) ($this->graphic_area_x1 + $this->graphic_area_x2) / 2;
            $center_y = (int) ($this->graphic_area_y1 + $this->graphic_area_y2) / 2;
            $width    = $this->graphic_area_width;
            $height   = $this->graphic_area_height;
            //$start    = 0;
            $sizes    = array();

            $keys = array_keys($this->x);
            foreach ($keys as $i) {
                //var_dump('---------------------------------------------------');
                //var_dump($this->x[$i]);
                //var_dump($this->sumTotal);
                //var_dump($this->y[$i]);
                if ($this->sumTotal > 0) {
                    if ($this->y[$i] > 0) {
                        $size = round(($this->y[$i] * 360 / $this->sumTotal), 0);
                    } else {
                        $size = 0;
                    }
                } else {
                    $size = 0;
                }

                $sizes[] = $size;
                //var_dump($size);
                //$start  += $size;
            }

            $start = -90;

            if ($this->type == 5) {
                // Draw PIE

                // Draw shadow
                foreach ($sizes as $i => $size) {
                    //var_dump('---------------------------------------------------');
                    //var_dump($this->x[$i]);
                    //var_dump($start);
                    //var_dump($size);
                    $num_color = $i + 1;

                    while ($num_color > 9) {
                        $num_color -= 9;
                    }

                    if ($size > 0) {
                        $color = $num_color . '_shadow';

                        for ($i = 10; $i >= 0; $i -= 1) {
                            imagearc($this->img, (int) ($center_x - ($i / 2)), (int) ($center_y + ($i / 2)), $width, $height, $start, $start + $size, $this->color[$color] );
                            //imagefilledarc($this->img, (int) ($center_x - ($i / 2)), (int) ($center_y + ($i / 2)), $width, $height, $start, $start + $size, $this->color[$color], IMG_ARC_NOFILL);
                        }
                        //imagefilledarc($this->img, $center_x, $center_y, $width, $height, $start, $start + $size, $this->color[$color], IMG_ARC_NOFILL);

                        $start += $size;
                    }
                    //var_dump($start);
                }

                $start = -90;

                // Draw pieces
                foreach ($sizes as $i => $size) {
                    $num_color = $i + 1;

                    while ($num_color > 9) {
                        $num_color -= 9;
                    }

                    if ($size > 0) {
                        $color = $num_color;

                        imagefilledarc($this->img, $center_x, $center_y, $width + 2, $height + 2, $start, $start + $size, $this->color[$color], IMG_ARC_EDGED);
                        //imagefilledarc($this->img, $center_x-2, $center_y-2, $width, $height, $start, $start + $size, $this->color[$color], IMG_ARC_PIE);
                        $start += $size;
                    }
                }
            } elseif ($this->type == 6) {
                // Draw DONUT

                foreach ($sizes as $i => $size) {
                    $num_color    = $i + 1;

                    while ($num_color > 9) {
                        $num_color -= 9;
                    }

                    if ($size > 0) {
                        $color        = $num_color;
                        //$color_shadow = $num_color . '_shadow';

                        imagefilledarc($this->img, $center_x, $center_y, $width, $height, $start, $start + $size, $this->color[$color], IMG_ARC_PIE);
                        $start += $size;
                    }
                }

                if (is_array($this->bgcolor)) {
                    imagefilledarc($this->img, $center_x, $center_y, 100, 100, 0, 360, imagecolorallocate($this->img, $this->bgcolor[0], $this->bgcolor[1], $this->bgcolor[2]), IMG_ARC_PIE);
                } else {
                    imagefilledarc($this->img, $center_x, $center_y, 100, 100, 0, 360, $this->color['background'], IMG_ARC_PIE);
                }

                imagearc($this->img, $center_x, $center_y, 100, 100, 0, 360, $this->color['bg_legend']);
                imagearc($this->img, $center_x, $center_y, $width + 1, $height + 1, 0, 360, $this->color['bg_legend']);
            }
        }

        //imageline($this->img, $this->legend_box_x2, $this->graphic_area_y1, $this->legend_box_x2, $this->graphic_area_y2, $this->color['bg_lines']);

        if ($this->credits) {
            $this->_drawCredits();
        }

        if ($file_name != '') {
            //echo "1";
            imagepng( $this->img, $file_name );
            //echo "2";
        } else {
            header('Content-type: image/png');
            imagepng($this->img);
        }

        imagedestroy($this->img);

        if ($file_name == '') {
            exit;
        }
    }

    // }}}
    // {{{ _calculateWidth

    /**
     * Function _calculateWidth
     *
     * calculates the Width of the Graphic
     *
     * @access private
     * @return void
     */
    private function _calculateWidth()
    {
        $this->legend_box_width   = (($this->legendExists === true) ? ($this->_stringWidth($this->biggestGraphicName, 3) + 25) : 0);

        switch ($this->type) {
            // Vertical bars
            case 1:
                //$this->legend_box_width   = (($this->legendExists === true) ? ($this->_stringWidth($this->biggestGraphicName, 3) + 25) : 0);
                $this->graphic_area_width = $this->spaceBetweenBars * $this->totalParameters + 30;
                $this->graphic_area_x1   += $this->_stringWidth(($this->higher_value_str), 3);
                //$this->width  = $this->graphic_area_x1;
                //$this->width += (($this->legendExists === true) ? ($this->_stringWidth($this->axis_y, 3) + 25) : 10);
                break;
            // Horizontal bars
            case 2:
                //$this->legend_box_width   = (($this->legendExists === true) ? ($this->_stringWidth($this->biggestGraphicName, 3) + 25) : 0);
                $this->graphic_area_width = (($this->_stringWidth($this->higher_value_str, 3) > 50) ? (5 * ($this->_stringWidth($this->higher_value_str, 3)) * 0.85) : 200);
                $this->graphic_area_x1   += 7 * strlen($this->biggest_x);
                //$this->width += (($this->legendExists === true) ? ($this->_stringWidth($this->axis_y, 3) + 25) : 10);
                //$this->width  = $this->graphic_area_x1;
                break;
            // Dots, Lines
            case 3: case 4:
                //$this->legend_box_width   = (($this->legendExists === true) ? ($this->_stringWidth($this->biggestGraphicName, 3) + 25) : 0);
                $this->graphic_area_width = $this->space_between_dots * $this->totalParameters - 10;
                $this->graphic_area_x1   += $this->_stringWidth(($this->higher_value_str), 3);
                //$this->width  = $this->graphic_area_x1;
                //$this->width += (($this->legendExists === true) ? ($this->_stringWidth($this->axis_y, 3) + 25) : 10);
                break;
            // Pie, Donut
            case 5: case 6:
                $this->legend_box_width   = $this->_stringWidth($this->biggest_x, 3) + 85;
                $this->graphic_area_width = 500;
                $this->graphic_area_x1    = 90;
                break;
        }
        /*
        $this->width  = $this->graphic_area_x1 + 25;
        if ($this->legendExists !== true) {
            if ($this->type == 2) {
                $this->width    += $this->_stringWidth($this->axis_x, 3);
            } else {
                $this->width    += $this->_stringWidth($this->axis_y, 3);
            }
        } else {
            $this->width    += $this->legend_box_width;
        }
        */
        $this->graphic_area_x2 = $this->graphic_area_x1 + $this->graphic_area_width;
        $this->legend_box_x1   = $this->graphic_area_x2 + 10;
        $this->legend_box_x2   = $this->legend_box_x1 + $this->legend_box_width;

        if ($this->legendExists !== true) {
            //$this->width    = $this->legend_box_x2 + $this->_stringWidth($this->axis_x, 3) + 20;
            if ($this->type == 2) {
                $this->width    = $this->legend_box_x2 + $this->_stringWidth($this->axis_y, 3) + 20;
            } else {
                $this->width    = $this->legend_box_x2 + $this->_stringWidth($this->axis_x, 3) + 20;
            }
        } else {
            $this->width    = $this->legend_box_x2 + 20;
        }
    }

    // }}}
    // {{{ _calculateHeight

    /**
     * Function _calculateHeight
     *
     * calculates the Height of the Graphic
     *
     * @access private
     * @return void
     */
    private function _calculateHeight()
    {
        $this->legend_box_height   = ((!empty($this->axis_x)) ? 30 : 5);

        switch ($this->type) {
            // Vertical bars, Dots, Lines
            case 1: case 3: case 4:
                $this->legend_box_height  += (($this->graphic_2_exists === true) ? 10 : 0);
                $this->graphic_area_height = 300;
                $this->height += 65;
                break;
            // Horizontal bars
            case 2:
                $this->legend_box_height  += (($this->graphic_2_exists === true) ? 10 : 0);
                $this->graphic_area_height = $this->spaceBetweenBars * $this->totalParameters + 10;
                $this->height += 65;
                break;
            // Pie, Donut
            case 5: case 6:
                $this->legend_box_height  += (14 * $this->totalParameters);
                $this->graphic_area_height = 500;
                $this->height += 50;
                break;
        }

        $this->height += $this->heightTitle;
        $this->height += ( ( $this->legend_box_height > $this->graphic_area_height ) ? ( $this->legend_box_height - $this->graphic_area_height ) : 0 );
        $this->height += $this->graphic_area_height;

        $this->graphic_area_y2 = $this->graphic_area_y1 + $this->graphic_area_height;

        $this->legend_box_y1   = $this->graphic_area_y1 + 10;
        $this->legend_box_y2   = $this->legend_box_y1 + $this->legend_box_height;
    }

    // }}}
    // {{{ _drawLegend

    /**
     * Function _drawLegend
     *
     * creates the Legend for the Graphic
     *
     * @access private
     * @return void
     */
    private function _drawLegend()
    {
        $x1 = $this->legend_box_x1;
        $y1 = $this->legend_box_y1;
        $x2 = $this->legend_box_x2;
        $y2 = $this->legend_box_y2;

        imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $this->color['bg_legend']);

        $x = $x1 + 5;
        $y = $y1 + 5;

        if (ereg("^(1|2|3|4)$", $this->type)) {
            // Draw legend values for VERTICAL BARS, HORIZONTAL BARS, DOTS and LINES
            $color_1 = ((ereg("^(1|2)$", $this->type)) ? $this->color['1'] : $this->color['1']);
            $color_2 = ((ereg("^(1|2)$", $this->type)) ? $this->color['2'] : $this->color['2']);

            imagefilledrectangle($this->img, $x, $y, $x + 10, $y + 10, $color_1);
            imagerectangle($this->img, $x, $y, $x + 10, $y + 10, $this->color['title']);
            imagestring($this->img, 3, $x + 15, $y - 2, $this->graphic_1, $this->color['axis_values']);
            $y += 20;

            if ($this->graphic_2 != '') {
                imageline($this->img, $x1 + 5, $y - 5, $x2 - 5, $y - 5, $this->color['bg_lines']);

                imagefilledrectangle($this->img, $x, $y, $x + 10, $y + 10, $color_2);
                imagerectangle($this->img, $x, $y, $x + 10, $y + 10, $this->color['title']);
                imagestring($this->img, 3, $x + 15, $y - 2, $this->graphic_2, $this->color['axis_values']);
            }
        } elseif (ereg("^(5|6)$", $this->type)) {
            // Draw legend values for PIE or DONUT
            if ( !empty( $this->axis_x ) ) {
                imagestring($this->img, 3, ((($x1 + $x2) / 2) - (strlen($this->axis_x) * 7 / 2)), $y, $this->axis_x, $this->color['title']);
                $y += 25;
            }

            $num = 1;

            foreach ( $this->x as $i => $parameter ) {
                while ($num > 9) {
                    $num -= 9;
                }

                $color = $num;

                if ($this->sumTotal > 0) {
                    $percent = number_format(round(($this->y[$i] * 100 / $this->sumTotal), 2), 2, '.', '') . ' %';
                } else {
                    $percent = '100 %';
                }
                $less    = (strlen($percent) * 7);

                if ( $num != 1 ) {
                    imageline($this->img, $x1 + 20, $y - 2, $x2 - 5, $y - 2, $this->color['bg_lines']);
                }

                imagefilledrectangle($this->img, $x, $y, $x + 10, $y + 10, $this->color[$color]);
                imagerectangle($this->img, $x, $y, $x + 10, $y + 10, $this->color['title']);
                imagestring($this->img, 3, $x + 15,     $y - 2, $parameter, $this->color['axis_values']);
                imagestring($this->img, 2, $x2 - $less, $y - 2, $percent,   $this->color['axis_values']);

                $y += 14;
                $num++;
            }
        }
    }

    // }}}
    // {{{ _stringWidth

    /**
     * Function _stringWidth
     *
     * calculates the Width of a Text
     *
     * @param string  $string the Text should be displayed
     * @param integer $size   the Test size
     *
     * @access private
     * @return integer the Width of the Text in Pixels
     */
    private function _stringWidth($string, $size)
    {
        $single_width = (int) $size + 4;
        return (int) $single_width * strlen( (string) $string );
    }

    // }}}
    // {{{ _stringHeight

    /**
     * Function _stringHeight
     *
     * calculates the Height of a Text
     *
     * @param integer $size the Test size
     *
     * @access public
     * @return integer the Height of the Text in Pixels
     */
    private function _stringHeight($size)
    {
        if ($size <= 1) {
            $height = 8;
        } elseif ($size <= 3) {
            $height = 12;
        } elseif ($size >= 4) {
            $height = 14;
        } else {
            $height = 16;
        }

        return $height;
    }

    // }}}
    // {{{ _calculateHigherValue

    /**
     * Function _calculateHigherValue
     *
     * calculates the next Value for the Y-Axis from the highest Y-Value
     *
     * @access public
     */
    private function _calculateHigherValue()
    {
        $digits                 = strlen(round($this->biggest_y));
        $interval               = pow(10, ($digits - 1));
        $this->higher_value     = round(($this->biggest_y - ($this->biggest_y % $interval) + $interval), 1);
        $this->higher_value_str = $this->_numberFormated($this->higher_value);
    }

    // }}}
    // {{{ _numberFormated

    /**
     * Function _numberFormated
     *
     * formats a number
     *
     * @param mixed   $number   the number to be formated
     * @param integer $dec_size the cound of numbers for rounding the number
     *
     * @access private
     * @return string the formated number
     */
    private function _numberFormated($number, $dec_size = 1)
    {
        $dec_size = (int) $dec_size;
        $number   = (string) $number;

        if ($this->latinNotation === true) {
            return (string) number_format(round($number, $dec_size), $dec_size, ',', '.');
        } else {
            return (string) number_format(round($number, $dec_size), $dec_size, '.', ',');
        }
    }

    // }}}
    // {{{ _numberFloat

    /**
     * Function _numberFloat
     *
     * formats a number to a Float
     *
     * @param mixed $number the number to be formated
     *
     * @access public
     * @return float the formated number
     */
    private function _numberFloat($number)
    {
        $number = (string) $number;

        if ($this->latinNotation === true) {
            $number = str_replace('.', '', $number);
            return (float) str_replace(',', '.', $number);
        } else {
            return (float) str_replace(',', '', $number);
        }
    }

    // }}}
    // {{{ _drawCredits

    /**
     * Function _drawCredits
     *
     * Draws a Credits-Message into the Graphic
     *
     * @access private
     * @return void
     * @deprecated
     */
    private function _drawCredits()
    {
        imagestring($this->img, 1, $this->width - 120, $this->height - 10, 'Powered by ' . $this->author, $this->color['title']);
    }

    // }}}
    // {{{ _loadColorPalette

    /**
     * Function _loadColorPalette
     *
     * returns tha value for a specified data column, which stores dates about files
     *
     * @param pointer $parent   the parent Class.
     * @param string  $item_key name of the field, which contains data record
     * @param string  $table    name of the table, which contains data record
     * @param integer $uid      ID of the content row, which contains data record
     *
     * @static
     * @access public
     * @return array the files array
     */
    private function _loadColorPalette()
    {
        switch ($this->skin) {
            // Office
            case 1:
                $this->color['title']       = imagecolorallocate($this->img,   0,   0, 100);
                $this->color['background']  = imagecolorallocate($this->img, 255, 255, 255);
                $this->color['axis_values'] = imagecolorallocate($this->img,  50,  50,  50);
                $this->color['axis_line']   = imagecolorallocate($this->img, 100, 100, 100);
                $this->color['bg_lines']    = imagecolorallocate($this->img, 240, 240, 240);
                $this->color['bg_legend']   = imagecolorallocate($this->img, 205, 205, 205);

                $this->color['1'] = imagecolorallocate($this->img, 100, 150, 200);
                $this->color['2'] = imagecolorallocate($this->img, 200, 250, 150);
                $this->color['3'] = imagecolorallocate($this->img, 250, 200, 150);
                $this->color['4'] = imagecolorallocate($this->img, 250, 150, 150);
                $this->color['5'] = imagecolorallocate($this->img, 250, 250, 150);
                $this->color['6'] = imagecolorallocate($this->img, 230, 180, 250);
                $this->color['7'] = imagecolorallocate($this->img, 200, 200, 150);
                $this->color['8'] = imagecolorallocate($this->img, 230, 100, 100);
                $this->color['9'] = imagecolorallocate($this->img,   0,   0,   0);

                $this->color['1_shadow'] = imagecolorallocate($this->img,  60, 110, 170);
                $this->color['2_shadow'] = imagecolorallocate($this->img, 120, 170,  70);
                $this->color['3_shadow'] = imagecolorallocate($this->img, 180, 120,  70);
                $this->color['4_shadow'] = imagecolorallocate($this->img, 170, 100, 100);
                $this->color['5_shadow'] = imagecolorallocate($this->img, 180, 180, 110);
                $this->color['6_shadow'] = imagecolorallocate($this->img, 160, 110, 190);
                $this->color['7_shadow'] = imagecolorallocate($this->img, 140, 140, 100);
                $this->color['8_shadow'] = imagecolorallocate($this->img,  50, 100, 150);
                $this->color['9_shadow'] = imagecolorallocate($this->img,  25,  25,  25);

                break;
            // Matrix
            case 2:
                $this->color['title']       = imagecolorallocate($this->img, 255, 255, 255);
                $this->color['background']  = imagecolorallocate($this->img,   0,   0,   0);
                $this->color['axis_values'] = imagecolorallocate($this->img,   0, 230,   0);
                $this->color['axis_line']   = imagecolorallocate($this->img,   0, 200,   0);
                $this->color['bg_lines']    = imagecolorallocate($this->img, 100, 100, 100);
                $this->color['bg_legend']   = imagecolorallocate($this->img,  70,  70,  70);

                $this->color['1'] = imagecolorallocate($this->img,  50, 200,  50);
                $this->color['2'] = imagecolorallocate($this->img, 255, 255, 255);
                $this->color['3'] = imagecolorallocate($this->img, 160, 200, 160);
                $this->color['4'] = imagecolorallocate($this->img, 135, 180, 135);
                $this->color['5'] = imagecolorallocate($this->img, 115, 160, 115);
                $this->color['6'] = imagecolorallocate($this->img, 100, 140, 100);
                $this->color['7'] = imagecolorallocate($this->img,  90, 120,  90);
                $this->color['8'] = imagecolorallocate($this->img, 220, 220, 220);
                $this->color['9'] = imagecolorallocate($this->img,   0,   0,   0);

                $this->color['1_shadow'] = imagecolorallocate($this->img, 200, 220, 200);
                $this->color['2_shadow'] = imagecolorallocate($this->img, 160, 200, 160);
                $this->color['3_shadow'] = imagecolorallocate($this->img, 135, 180, 135);
                $this->color['4_shadow'] = imagecolorallocate($this->img, 115, 160, 115);
                $this->color['5_shadow'] = imagecolorallocate($this->img, 100, 140, 100);
                $this->color['6_shadow'] = imagecolorallocate($this->img,  90, 120,  90);
                $this->color['7_shadow'] = imagecolorallocate($this->img,  85, 100,  85);
                $this->color['8_shadow'] = imagecolorallocate($this->img,   0, 150,   0);
                $this->color['9_shadow'] = imagecolorallocate($this->img,  25,  25,  25);

                break;
            // Spring
            case 3:
                $this->color['title']       = imagecolorallocate($this->img, 250,  50,  50);
                $this->color['background']  = imagecolorallocate($this->img, 250, 250, 220);
                $this->color['axis_values'] = imagecolorallocate($this->img,  50, 150,  50);
                $this->color['axis_line']   = imagecolorallocate($this->img,  50, 100,  50);
                $this->color['bg_lines']    = imagecolorallocate($this->img, 200, 224, 180);
                $this->color['bg_legend']   = imagecolorallocate($this->img, 230, 230, 200);

                $this->color['1'] = imagecolorallocate($this->img, 255, 170,  80);
                $this->color['2'] = imagecolorallocate($this->img, 250, 230,  80);
                $this->color['3'] = imagecolorallocate($this->img, 250, 200, 150);
                $this->color['4'] = imagecolorallocate($this->img, 250, 150, 150);
                $this->color['5'] = imagecolorallocate($this->img, 250, 250, 150);
                $this->color['6'] = imagecolorallocate($this->img, 230, 180, 250);
                $this->color['7'] = imagecolorallocate($this->img, 200, 200, 150);
                $this->color['8'] = imagecolorallocate($this->img, 100, 150, 200);
                $this->color['9'] = imagecolorallocate($this->img,   0,   0,   0);

                $this->color['1_shadow'] = imagecolorallocate($this->img,  60, 110, 170);
                $this->color['2_shadow'] = imagecolorallocate($this->img, 120, 170,  70);
                $this->color['3_shadow'] = imagecolorallocate($this->img, 180, 120,  70);
                $this->color['4_shadow'] = imagecolorallocate($this->img, 170, 100, 100);
                $this->color['5_shadow'] = imagecolorallocate($this->img, 180, 180, 110);
                $this->color['6_shadow'] = imagecolorallocate($this->img, 160, 110, 190);
                $this->color['7_shadow'] = imagecolorallocate($this->img, 140, 140, 100);
                $this->color['8_shadow'] = imagecolorallocate($this->img, 200, 120,  30);
                $this->color['9_shadow'] = imagecolorallocate($this->img,  25,  25,  25);

                break;
        }
    }

    // }}}
    // {{{ resetValues

    /**
     * Function resetValues
     *
     * resets the input parameters
     *
     * @access public
     * @return void
     */
    public function resetValues()
    {
        $this->title     = null;
        $this->axis_x    = null;
        $this->axis_y    = null;
        $this->type      = null;
        $this->skin      = null;
        $this->graphic_1 = null;
        $this->graphic_2 = null;
        $this->credits   = null;

        $this->x = $this->y = $this->z = array();

        // added by Thomas Mueller - start
        $this->biggest_x        = null;
        $this->biggest_y        = null;
        $this->alternate_x      = false;
        $this->graphic_2_exists = false;
        $this->totalParameters  = 0;
        $this->sumTotal         = 0;

        $this->space_between_dots = 40;
        $this->higher_value       = 0;
        $this->higher_value_str   = 0;

        $this->width               = 0;
        $this->height              = 0;
        $this->graphic_area_width  = 0;
        $this->graphic_area_height = 0;
        $this->graphic_area_x1     = 30;
        // added by Thomas Mueller - end
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