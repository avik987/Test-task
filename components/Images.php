<?php

namespace app\components;
use Imagine\Image\Box;
use yii\db\Exception;
use yii\imagine\Image;


class Images
{
	const  BASEPATH = 'web/images/products/';
	
    public static function generateMiniature($sizes, $product)
    {
        try {
	        $file = self::BASEPATH . $product['id']. '/'. $product['image'];
            if (file_exists($file)) {
	            $width = $sizes['width'];
	            $height = $sizes['height'];
	            $thumbnailPath = self::BASEPATH . $product['id'] . '/' . $width .'x'. $height;
	            
	            if (!file_exists($thumbnailPath)) {
		            mkdir($thumbnailPath, 0777, true);
		            $miniature = $thumbnailPath . '/'. $product['image'];
		            Image::thumbnail($file, $width, $height)->resize(new Box($width, $height))
		                 ->save($miniature, ['quality' => 80]);
		
		            return $miniature;
	            } else {
	            	return 'file already exist';
	            }
            } else {
            	return 'file not exist';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function generateWatermarkedMiniature($sizes, $product)
    {
        try {
	        $watermark = \Yii::getAlias('web/images/watermark/watermark.jpg');
	        $file = self::BASEPATH . $product['id']. '/'. $product['image'];
	        if (file_exists($file)) {
		        $width = $sizes['width'];
		        $height = $sizes['height'];
		        $thumbnailPath = self::BASEPATH . $product['id'] . '/' . $width .'x'. $height;
		
		        if (!file_exists($thumbnailPath)) {
			        mkdir($thumbnailPath, 0777, true);
			        $miniature = $thumbnailPath . '/'. $product['image'];
			        Image::thumbnail($file, $width, $height)->resize(new Box($width, $height))
			             ->save($miniature, ['quality' => 80]);
			
			        Image::watermark($miniature, $watermark)
			             ->save($miniature);
			
			        return $miniature;
		        } else {
			        $miniature = $thumbnailPath . '/'. $product['image'];
			        Image::watermark($miniature, $watermark)
			             ->save($miniature);
			        
			        return $miniature;
		        }
	        } else {
	        	return 'file not exist';
	        }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}