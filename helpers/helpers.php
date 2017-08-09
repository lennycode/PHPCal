<?php 
  

/**
 * Helper for drawing centered tasks
 * 
 * @global string $font_file
 * @global type $text_color
 * @param type $im
 * @param type $text
 * @param type $font_size
 * @param type $zone
 * @param type $box
 */
function render_text_centered($im, $text,$font_size, $zone, $box){
    global $font_file;
    global $text_color;
    $type_space = imagettfbbox($font_size, 0, $font_file, $text);
    $fw = $type_space[4];
    $fh = abs($type_space[7]);
    $px = $box->center_text_in_zone($fw,$fh,$zone);
    imagettftext($im ,$font_size, 0, $px->x, $px->y, $text_color, $font_file, $text);
}

/**
 * Helper for Drawing days (or left justified things)
 * @global string $font_file
 * @global type $text_color
 * @param type $im
 * @param type $text
 * @param type $font_size
 * @param type $zone
 * @param type $box
 */
function render_text_left($im, $text,$font_size, $zone, $box){
    global $font_file;
    global $text_color;
    $type_space = imagettfbbox(($font_size), 0, $font_file, $text);
    $fw = $type_space[4];
    $fh = abs($type_space[7]);
    $px = $box->left_text_in_zone($fw,$fh,$zone);
    //pretty_dump($px);
    imagettftext($im ,$font_size, 0, $px->x, $px->y, $text_color, $font_file, $text);
}
 
/**
  * Adjust for the upper boxes that are designed to show the days of the week
  * @param type $month
  * @param type $year
  * @param type $days
  * @return type
  */
function convert_date_to_offset($month,$year,$days){
    $day = date('D',mktime(0, 0, 0,  $month,1,$year));
    for  ($ct = 0; $ct < sizeof($days); $ct++ ) {
        if ($day == $days[$ct]){
            return (6 + $ct); }
        else{
        }     
    }
}


function fontscaler ($font_size){
    global $width;    
    return ($width/1000)*$font_size;
}

function get_heading($month,$year ){
    return date('M',mktime(0, 0, 0,  $month,1,$year)) ." ". date('Y',mktime(0, 0, 0,  $month,1,$year));
      
}

function pretty_dump($px){
    echo ("<pre>");
    var_dump($px);
    echo ("</pre>");
}

/**
 * Write to transparancy channel of certain pixels
 * @param type $im
 * @param type $future
 */
function write_index_in_image($im, $future = ""){
    $today = str_split(strval(getdate()[0]) );
    //TODO: different dates and times will place this in different areas.
    //this will be used for OCR.
    for($i=0;$i<  sizeof($today)-1;$i++){
        $color = imagecolorallocatealpha (   $im  , 0xDD, 0xDD, 0xDD, $today[$i] );
        imagesetpixel ( $im , 2 + $i, 2,   $color );
    }
 }

function image_security($img){
    $salt= ')(*U$J@W*8i0wquj3mn8q09f[h2q3n(*&@#@98h432hnfc';
//    $x = imagesx($img);
//    $y = imagesx($img);
//    for ($i=0; $i<$x-1; $i++){
//        for ($j=0; $j<$y-1; $j++){
//           // $rgb = imagecolorsforindex ($img, imagecolorat($img, $i, $j));
//            $rgb+= imagecolorat($img, $i, $j);
//            //$sum = ($rgb["red"]  + $rgb["green"] +$rgb["blue"] + $rgb["alpha"]+ $y%$x);
//            //$check += $sum;
//        }   
//    }
    return (md5($img+rect::$calheight+rect::$calwidth+ salt));
}