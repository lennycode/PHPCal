<?php
 

class Rect {
 
    var $xtop;
    var $ytop;
    var $xbot;
    var $ybot;
    var $zones;
    private $zoneheight;
    private $width;
    public static $calheight = 10;
    public static $calwidth =22;
    public static $caldesignwidth ;
    public static $aspect = 3/4;
    /**
     * Model a calendar box and divide it into horizonal slices.
     * @param type $xlt
     * @param type $ylt
     * @param type $xlb
     * @param type $ylb
     * @param type $zones
     */
    public function __construct($xlt, $ylt,$xlb, $ylb, $zones = 3) {
        $this->xtop = $xlt;
        $this->ytop = $ylt;
        $this->xbot = $xlb;
        $this->ybot = $ylb;
        
        
        $this->zones = $zones; //Todo: Make static
        $this->zoneheight= $this->compute_zone_height($zones);
        $this->width = $this->compute_width();
        
    }
    
    private function compute_zone_height($zonecount){
        return abs($this->ybot - $this->ytop) /$zonecount;
    }
     
    private function compute_width(){
        return abs($this->xbot - $this->xtop);
    }
    
    public function center_text_in_zone($textw, $texth, $zonelevel, $vpadding =10, $centerbothdim = true){
        //Padding is based on a height of 800 (10 pixels).
        $ch = Rect::$calheight;
        $cw = Rect::$calwidth;
        $padpixels = ($ch/Rect::$caldesignwidth)*$vpadding ;
        $halfwidth = $textw /2;
        $halfheight = $texth /2;
        $yoffset = $zonelevel * $this->zoneheight;
        $xpos = $this->xtop+ $this->width /2 - $halfwidth;
        $ypos = $this->ytop + $yoffset + $vpadding + $this->zoneheight/2 - $halfheight;
        return new Point($xpos,$ypos);
    }
    
     public function left_text_in_zone($textw, $texth, $zonelevel,$paddingx =5, $paddingy=25, $centerbothdim = true){
        $ch = Rect::$calheight;
        $cw = Rect::$calwidth;
        $padpixelsx = ($ch/Rect::$caldesignwidth)*$paddingx;
        $padpixelsy = ($ch/Rect::$caldesignwidth*Rect::$aspect)*$paddingy;
        $yoffset = $zonelevel * $this->zoneheight;
        $xpos = $this->xtop+ $padpixelsx;
        $ypos = $this->ytop + $yoffset + $texth +$padpixelsy ;
        return new Point($xpos,$ypos);
    }
   
      public function right_text_in_zone($textw, $texth, $zonelevel,$paddingx =5, $paddingy=25, $centerbothdim = true){
        $ch = Rect::$calheight;
        $cw = Rect::$calwidth;
        $padpixelsx = ($ch/Rect::$caldesignwidth)*$paddingx;
        $padpixelsy = ($ch/Rect::$caldesignwidth*Rect::$aspect)*$paddingy;
        $yoffset = $zonelevel * $this->zoneheight;
        $xpos = ($this->xtop+$this->width)- ($textw + $padpixelsx);
        $ypos = $this->ytop + $yoffset + $texth +$padpixelsy ;
        return new Point($xpos,$ypos);
    }
    
}
 