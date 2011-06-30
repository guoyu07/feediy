<?php
/**
 * 
 * Enter description here ...
 * @author lijia
 *
<?php
// cURL options can be found here:
// http://php.net/manual/en/function.curl-setopt.php

require_once('Whiz/Http/Client/Curl.php');

// Set cURL options via constructor
$curl = new Whiz_Http_Client_Curl(
  array(CURLOPT_REFERER => 'http://www.google.com/')
);

// Set URL via method (This is just to make things easier)
$curl->setUrl('http://juliusbeckmann.de/');
// $curl->exec('http://juliusbeckmann.de/'); would be also possible

// Set cURL options via method
$curl->setOption(CURLOPT_TIMEOUT, 10);

// Do the request
$curl->exec();

if($curl->isError()) {
  // Error
  var_dump($curl->getErrNo());
  var_dump($curl->getError());
}else{
  // Success
  echo $curl->getResult();
  // More info about the transfer
  // var_dump($curl->getInfo());
  // var_dump($curl->getHeader());
  // var_dump($curl->getVersion());
}

// Close cURL
$curl->close();
?>
<?php

require_once('Whiz/Http/Client/Curl.php');

// Creating a "template" class by overwriting internal config
class My_Curl extends Whiz_Http_Client_Curl {
  protected $_config = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_REFERER => 'http://www.google.com/'
  );
}

$curl = new My_Curl();
$curl->setUrl('http://juliusbeckmann.de/');

// Fetch configured handle
$ch = $curl->getHandle();

// Fetch a copy of the configured handle
// $ch2 = $curl->copyHandle();

// Do with handle what ever you like
// ...
$result = curl_exec($ch);

// Put handle and result back in
$curl->setFromHandle($ch, $result);

// Fetch transfer info
if($curl->isError()) {
  // Error
  var_dump($curl->getErrNo());
  var_dump($curl->getError());
}else{
  // Success
  echo $curl->getResult();
  // More info about the transfer
  // var_dump($curl->getInfo());
  // var_dump($curl->getHeader());
  // var_dump($curl->getVersion());
}

// Close cURL
$curl->close();
?>
 */

class ToolController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionIn2Out()
	{
		$data=array();
		
		if(isset($_REQUEST['in'])){
			$data['in'] = empty($_REQUEST['in']) ? '' : trim($_REQUEST['in']);
			if(strlen($data['in'])>0){
				$out = unserialize($data['in']);
				$tmp='';
				if(!empty($out)){
					foreach($out as $k => $v){
						$tmp.=$k.': '.$v."\r\n";
					}
				}
				$data['out']=$tmp;
			}
		}
		
		$this->render('in2out', $data);
	}
	
	public function actionGet()
	{
		$show = isset($_REQUEST['show']) ? true : false;
		$expire = isset($_REQUEST['expire']) ? intval($_REQUEST['expire']) : 10;
		$src = isset($_REQUEST['src']) ? trim($_REQUEST['src']) : '';
		
		$o = Tools::OZCurl($src, $expire, $show);
	}

    public function actionXuk()
	{
        $op=trim(strtolower(Yii::app()->request->getParam('op', 'list')));
        $id=intval(Yii::app()->request->getParam('id', 1));
        $id=($id<1) ? 1 : $id;

        if (Yii::app()->request->isAjaxRequest) {
            if($op=='list'){
                //get gallery list
//                $id=isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 1;
                if(Xuk::getList($id)==true){
                    echo json_encode(array('responseStatus'=>200));
                }
            }
            if($op=='item'){
                //get gallery
                if(Xuk::getItem()==true){
                    echo json_encode(array('responseStatus'=>200));
                }
            }
            if($op=='image'){
                //down image
                if(Xuk::getImage()==true){
                    echo json_encode(array('responseStatus'=>200));
                }
            }
            if($op=='post'){
                //new post
                if(Xuk::postGallery()==true){
                    echo json_encode(array('responseStatus'=>200));
                }
            }
        }else{
            $this->layout='//layouts/simple';
            $this->render('do', array('id'=>$id, 'op'=>$op));
        }
	}

    public function actionUp()
    {
        
    }

    public function actionTest()
	{
        var_dump(substr('.afas', 0, 1)!='.') ;
		echo MCrypy::decrypt('DP9gh8NxCU7dIuk0teVguS5fM5Pzv4ACdDswFgkH8yWUAC+GMqTRp+33XeLbSesX8JsKdV5ZJvdTvlm1V0zNjNP85/xS5UcYn6j4IxsB', Yii::app()->params['xuk_pass'], 128);
        echo '<br>';
        echo strlen('DP9gh8NxCU7dIuk0teVguS5fM5Pzv4ACdDswFgkH8yWUAC+GMqTRp+33XeLbSesX8JsKdV5ZJvdTvlm1V0zNjNP85/xS5UcYn6j4IxsB');
	}
	

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}