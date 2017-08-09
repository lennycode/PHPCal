<?php
 
require_once  'classes/Point.php';
require_once 'classes/Rect.php';
require_once 'helpers/helpers.php';
 


$font_file = 'fonts/DejaVuSans.ttf'; // This is the path to your font file.
if(!file_exists($font_file)){
    die('Modify the script to find your system fonts(line 92)! ');
}

//DO NOT OUTPUT ANYTHING IMPORTANT BEFORE THIS~~~~!!!!!!!!!!!!

if (!isset($_GET["month"]) && !isset($_GET["year"])) {
     echo '<h1>Usage: cal.php?month=8&year=2017</h1>';
     echo '<h2>Optional: &days=Sun,Mon,Tue,Wed,Thu,Fri,Sat&activity_days=3,4,5&activity_action=work,school,vacation&size=800</h2>';
     die();
} else {
    header("Content-Type: image/png");
    $month = htmlspecialchars($_GET["month"]);
    $year = htmlspecialchars($_GET["year"]);
}

   
if (!isset($_GET["size"])){
    $width =800;
     
} else {
    $width = htmlspecialchars($_GET["size"]);
 }
$aspect= .75;
            
$height = $width * $aspect;
Rect::$calheight = $height;
Rect::$calwidth = $width; 
Rect::$caldesignwidth = 1000;
//GD, Are you alive?
$im = @imagecreate($width, $height)
    or die("Cannot Initialize GD image - Check PHP Config ");

//Todo::Sanitize and check for reasonable data
if (!isset($_GET["days"])){
    $days = "Sun,Mon,Tue,Wed,Thu,Fri,Sat";
}else {
    $days = htmlspecialchars($_GET["days"]);
}

$days = explode(",", $days); // need to be able to start calendar on any day.

 
if (!(isset($_GET["activity_days"]) &&  isset($_GET["activity_action"]))){
    $activity_days = "14,21,27";
    $activity_action ="pay22,test34,complete84b";
} else {
    $activity_days = htmlspecialchars($_GET["activity_days"]);
    $activity_action =htmlspecialchars($_GET["activity_action"]);
}

$activity_days = explode(",", $activity_days);
$activity_action = explode(",", $activity_action);
            

$day_offset = convert_date_to_offset($month,$year,$days);
     
$day_array_offset = convert_date_to_offset($month, $year, $days);
$text = get_heading($month, $year);


$font_size = fontscaler(25); // Font size is in pixels.



$number_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
// Retrieve bounding box:
$type_space = imagettfbbox($font_size, 0, $font_file, $text);
$fw = $type_space[4];
//set the background color of the image
$background_color = imagecolorallocate($im, 0xDD, 0xDD, 0xDD);
//set the color for the text
$text_color = imagecolorallocate($im, 133, 14, 91);
$hdivs = 7;
$vdivs = 6;
//Divide the canvas into calendar boxes
$hspace = $width / $hdivs;
$vspace = $height /$vdivs;
//Leave margin!
$boxes = [];
$boxcount = 0;

//TODO: Refactor below into a class or functions
$vboxsz=0;
$hboxsz =0;
//create the structure and datamodel for the calendar.
for ($j=0;$j<$vdivs ;$j++){
    
    @imageline ( $im  ,  0 , $vboxsz , $width, $vboxsz , $text_color );   
    
    //echo $i;
    for ($i=0;$i<$hdivs ;$i++){
    //echo $j;    
        @imageline ( $im  ,  $hboxsz , $vspace , $hboxsz , $height , $text_color );
        
        $boxes[$boxcount++] = new Rect( $hboxsz,$vboxsz,$hboxsz+$hspace,$vboxsz+$vspace);
        $hboxsz += $hspace;
    }
    $hboxsz =0;
    $vboxsz += $vspace;
}

//These lines may not be drawn , so here goes
@imageline ( $im  ,  $width-1 , 0 , $width-1 , $height , $text_color );
@imageline ( $im  ,  0 , $height-1 , $width-1 , $height-1 , $text_color );

$msg_font_sz = fontscaler(22);

//Render Text day of week
$ct = 0;
foreach ($days as $value) {
     render_text_centered($im,$value,$msg_font_sz,2,$boxes[$ct++]);
 }
  
 
 $day_font_size= fontscaler(20);
 
            
for ($k = 1; $k <=  $number_days_in_month;$k++){
    // echo $k+$day_offset;
      
    if( isset($boxes[$k+$day_offset])){
     render_text_left($im, $k ,  $day_font_size,2,$boxes[$k+$day_offset]);
      
    } else{
        $offset = $k+$day_offset-7;
          render_text_left($im, "     /".$k ,$day_font_size,2,$boxes[$offset]);
 
    }
}
 
$comment_font_size= fontscaler(14);
//render daily comments
for ($n = 0; $n < sizeof($activity_action);$n++){
    render_text_centered($im, $activity_action[$n]  ,$comment_font_size,1,$boxes[$activity_days[$n  ]+$day_offset]);
} 

//Render Heading
imagettftext($im , $font_size, 0, $width/2- ($fw/2), $vspace/2, $text_color, $font_file, $text);



//Just a test
//$msg_font_sz = fontscaler(10);
//$type_space = imagettfbbox($msg_font_sz, 0, $font_file, "Easter");
//$fw = $type_space[4];
//$fh = abs($type_space[7]);
//$px = $boxes[15]->center_text_in_zone($fw,$fh,1);
//imagettftext($im ,$msg_font_sz, 0, $px->x, $px->y, $text_color, $font_file, "Easter");

$security = true;
ob_start();
//Ship the image
if($security){ 
    
     $image_data = ob_get_contents ();
     write_index_in_image($im);
 }
imagepng($im);
ob_end_flush();
//imagepng($im);
//echo image_security(base64_encode($image_data));

//free resources
imagedestroy($im);
