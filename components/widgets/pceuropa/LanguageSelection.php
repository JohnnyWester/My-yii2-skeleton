<?php
namespace app\components\widgets\pceuropa;

use Yii;
use yii\helpers\Html;
use app\components\widgets\pceuropa\LanguageAsset;

class LanguageSelection extends \yii\base\Widget {
	
	public $container = 'li'; // li for navbar, div for sidebar or footer example
	public $classContainer = 'dropdown-toggle'; // btn btn-default dropdown-toggle
	public $language;
	public $languageParam;
	public $url;
	public $handler = '';


	public function init(){
		parent::init();
		if ($this->language === null) {
            $this->language = ['en'];
        }
        
        if ($this->languageParam === null) {
            $this->languageParam = 'language';
        }
        
        
        LanguageAsset::register($this->view);
        $this->url = $this->view->assetBundles[LanguageAsset::className()]->baseUrl;
	}
	
	public function run(){
		return $this->widgetRender();
	}
	
	public function patchFlag($lang){
		return $this->url .'/images/flags/'.$lang.'.png'; 
	}

	public function currentFlag(){
		return substr(Yii::$app->language, 0 , 2);
	}


	
	public function allFlag(){
		$items = '';
		
		foreach ($this->language as $key => $value) {
			if ($this->currentFlag() != $value){
				$img = Html::img( $this->patchFlag($value));
				$a = Html::a ($img , [$this->handler, $this->languageParam => $value], [ 'data-pjax' => 0] );
				$items .= Html::tag('li',$a );
			}
		}

        return $items;
    }
	
	public function widgetRender(){

		return $this->render('language-selection', [
			'container' => $this->container,
			'classContainer' => $this->classContainer,
			'flags' => [
				'now' => $this->patchFlag($this->currentFlag()),
				'all' => $this->allFlag(),
			]
		]);
	}
}

?>
