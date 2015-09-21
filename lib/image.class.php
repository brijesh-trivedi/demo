<?php
 /**
  * StepIn Solutions venture
  * 
  *
  * @package Stepone
  */
  class image extends file
  {
        private $aImage;
        private $aValidationTypes = array(
                                           'bmp'=>'image/bmp',
                                           'cmx'=>'image/x-cmx',
                                           'gif'=>'image/gif',
                                           'ico'=>'image/x-icon',
                                           'ief'=>'image/ief',
                                           'jfif'=>'image/pipeg',
                                           'jpe'=>'image/jpeg',
                                           'jpeg'=>'image/jpeg',
                                           'jpg'=>'image/jpeg',
                                           'png'=>'image/png',
                                           'pbm'=>'image/x-portable-bitmap',
                                           'ppm'=>'image/x-portable-pixmap',
                                           'ras'=>'image/x-cmu-raster',
                                           'rgb'=>'image/x-rgb',
                                           'svg'=>'image/svg+xml',
                                           'tif'=>'image/tiff',
                                           'tiff'=>'image/tiff',
                                           'xpm'=>'image/x-xpixmap',
                                           'xwd'=>'image/x-xwindowdump',
                                         );
        

        //Constructer
  	public function __construct($aFiles =  array(''))
	{   
            foreach ( $aFiles as $key => $value ) 
            {
                $this->aImage['image_file'] = $aFiles[$key];
            }
	}
        
        public function imageValidation($aValidations)
        {
            $oSession = new sessionManager();
            $bIdValid = true;
            if (!in_array($this->aImage['image_file']['type'], $this->aValidationTypes))
             {
                $oSession->setError($aValidations[0]['field'],$aValidations[0]['message']);
                $bIsValid = false;
            }
            return $bIsValid;
        }
        /*
         * Upload file at specifies path
         * $sPath
         */
        public function uploadAt($sPath = '')
        {
            if(!empty($this->aImage['image_file']))
            {
                $sTempFileName = $this->aImage['image_file']['tmp_name'];
                $this->upload($sTempFileName,$sPath);
            }
        }
        public function putImageWithDimensions($sPath,$resizeWidth,$resizeHeight,$newFilename)
        {
            $file = $this->aImage['image_file'];
            $img = $file['tmp_name'];
            
            //Get Image size info
            $imgInfo = getimagesize($img);
            
            //Get Image size info
            //$sImageMimeType = $img['mime'];
            
            // To validate for valid mime type
            //$this->validations($sImageMimeType);
            
            switch ($imgInfo[2]) 
            {
                case 1: $image = imagecreatefromgif($img);
                        break;
                case 2: $image = imagecreatefromjpeg($img);
                        break;
                case 3: $image = imagecreatefrompng($img);
                        break;
                default: trigger_error('Unsupported filetype!', E_USER_WARNING);
                        break;
            }

            $sourceWidth = $imgInfo[0];
            $sourceHeight = $imgInfo[1];

            if (($sourceWidth > $resizeWidth) || ($sourceHeight > $resizeHeight)) {
                    //original width exceeds, so reduce the original width to maximum limit.
                    //calculate the height according to the maximum width.
                    if (($sourceWidth > $resizeWidth) && ($sourceHeight <= $resizeHeight)) {
                            $percent = $resizeWidth / $sourceWidth;
                            $nWidth = $resizeWidth;
                            $nHeight = round($sourceHeight * $percent);
                    }

                    //image height exceeds, recudece the height to maxmimum limit.
                    //calculate the width according to the maximum height limit.
                    if (($sourceWidth <= $resizeWidth) && ($sourceHeight > $resizeHeight)) {
                            $percent = $resizeHeight / $sourceHeight;
                            $nHeight = $resizeHeight;
                            $nWidth = round($sourceWidth * $percent);
                    }

                    //both height and width exceeds.
                    //but image can be vertical or horizontal.
                    if (($sourceWidth > $resizeWidth) && ($sourceHeight > $resizeHeight)) {
                            //if image has more width than height
                            //resize width to maximum width.
                            if ($sourceWidth > $sourceHeight) {
                                    $percent = $resizeWidth / $sourceWidth;
                                    $nWidth = $resizeWidth;
                                    $nHeight = round($sourceHeight * $percent);
                            } else {
                                    //image is vertical or square. More height than width.
                                    //resize height to maximum height.
                                    $percent = $resizeHeight / $sourceHeight;
                                    $nHeight = $resizeHeight;
                                    $nWidth = round($sourceWidth * $percent);
                            }
                    }
            } else {
                    $sourceAspectRatio = $sourceWidth / $sourceHeight;
                    $desiredAspectRatio = $resizeWidth / $resizeHeight;
                    if ($sourceAspectRatio > $desiredAspectRatio) {
                            $nHeight = $resizeHeight;
                            $nWidth = (int)( $resizeHeight * $sourceAspectRatio );
                    } else {// For Tall Image
                            $nWidth = $resizeWidth;
                            $nHeight = (int)( $resizeWidth / $sourceAspectRatio );
                    }
            }

            $tmpImg = imagecreatetruecolor($nWidth, $nHeight);
            $fillColor = imagecolorallocate($tmpImg, 255, 255, 255);
            imagefill($tmpImg, 0, 0, $fillColor);
            /* Check if this image is PNG or GIF, then set if Transparent */
            if (($imgInfo[2] == 1) || ($imgInfo[2] == 3)) {
                    imagealphablending($tmpImg, false);
                    imagesavealpha($tmpImg, true);
                    $transparent = imagecolorallocatealpha($tmpImg, 0, 0, 0, 127);
                    imagefilledrectangle($tmpImg, 0, 0, $nWidth, $nHeight, $transparent);
            }

            if ($nWidth >= $sourceWidth && $nHeight >= $sourceHeight) {
                    imagecopyresampled($tmpImg, $image, round(($nWidth / 2) - ($sourceWidth / 2)), round(($nHeight / 2) - ($sourceHeight / 2)), 0, 0, $sourceWidth, $sourceHeight, $sourceWidth, $sourceHeight);
            } else if ($nWidth <= $sourceWidth && $nHeight >= $sourceHeight) {
                    imagecopyresampled($tmpImg, $image, 0, round(($nHeight / 2) - ($sourceHeight / 2)), 0, 0, $nWidth, $sourceHeight, $sourceWidth, $sourceHeight);
            } else if ($nWidth >= $sourceWidth && $nHeight <= $sourceHeight) {
                    imagecopyresampled($tmpImg, $image, round(($nWidth / 2) - ($sourceWidth / 2)), 0, 0, 0, $nWidth, $sourceHeight, $sourceWidth, $sourceHeight);
            } else {
                    imagecopyresampled($tmpImg, $image, 0, 0, 0, 0, $nWidth, $nHeight, $sourceWidth, $sourceHeight);
            }

            $newImg = imagecreatetruecolor($resizeWidth, $resizeHeight);
            $fillColorNew = imagecolorallocate($newImg, 255, 255, 255);
            imagefill($newImg, 0, 0, $fillColorNew);

            /* Check if this image is PNG or GIF, then set if Transparent */
            if (($imgInfo[2] == 1) || ($imgInfo[2] == 3)) {
                    imagealphablending($newImg, false);
                    imagesavealpha($newImg, true);
                    $transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
                    imagefilledrectangle($newImg, 0, 0, $resizeWidth, $resizeHeight, $transparent);
            }

            if ($resizeWidth >= $nWidth && $resizeHeight >= $nHeight) {
                    imagecopyresampled($newImg, $tmpImg, round(($resizeWidth / 2) - ($nWidth / 2)), round(($resizeHeight / 2) - ($nHeight / 2)), 0, 0, $nWidth, $nHeight, $nWidth, $nHeight);
            } else if ($resizeWidth <= $nWidth && $resizeHeight >= $nHeight) {
                    imagecopyresampled($newImg, $tmpImg, 0, round(($resizeHeight / 2) - ($nHeight / 2)), 0, 0, $resizeWidth, $nHeight, $nWidth, $nHeight);
            } else if ($resizeWidth >= $nWidth && $resizeHeight <= $nHeight) {
                    imagecopyresampled($newImg, $tmpImg, round(($resizeWidth / 2) - ($nWidth / 2)), 0, 0, 0, $resizeWidth, $nHeight, $nWidth, $nHeight);
            } else {
                    imagecopyresampled($newImg, $tmpImg, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $nWidth, $nHeight);
            }

            //Generate the file, and rename it to $newfilename
            if (!imagejpeg($newImg, $newFilename, 91)) {
                    trigger_error('Failed resize image!', E_USER_WARNING);
            }
            imagedestroy($image);
            imagedestroy($tmpImg);
            imagedestroy($newImg);
            $this->upload($newFilename,$sPath);
        }
        /**
	 *
	 * @param string $srcFile The source file.
	 * @param int $srcX The start x position to crop from.
	 * @param int $srcY The start y position to crop from.
	 * @param int $srcWidth The width to crop.
	 * @param int $srcHeight The height to crop.
	 * @param int $dstWidth The destination width.
	 * @param int $dstHeight The destination height.
	 * @param int $srcAbs Optional. If the source crop points are absolute.
	 * @param string $dstFile Optional. The destination file to write to.
	 * @return string|boolean New filepath on success or false on failure.
	 */
	public function cropImage($sPath,$srcX, $srcY, $srcWidth, $srcHeight, $dstWidth, $dstHeight, $srcAbs = false, $dstFile = false) 
        {
            $file = $this->aImage['image_file'];
            $img = $file['tmp_name'];
            //Get Image size info
            $imgInfo = getimagesize($img);
            
            //Get Image size info
            //$sImageMimeType = $file['type'];
            
            // To validate for valid mime type
            //$this->validations($sImageMimeType);
            // Set artificially high because GD uses uncompressed images in memory
            ini_set('memory_limit', '256M');
            
            switch ($imgInfo[2]) {
                    case 1: $src = imagecreatefromgif($img);
                            break;
                    case 2: $src = imagecreatefromjpeg($img);
                            break;
                    case 3: $src = imagecreatefrompng($img);
                            break;
                    default: trigger_error('Unsupported filetype!', E_USER_WARNING);
                            break;
            }

            $dst = imagecreatetruecolor($dstWidth, $dstHeight);

            if (($imgInfo[2] == 1) || ($imgInfo[2] == 3)) {
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
            }

            if ($srcAbs) {
                    $srcWidth -= $srcX;
                    $srcHeight -= $srcY;
            }

            if (function_exists('imageantialias')) {
                    imageantialias($dst, true);
            }

            imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight);

            imagedestroy($src); // Free up memory

            if (!$dstFile) {
                    $dstFile = str_replace(basename($img), 'cropped-' . basename($img), $img);
            }

            $return = false;

            //Generate the file, and rename it to $newfilename
            switch ($imgInfo[2]) {
                    case 1:
                            if (imagegif($dst, $dstFile)) {
                                    $return = $dstFile;
                            }
                            break;
                    case 2:
                            if (imagejpeg($dst, $dstFile, 91)) {
                                    $return = $dstFile;
                            }
                            break;
                    case 3:
                            if (imagepng($dst, $dstFile)) {
                                    $return = $dstFile;
                            }
                            break;
                    default: trigger_error('Failed resize image!', E_USER_WARNING);
                            break;
            }

            $this->upload($dstFile,$sPath);
	}
        /**
         * createThumbs image
         * @param type $sPathToImages
         * @param type $sPathToThumbs
         * @param type $nThumbWidth
         * @author Jaimin Shelat <jaimin.stepin@gmail.com>
         */
        public function createThumbs($sThumbPath, $nThumbWidth, $newFilename )
        {
            $file = $this->aImage['image_file'];
            $img = $file['tmp_name'];
            
            //Get Image size info
            $imgInfo = getimagesize($img);
            $width = $imgInfo[0];
            $height = $imgInfo[1];

            // calculate thumbnail size
            $new_width = $nThumbWidth;
            $new_height = floor( $height * ( $nThumbWidth / $width ) );

            // create a new temporary image
            //$sThumb = imagecreatetruecolor( $new_width, $new_height );
            
            
            // parse path for the extension
            switch ($imgInfo[2]) 
            {
                case 1: $image = imagecreatefromgif($img);
                        break;
                case 2: $image = imagecreatefromjpeg($img);
                        break;
                case 3: $image = imagecreatefrompng($img);
                        break;
                default: trigger_error('Unsupported filetype!', E_USER_WARNING);
                        break;
            }
            
            


            
            
            // copy and resize old image into new image
            //$sThumb = imagecreate($new_width, $new_height);
            //$sThumb = imagecreatetruecolor($new_width,$new_height); 
            //imagecolortransparent($image, $colorcode); //make corners transparent
            $im = imagecreatetruecolor($new_width,$new_height);
            $almostblack = imagecolorallocate($im,254,254,254);
            imagefill($im,0,0,$almostblack);
            $black = imagecolorallocate($im,0,0,0);
            imagecolortransparent($im,$almostblack);
            //... set x and y..
            //imagettftext($im,8,0,$x,$y,$black,$image,$txt); 
            
            imagecopyresized( $im, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
            //upload image into thumbnail folder
            switch ($imgInfo[2]) {
                case 1:
                        imagegif($im,$sThumbPath);
                        break;
                case 2:
                        imagejpeg($im,$sThumbPath);
                        break;
                case 3:
                        imagepng($im,$sThumbPath);
                        break;
                default: trigger_error('Failed resize image!', E_USER_WARNING);
                        break;
            }
        }
  }
                  
 
