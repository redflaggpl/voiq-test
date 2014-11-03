<?php

class SimpleImage {

    var $image;
    var $image_type;
    var $log;

    function load($filename) {

        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];

        if ($this->image_type == IMAGETYPE_JPEG || $this->image_type == IMAGETYPE_TIFF_II || $this->image_type == IMAGETYPE_TIFF_MM) {
            $exif = exif_read_data($filename);
            $this->orientation = '';
            if (!empty($exif['Orientation'])) {
                $this->orientation = $exif['Orientation'];
            }
            if ($this->log != null) {
                $this->log->set("orientation: " . $this->orientation . "\n");
            }
        }

        if ($this->image_type == IMAGETYPE_JPEG) {

            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {

            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {

            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {

        // do this or they'll all go to jpeg
        $image_type = $this->image_type;

        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            // need this for transparent png to work          
            imagealphablending($this->image, false);
            imagesavealpha($this->image, true);
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    function output($image_type = IMAGETYPE_JPEG) {

        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    function getWidth() {

        return imagesx($this->image);
    }

    function getHeight() {

        return imagesy($this->image);
    }

    function cropTo($width, $height) {
        $source_ratio = $this->getWidth() / $this->getHeight();
        $desired_ratio = $width / $height;

        if ($source_ratio > $desired_ratio) {
            $temp_height = $height;
            $temp_width = (int) ($height * $source_ratio);
        } elseif ($source_ratio < $desired_ratio) {
            $temp_width = $width;
            $temp_height = (int) ($width / $source_ratio);
        } else {
            $temp_width = $width;
            $temp_height = $height;
        }

        $this->resize($temp_width, $temp_height, 0, 0);
        $x0 = ($temp_width - $width) / 2;
        $y0 = ($temp_height - $height) / 2;

        $this->resize($width, $height, $x0, $y0, true);
    }

    function autoResize($size) {
        $ratio = $this->getWidth() / $this->getHeight();
        if ($ratio > 1) {
            $this->resizeToWidth($size);
        } else if ($ratio < 1) {
            $this->resizeToHeight($size);
        } else {
            $this->resize($size, $size);
        }
    }

    function resizeToHeight($height, $c_w = 0, $c_h = 0) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height, $c_w, $c_h);
    }

    function resizeToWidth($width, $c_w = 0, $c_h = 0) {
        $ratio = $width / $this->getWidth();
        $height = $this->getHeight() * $ratio;
        $this->resize($width, $height, $c_w, $c_h);
    }

    function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getHeight() * $scale / 100;
        $this->resize($width, $height);
    }

    function resize($width, $height, $forcesize = 'n') {
        /* optional. if file is smaller, do not resize. */
        if ($forcesize == 'n') {
            if ($width > $this->getWidth() && $height > $this->getHeight()) {
                $width = $this->getWidth();
                $height = $this->getHeight();
            }
        }
        $new_image = imagecreatetruecolor($width, $height);
        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($this->image_type == IMAGETYPE_GIF) || ($this->image_type == IMAGETYPE_PNG)) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
        }
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

        $this->image = $new_image;
        ;
    }

    function destroy_image() {
        imagedestroy($this->image);
    }

    function fixOrientation() {

        if (isset($this->orientation)) {
            switch ($this->orientation) {
                case 8:
                    $this->image = imagerotate($this->image, 90, 0);
                    break;
                case 3:
                    $this->image = imagerotate($this->image, 180, 0);
                    break;
                case 6:
                    $this->image = imagerotate($this->image, -90, 0);
                    break;
            }
        }
    }

    function rotate($angle) {
        $this->image = imagerotate($this->image, $angle, 0);
    }

}
