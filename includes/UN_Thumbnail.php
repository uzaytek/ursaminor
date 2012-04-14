<?php

/*
##############################################
# Shiege Iseng Resize Class
# 11 March 2003
# shiegege_at_yahoo.com
# View Demo :
#   http://kentung.f2o.org/scripts/thumbnail/sample.php
################
# Thanks to :
# Dian Suryandari <dianhau_at_yahoo.com>
/*############################################
Sample :
$thumb=new thumbnail("./shiegege.jpg");	// generate image_file, set filename to resize
$thumb->size_width(100);		// set width for thumbnail, or
$thumb->size_height(300);		// set height for thumbnail, or
$thumb->size_auto(200);			// set the biggest width or height for thumbnail
$thumb->jpeg_quality(75);		// [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
$thumb->show();				// show your thumbnail
$thumb->save("./huhu.jpg");		// save your thumbnail to file
----------------------------------------------
Note :
- GD must Enabled
- Autodetect file extension (.jpg/jpeg, .png, .gif, .wbmp)
  but some server can't generate .gif / .wbmp file types
- If your GD not support 'ImageCreateTrueColor' function,
  change one line from 'ImageCreateTrueColor' to 'ImageCreate'
  (the position in 'show' and 'save' function)
*/


class UN_Thumbnail
{
	public $img;

	function __construct($imgfile)
	{
		//detect image format
	  $this->img['image_name'] = $imgfile;
	  $imgfile = PT_UPLOAD . $imgfile;
	  $this->img["format"]=ereg_replace(".*\.(.*)$","\\1",$imgfile);
	  $this->img["format"]=strtoupper($this->img["format"]);
	  if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
	    //JPEG
	    $this->img["format"]="JPEG";
	    $this->img["src"] = imagecreatefromjpeg($imgfile);
	  } elseif ($this->img["format"]=="PNG") {
	    //PNG
	    $this->img["format"]="PNG";
	    $this->img["src"] = imagecreatefrompng($imgfile);
	  } elseif ($this->img["format"]=="gif") {
	    //gif
	    $this->img["format"]="GIF";
	    $this->img["src"] = imagecreatefromgif($imgfile);
	  } elseif ($this->img["format"]=="wbmp") {
	    //wbmp
	    $this->img["format"]="WBMP";
	    $this->img["src"] = imagecreatefromwbmp($imgfile);
	  } else {
	    //default
	    die(sprintf(_('%s image file unsupported'),$this->img['format']));
	  }
	  @$this->img["lebar"] = imagesx($this->img["src"]);
	  @$this->img["tinggi"] = imagesy($this->img["src"]);
	  //default quality jpeg
	  $this->img["quality"]=90;
	  $this->size_auto(200);
	}

	function size_height($size=100)
	{
		//height
    	$this->img["tinggi_thumb"]=$size;
    	@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
	}

	function size_width($size=100)
	{
		//width
		$this->img["lebar_thumb"]=$size;
    	@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
	}

	function size_auto($size=100)
	{
		//size
		if ($this->img["lebar"]>=$this->img["tinggi"]) {
    		$this->img["lebar_thumb"]=$size;
    		@$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"]/$this->img["lebar"])*$this->img["tinggi"];
		} else {
	    	$this->img["tinggi_thumb"]=$size;
    		@$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"]/$this->img["tinggi"])*$this->img["lebar"];
 		}
	}

	function jpeg_quality($quality=90)
	{
		//jpeg quality
		$this->img["quality"]=$quality;
	}

	function show()
	{
		//show thumb
		@header("content-type: image/".$this->img["format"]);

		/* change imagecreatetruecolor to imagecreate if your gd not supported imagecreatetruecolor function*/
		$this->img["des"] = imagecreatetruecolor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
    		@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//jpeg
			imagejpeg($this->img["des"],"",$this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//png
			imagepng($this->img["des"]);
		} elseif ($this->img["format"]=="GIF") {
			//gif
			imagegif($this->img["des"]);
		} elseif ($this->img["format"]=="WBMP") {
			//wbmp
			imagewbmp($this->img["des"]);
		}
	}

	function save($save="")
	{
		//save thumb
     if (empty($save)) {$save=PT_UPLOAD . "thumb_".$this->img["image_name"];}
		/* change imagecreatetruecolor to imagecreate if your gd not supported imagecreatetruecolor function*/
		$this->img["des"] = imagecreatetruecolor($this->img["lebar_thumb"],$this->img["tinggi_thumb"]);
    		@imagecopyresized ($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

		if ($this->img["format"]=="JPG" || $this->img["format"]=="JPEG") {
			//jpeg
			imagejpeg($this->img["des"],"$save",$this->img["quality"]);
		} elseif ($this->img["format"]=="PNG") {
			//png
			imagepng($this->img["des"],"$save");
		} elseif ($this->img["format"]=="GIF") {
			//gif
			imagegif($this->img["des"],"$save");
		} elseif ($this->img["format"]=="WBMP") {
			//wbmp
			imagewbmp($this->img["des"],"$save");
		}
	}
}
?>
