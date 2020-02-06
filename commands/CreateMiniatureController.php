<?php

namespace app\commands;

use app\models\Product;
use yii\console\Controller;
use app\components\Images;

class CreateMiniatureController extends Controller
{
    public function actionIndex($sizes, $waterMarked = false, $catalogOnly = true)
    {
    	if($catalogOnly) {
		    $products = (new \yii\db\Query())
			    ->select(['p.id', 'p.image'])
			    ->from('product p')
			    ->join(	'INNER JOIN',
				    'store_product sp',
				    'sp.product_id=p.id'
			    )->where(['p.is_deleted' => 0])
			    ->all();
	    } else {
		    $products = Product::find()
			                   ->select(['id', 'image'])
		                       ->where(['is_deleted' => 0])
		                       ->asArray()
		                       ->all();
	    }
	    
	    $sizes = explode(',', $sizes);
    	$sizes_arr = [];
    	$i = 0;
    	foreach ($sizes as $size) {
    		$size = explode('x', $size);
    		$sizes_arr[$i]['width'] = $size[0];
    		if(count($size) == 1) {
    			$sizes_arr[$i]['height'] = $size[0];
		    } else {
    			$sizes_arr[$i]['height'] = $size[1];
		    }
		    $i ++;
	    }
    	
	    $generated = 0;
	    $not_generated = 0;
	    
	    foreach ($products as $product) {
    		
    		foreach ($sizes_arr as $item) {
			    if ($waterMarked) {
				    $miniature = Images::generateWatermarkedMiniature($item, $product);
			    } else {
				    $miniature = Images::generateMiniature($item, $product);
			    }
			
			    if (is_file($miniature)) {
				    $generated++;
			    } else {
			    	echo $miniature;
				    $not_generated++;
			    }
		    }
	    }
	    
	    echo 'generated miniatures count is: '.$generated;
	    echo ' not generated miniatures count is: '.$not_generated;
    }
}