<?php
/**
 * Php function to resize an image
 * 
 * @param string $source_image Path of the source image
 * @param string $target_image Path of the target image
 * @param integer $target_width Width of the target image in pixels
 * @param integer $target_height Height of the target image in pixels  
 */
function resizeImage($source_image, $target_image, $target_width, $target_height)
{
    // check if we have valid target width and height
    if ($target_width <= 0 && $target_height <= 0)
    {
        trigger_error("resizeImage(): Invalid target width or height", E_USER_ERROR);
        return false;
    }
    
    // detect source image type from extension
    $source_file_name = basename($source_image);
    $source_image_type = substr($source_file_name, -3, 3);
    
    // create an image resource from the source image  
    switch(strtolower($source_image_type))
    {
        case 'jpg':
            $original_image = imagecreatefromjpeg($source_image);
            break;
            
        case 'gif':
            $original_image = imagecreatefromgif($source_image);
            break;

        case 'png':
            $original_image = imagecreatefrompng($source_image);
            break;    
        
        default:
            trigger_error("resizeImage(): Invalid image type", E_USER_ERROR);
            return false;
    }
    
    // detect source width and height
    list($source_width, $source_height) = getimagesize($source_image);
    
    // if target height or width is not specified, calculate it as per the aspect ratio 
    if ($target_height <= 0)
    {
        $target_height = ($source_height/$source_width) * $target_width;
    }
    if ($target_width <= 0)
    {
        $target_width = ($source_width/$source_height) * $target_height;
    }
    
    // create a blank image with target width and height
    // this will be our resized image
    $resized_image = imagecreatetruecolor($target_width, $target_height);
    
    // copy the source image to the blank image created above
    imagecopyresampled($resized_image, $original_image, 0, 0, 0, 0, 
                       $target_width, $target_height, $source_width, $source_height); 
    
    // detect target image type from extension
    $target_file_name = basename($target_image);
    $target_image_type = substr($target_file_name, -3, 3);
    
    // save the resized image to disk
    switch(strtolower($target_image_type))
    {
        case 'jpg':
            imagejpeg($resized_image, $target_image, 100);
            break;
            
        case 'gif':
            imagegif($resized_image, $target_image);
            break;

        case 'png':
            imagepng($resized_image, $target_image, 0);
            break;    
        
        default:
            trigger_error("resizeImage(): Invalid target image type", E_USER_ERROR);
            imagedestroy($resized_image);
            imagedestroy($original_image);
            return false;
    }
    
    // free resources
    imagedestroy($resized_image);
    imagedestroy($original_image);
    
    return true;
}

// using the function to resize an image
//$source_image = 'image.jpg';

// resized image of width 100px, height as per aspect ratio
//$target_image = 'resized_image_100w.jpg';
//$target_width = 100;
//$target_height = 0;
//resizeImage($source_image, $target_image, $target_width, $target_height);

// resized image of height 100px, width as per aspect ratio
//$target_image = 'resized_image_100h.jpg';
//$target_width = 0;
//$target_height = 100;
//resizeImage($source_image, $target_image, $target_width, $target_height);

// resized image of width 100px and height 100px
//$target_image = 'resized_image_100x100.jpg';
//$target_width = 100;
//$target_height = 100;
//resizeImage($source_image, $target_image, $target_width, $target_height);

?>
