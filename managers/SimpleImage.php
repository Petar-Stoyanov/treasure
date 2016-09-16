<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Modified by: Miguel Fermín
* Based in: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*/

class SimpleImage {
   
	var $image;
	var $image_type;

	function __construct($filename = null){
		if(!empty($filename)){
			$this->load($filename);
		}
	}

	function load($filename) {
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		if( $this->image_type == IMAGETYPE_JPEG ) {
			$this->image = imagecreatefromjpeg($filename);
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
			$this->image = imagecreatefromgif($filename);
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
			$this->image = imagecreatefrompng($filename);
		} else {
			throw new Exception("The file you're trying to open is not supported");
		}

	}

	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image,$filename,$compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($this->image,$filename);         
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->image,$filename);
		}   
		if( $permissions != null) {
			chmod($filename,$permissions);
		}
	}

	function output($image_type=IMAGETYPE_JPEG, $quality = 80) {
		if( $image_type == IMAGETYPE_JPEG ) {
			header("Content-type: image/jpeg");
			imagejpeg($this->image, null, $quality);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			header("Content-type: image/gif");
			imagegif($this->image);         
		} elseif( $image_type == IMAGETYPE_PNG ) {
			header("Content-type: image/png");
			imagepng($this->image);
		}
	}

	function getWidth() {
		return imagesx($this->image);
	}

	function getHeight() {
		return imagesy($this->image);
	}

	function resizeToHeight($height) {
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);
	}

	function resizeToWidth($width) {
		$ratio = $width / $this->getWidth();
		$height = $this->getHeight() * $ratio;
		$this->resize($width,$height);
	}

	function square($size){
		$new_image = imagecreatetruecolor($size, $size);

		if($this->getWidth() > $this->getHeight()){
			$this->resizeToHeight($size);
			
			imagecolortransparent($new_image, imagecolorallocate($new_image, 255, 255, 255));
			imagealphablending($new_image, false);
			imagesavealpha($new_image, true);
			imagecopy($new_image, $this->image, 0, 0, ($this->getWidth() - $size) / 2, 0, $size, $size);
		} else {
			$this->resizeToWidth($size);
			
			imagecolortransparent($new_image, imagecolorallocate($new_image, 255, 255, 255));
			imagealphablending($new_image, false);
			imagesavealpha($new_image, true);
			imagecopy($new_image, $this->image, 0, 0, 0, ($this->getHeight() - $size) / 2, $size, $size);
		}
 
		$this->image = $new_image;
	}
   
	function scale($scale) {
		$width = $this->getWidth() * $scale/100;
		$height = $this->getHeight() * $scale/100; 
		$this->resize($width,$height);
	}
   
	function resize($width,$height) {
		$new_image = imagecreatetruecolor($width, $height);
		
		$c = imagecolorallocate($new_image, 255, 255, 255);
		imagefill($new_image, 0, 0, $c);
		
		imagecolortransparent($new_image, imagecolorallocate($new_image, 255, 255, 255));
		imagealphablending($new_image, false);
		imagesavealpha($new_image, true);
		imagefilledrectangle ($new_image, 0, 0, imagesx($new_image),  imagesy($new_image),$c);
		
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		
		
		//imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;   
	}
    function cut($x, $y, $width, $height, $color='ffffff'){		
		$new_image = imagecreatetruecolor($width, $height);
		
		imagesavealpha($new_image, true);

		if($color=='ffffff') {
			$c = imagecolorallocate($new_image, 255, 255, 255);
		} else {
			$c = imagecolorallocate($new_image, 0, 0, 0);
		}
		
		imagefill($new_image, 0, 0, $c);
		imagefilledrectangle ($new_image, 0, 0, $width,  $height,$c);
		
		if($x<0) {
			$marge_right = abs(imagesx($new_image)-imagesx($this->image));
			$marge_bottom = abs(imagesy($new_image)-imagesy($this->image));
			imagecopy($new_image, $this->image, imagesx($new_image) - imagesx($this->image) - $marge_right/2, imagesy($new_image) - imagesy($this->image) - $marge_bottom, 0, 0, imagesx($this->image), imagesy($this->image));
		}else {
			imagecopy($new_image, $this->image, 0, 0, $x, $y, $width, $height);
		}
		$this->image = $new_image;
	}
	function maxarea($width, $height = null){
		$height = $height ? $height : $width;
		
		if($this->getWidth() > $width){
			$this->resizeToWidth($width);
		}
		if($this->getHeight() > $height){
			$this->resizeToheight($height);
		}
	}

	function cutFromCenter($width, $height){
		
		if($width < $this->getWidth() && $width > $height){
			$this->resizeToWidth($width);
		}
		if($height < $this->getHeight() && $width < $height){
			$this->resizeToHeight($height);
		}
		
		$x = ($this->getWidth() / 2) - ($width / 2);
		$y = ($this->getHeight() / 2) - ($height / 2);
		
		return $this->cut($x, $y, $width, $height);
	}
	
	function thumbnail_box($box_w, $box_h) {
		$img = $this->image;
		//create the image, of the required size
		$new = imagecreatetruecolor($box_w, $box_h);
		if($new === false) {
			//creation failed -- probably not enough memory
			return null;
		}
	
	
		//Fill the image with a light grey color
		//(this will be visible in the padding around the image,
		//if the aspect ratios of the image and the thumbnail do not match)
		//Replace this with any color you want, or comment it out for black.
		//I used grey for testing =)
		$fill = imagecolorallocate($new, 255, 255, 255);
		imagefill($new, 0, 0, $fill);
	
		//compute resize ratio
		$hratio = $box_h / imagesy($img);
		$wratio = $box_w / imagesx($img);
		$ratio = min($hratio, $wratio);
	
		//if the source is smaller than the thumbnail size, 
		//don't resize -- add a margin instead
		//(that is, dont magnify images)
		if($ratio > 1.0)
			$ratio = 1.0;
	
		//compute sizes
		$sy = floor(imagesy($img) * $ratio);
		$sx = floor(imagesx($img) * $ratio);
	
		//compute margins
		//Using these margins centers the image in the thumbnail.
		//If you always want the image to the top left, 
		//set both of these to 0
		$m_y = floor(($box_h - $sy) / 2);
		$m_x = floor(($box_w - $sx) / 2);
	
		//Copy the image data, and resample
		//
		//If you want a fast and ugly thumbnail,
		//replace imagecopyresampled with imagecopyresized
		if(!imagecopyresampled($new, $img,
			$m_x, $m_y, //dest x, y (margins)
			0, 0, //src x, y (0,0 means top left)
			$sx, $sy,//dest w, h (resample to this size (computed above)
			imagesx($img), imagesy($img)) //src w, h (the full size of the original)
		) {
			//copy failed
			imagedestroy($new);
			return null;
		}
		//copy successful
		$this->image = $new;
		
	}
}
/*
// Usage:
// Load the original image
$image = new SimpleImage('lemon.jpg');

// Resize the image to 600px width and the proportional height
$image->resizeToWidth(600);
$image->save('lemon_resized.jpg');

// Create a squared version of the image
$image->square(200);
$image->save('lemon_squared.jpg');

// Scales the image to 75%
$image->scale(75);
$image->save('lemon_scaled.jpg');

// Resize the image to specific width and height
$image->resize(80,60);
$image->save('lemon_resized2.jpg');

// Output the image to the browser:
$image->output();

*/
