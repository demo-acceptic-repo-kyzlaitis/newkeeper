<?php

class CronController extends Controller
{
	protected $yahoo = array(
		'sunny' => array(19, 32, 34, 36),
		'snow' => array(5, 6, 7, 8, 9, 13, 14, 15, 16, 17, 18, 25, 41, 42, 43, 46),
		'storm' => array(0, 1, 2, 3, 4, 23, 24, 37, 38, 39),
		'rain' => array(10, 11, 12, 35, 40, 45, 47),
		'partly_cloudy' => array(29, 30, 44),
		'cloudy' => array(19, 20, 21, 22, 26, 27, 28),
		'moon' => array(31, 33),
	);
	
	public function actionMapLoad($city_coords_1 = 55.75577, $city_coords_2 = 37.617761, $city_id = 3)
	{
	//$city_coords_1 = 55.75577, $city_coords_2 = 37.617761, $city_id = 3
	//$city_coords_1 = 37.80285, $city_coords_2 = 48.015877, $city_id = 4
	    $this->render('maps', array(
	        'city_coords_1'=>$city_coords_1,
			'city_coords_2'=>$city_coords_2,
			'city_id'=>$city_id
	    ));
	}
	
	public function actionSetTraffic($value=0, $city_id=0)
	{
		if ((isset($_POST["traf_val"])) && (!empty($_POST["traf_val"])) && (isset($_POST["city"])) && (!empty($_POST["city"]))){
			$value = $_POST["traf_val"];
			$city_id = $_POST["city"];
			$city = City::model()->setTraffic($value, $city_id);
            echo 'Traffic refreshed';
		}else{
		    echo 'Traffic not refreshed';  
		}
	}

	public function CurrencyConvert($amount, $from, $to)
	{	
		$ch = curl_init();
		//$url = "http://www.google.com/ig/calculator?q={$amount}{$from}=?{$to}";
        $url = "http://www.google.com/finance/converter?a={$amount}&from={$from}&to={$to}";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 6.0; Windows NT 5.1');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
        
        $needle = 'class=bld>';
        $n_len = strlen($needle);
        $curs = substr($result,strpos($result,$needle),$n_len + 6);
        $curs = str_replace($needle,'',$curs);
        //var_dump($curs);exit;
/*
		$data = array();
		foreach ((array) explode(',', str_replace(array('{', '}'), '', $result)) as $item)
        {
			$row = null;
			$row = explode(':', $item);
			$data[ $row[0] ] = str_replace('"', '', $row[1]);
		}
		$data = 1000*$data['rhs'];
		$data = (int)$data/1000;*/
		
		return (float) $curs;
	}

	public function actionCurrency()
    {
		$er[1] = $this->CurrencyConvert(1,'USD', 'UAH');
		$er[2] = $this->CurrencyConvert(1,'EUR', 'UAH');
		$er[3] = $this->CurrencyConvert(10,'RUB', 'UAH');
		$code[1] = 'USD';
		$code[2] = 'EUR';
		$code[3] = 'RUR';
		for ($i = 1; $i <= 3; $i++)
        {
			$model = WidgetCurrencyElement::model()->findByPk($i);
			
            $buy = 100.25*$er[$i];
            $buy = (int)$buy;
            $buy /= 100;
            
            $sale = $er[$i]/0.010025;
            $sale = (int)$sale;
            $sale /= 100;
            
			$model->buy = $buy;
			$model->sale = $sale;
			
			if(!$model->save()){
				print_r($model->getErrors());
				die("not saved!");
			}
		}
		$this->render('currency', array('er1' => $er[1], 'er2'=>$er[2], 'er3'=>$er[3]));
	}
	
	
		
 	public function actionWeather($units = 'c', $lang = 'en')
    {
	    $models = City::model()->findAll();	
		foreach ($models as $model)
        {
			$code = $model->code_yahoo;
			$url = 'http://xml.weather.yahoo.com/forecastrss?p='.$code.'&u='.$units;
			$xml_contents = file_get_contents($url);
			if($xml_contents === false) 
				die('Error loading '.$url);
			$xml = new SimpleXMLElement($xml_contents);
			$tmp = $xml->xpath('/rss/channel/item/yweather:condition');
			if(sizeof($tmp) == 0) 
			    continue;//die("Error parsing XML.");
			$tmp = $tmp[0];
			
			foreach($this->yahoo as $w=>$codes) {
				if (in_array($tmp['code'], $codes)) {
					$text_temp = $w;
					break;
				}
			}
			
			//$text_temp = strtolower((string)$tmp['text']);
			$temp = (int)$tmp['temp'];
			$model->text_temp = $text_temp;
			$model->temp = $temp;
			
			if(!$model->save()){
				print_r($model->getErrors());
				die("not saved!");
			}else{
			    $result = 'Weather refreshed';
			}
		}
        echo $result;
	}
	
}