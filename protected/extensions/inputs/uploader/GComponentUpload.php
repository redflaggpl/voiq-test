<?php

require(dirname(__FILE__) . "/SimpleImage.php");
/**
 * GUpload class file.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * GUpload displays a star rating control that can collect user rating input.
 *
 * GUpload is based on {@link http://www.fyneworks.com/jquery/star-rating/ jQuery Star Rating Plugin}.
 * It displays a list of stars indicating the rating values. Users can toggle these stars
 * to indicate their rating input. On the server side, when the rating input is submitted,
 * the value can be retrieved in the same way as working with a normal HTML input.
 * For example, using
 * <pre>
 * $this->widget('pat.to.location.GUpload',array('name'=>'rating'));
 * </pre>
 * we can retrieve the rating value via <code>$_POST['rating']</code>.
 *
 * GUpload allows customization of its appearance. It also supports empty rating as well as read-only rating.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @package system.web.widgets
 * @since 1.0
 */
class GComponentUpload extends CApplicationComponent {

    public function upload($allowedExtensions = array(),$sizeLimit=null) {
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        // $allowedExtensions = array("jpeg", "png", "jpg");
        // max file size in bytes
        if($sizeLimit===null)
            $sizeLimit = 100 * 1024 * 1024;

        require(dirname(__FILE__) . '/uploader.php');
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        // $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
        $result = $uploader->handleUpload('uploads/');

        if (isset($result['success']) and $result['success']) {
            $result['fileName'] = $uploader->fileName;
            if (isset($_GET['width']) and isset($_GET['height'])) {
                $image = new SimpleImage();
                $with = $_GET['width'];
                $height = $_GET['height'];
                $image->load(Yii::getPathOfAlias('webroot') . "/uploads/" . $uploader->fileName);
                $image->resize($with,$height,false);
                $image->save(Yii::getPathOfAlias('webroot') . "/uploads/" . $uploader->fileName);
                $resultImg = array();
                list($widthImage, $heightImage, $imageType) = getimagesize(Yii::getPathOfAlias('webroot') . "/uploads/" . $uploader->fileName);

                // if ($with != $widthImage and $height != $heightImage)
                //     $resultImg = array('error' => "Las dimenciones de la imagen deben ser ({$with} x {$height}) ($with != $widthImage and $height != $heightImage)");
                // if ($resultImg !== array()) {
                //     echo htmlspecialchars(json_encode($resultImg), ENT_NOQUOTES);
                //     exit;
                // }
            }
        }
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }

    public function uploadValidate($allowedExtensions = array()) {
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        // $allowedExtensions = array("jpeg", "png", "jpg");
        // max file size in bytes
        $sizeLimit = 100 * 1024 * 1024;

        require(dirname(__FILE__) . '/uploader.php');
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        // $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
        $result = $uploader->handleUpload('uploads/');

        if (isset($result['success']) and $result['success']) {
            $result['fileName'] = $uploader->fileName;
            if (isset($_GET['width']) and isset($_GET['height'])) {
                $image = new SimpleImage();
                $with = $_GET['width'];
                $height = $_GET['height'];
                $resultImg = array();
                list($widthImage, $heightImage, $imageType) = getimagesize(Yii::getPathOfAlias('webroot') . "/uploads/" . $uploader->fileName);

                if ($with != $widthImage and $height != $heightImage)
                    $resultImg = array('error' => "Las dimenciones de la imagen deben ser ({$with} x {$height})");
                if ($resultImg !== array()) {
                    echo htmlspecialchars(json_encode($resultImg), ENT_NOQUOTES);
                    exit;
                }
            }
        }
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }

}
