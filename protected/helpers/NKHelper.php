<?php

class NKHelper
{
    public static function getZoom()
	{
	    $out = 0;
		if(Yii::app()->user->isGuest)
        {
        	if(!isset(Yii::app()->session['zoom']))
            	Yii::app()->session['zoom'] = 1;
            else
            $out = Yii::app()->session['zoom'];
        }else{
            $pref = UserPreferences::model()->findByPk(Yii::app()->user->id);
            $out = $pref->zoom;
        }
        
        return $out;
	}
    
    public static function getFilePath($file)
	{
	    if (isset($_POST['str']) && (!empty($_POST['str'])))
			$file = $_SERVER["DOCUMENT_ROOT"].$_POST["str"];
		else
			$file = $_SERVER["DOCUMENT_ROOT"]."/".$file;
            
        return $file;
    }
    
    static public function getSubscribes()
	{
        if(isset(Yii::app()->session['categories']) && !empty(Yii::app()->session['categories']))
            $cids = implode(",",Yii::app()->session['categories']);
        else
            $cids = -1;
        if(isset(Yii::app()->session['blogers']) && !empty(Yii::app()->session['blogers']))
            $bids = implode(",",Yii::app()->session['blogers']);
        else
            $bids = -1;
            
        return array($cids,$bids);
    }
    
    static public function getMynewsProvider()
    {
        if(Yii::app()->user->isGuest){
            $subscribes = self::getSubscribes();
            $dataProvider = new CActiveDataProvider('News', array(
                'criteria' => array(
                    'distinct' => true,
                    'join' => 'LEFT JOIN news_category_assignment nca ON t.id = nca.news_id',
    				//'condition' => 'category_id IN (:cats)',// OR author_id IN ('.$subscribes[1].')',
                    'condition' => 'nca.category_id IN (:cats) AND status=1',
                    'params' => array(':cats' => $subscribes[0]),
                    'order' => 'create_time DESC'
    			),
                'pagination'=>array(
                    'pageSize'=>9,
                    'pageVar' =>'page',
                ),
    		));
        }else{
            $dataProvider = new CActiveDataProvider('News', array(
    			'criteria' => array(
                    'distinct' => true,
                    //'join' => ' LEFT JOIN `user_category_assignment` `as1` ON t.category_id=as1.category_id LEFT JOIN `user_bloger_assignment` `as2` ON t.author_id=as2.user_id',
    				'join' => 'LEFT JOIN news_category_assignment nca ON t.id = nca.news_id',
                    'condition' => 'nca.category_id IN (SELECT category_id FROM user_category_assignment WHERE user_id=:userId) AND status=1',
    				'params' => array(':userId' => Yii::app()->user->id),
                    'order' => 'create_time DESC'
    			),
                'pagination'=>array(
                    'pageSize'=>9,
                    'pageVar' =>'page',
                ),
    		));
        }
        
        return $dataProvider;
    }
    
    public static function getBkmrkProvider()
    {
        if(Yii::app()->user->isGuest){
            if(isset(Yii::app()->session['bookmarks']) && !empty(Yii::app()->session['bookmarks']))
                $ids = implode(",",Yii::app()->session['bookmarks']);
            else
                $ids = -1;
            $dataProvider = new CActiveDataProvider('News', array(
    			'criteria' => array(
    				'condition' => 'id IN ('.$ids.')',
    			),
                'pagination'=>array(
                    'pageSize'=>9,
                    'pageVar' =>'page',
                ),
		));
        }else{
    		$dataProvider = new CActiveDataProvider('News', array(
    			'criteria' => array(
    				'join' => ' JOIN `user_news_bookmark` `as` ON t.id=as.news_id',
    				'condition' => 'as.user_id=:userId AND status=1',
    				'params' => array(':userId' => Yii::app()->user->id),
    			),
                'pagination'=>array(
                    'pageSize'=>9,
                    'pageVar' =>'page',
                ),
    		));
        }
        
        return $dataProvider;
    }
    
    public static function getBlogProvider($id)
    {
		$dataProvider=new CActiveDataProvider('News', array(
			'criteria' => array(
				'condition' => 'author_id=:userId AND status=1 AND blog=1',
				'params' => array(':userId' => $id),
			),
            'pagination'=>array(
                'pageSize'=>9,
                'pageVar' =>'page',
            ),
		));
        $blogDataProvider=new CActiveDataProvider('News', array(
			'criteria' => array(
				'limit' => '1',
			),
            'pagination'=>array(
                'pageSize'=>9,
                'pageVar' =>'page',
            ),
        ));
        $blog = array();
        $blog[] = $blogDataProvider->data[0];
        for($i=1; $i<=count($dataProvider->data); $i++){
            $blog[$i] = $dataProvider->data[$i-1];
        }
        $blogDataProvider->data = $blog;

        return $blogDataProvider;
    }
	
	public static function bookmarkStat($id="")
	{
		if (empty(Yii::app()->session['bookmarked'])){
			Yii::app()->session['bookmarked'] = array();
			$ses = Yii::app()->session['bookmarked'];
		}
		else{
			$ses = Yii::app()->session['bookmarked'];
			$ind = in_array($id,$ses);
			if ($ind){
				return;
			}
				
		}
		array_push($ses,$id);
		Yii::app()->session['bookmarked'] = $ses;
		$stat = StatisticsOperation::model()->findByPk($id);
		if ((isset($stat)) && (!empty($stat)) ){
			if (isset($stat->bookmarks_count) && !empty($stat->bookmarks_count))
				$stat->bookmarks_count++;
			else 
				$stat->bookmarks_count = 1;
			$stat->save();
			return;
		}else{
			$stat = new StatisticsOperation;
			$stat->new_id = $id;
			$stat->views_count = 1;
			$stat->shares_gp_count = $stat->shares_vk_count = $stat->shares_tw_count = $stat->shares_fb_count = $stat->downloads_count = 0;
			$stat->bookmarks_count = 1;
			$stat->save();			
			return;
		}
		return;
	}

	public static function viewStatistics($id)
	{
		$ses = array();
		if (empty(Yii::app()->session['viewed'])){
			Yii::app()->session['viewed'] = array();
			$ses = Yii::app()->session['viewed'];
		}else{
			$ses = Yii::app()->session['viewed'];
			$ind = in_array($id,$ses);
			if ($ind)
				return "0";
		}
		array_push($ses,$id);
		Yii::app()->session['viewed'] = $ses;
		$stat = StatisticsOperation::model()->findByPk($id);
		if ((isset($stat)) && (!empty($stat)) ){
			if (isset($stat->views_count) && !empty($stat->views_count))
				$stat->views_count++;
			else 
				$stat->views_count = 1;
			$stat->save();
			return "1";
		}else 
		return "0";
	}
    
    public static function shareStat($id, $soc)
	{
        $to = "shares_".$soc."_count";

        $stat = StatisticsOperation::model()->findByPk($id);
        if ($stat) {
            $stat->$to++;
        } else {
            $stat = new StatisticsOperation;
            $stat->new_id = $id;
            $stat->$to = 1;
        }
        $stat->save(false);

        return $stat->$to;
    }
    
    public static function downloadStat($id)
    {
		$stat = StatisticsOperation::model()->findByPk($id);
		if ($stat) {
            $stat->downloads_count++;
		} else {
			$stat = new StatisticsOperation;
			$stat->new_id = $id;
			$stat->downloads_count = 1;
		}
        $stat->save(false);

        return $stat->downloads_count;
    }
    
    public static function readability($url)
    {
        header('Content-Type: text/html; charset=utf-8');
        
        // get latest Medialens alert 
        // (change this URL to whatever you'd like to test)
        //$url = 'http://korrespondent.net/business/economics/1616316-vopreki-nizkim-dohodam-ukraincy-okazalis-bolshimi-tranzhirami-chem-evropejcy-analiz';
        $html = file_get_contents($url);
         
        // PHP Readability works with UTF-8 encoded content. 
        // If $html is not UTF-8 encoded, use iconv() or 
        // mb_convert_encoding() to convert to UTF-8.
        $nlines = count( $http_response_header );
        for ( $i = $nlines-1; $i >= 0; $i-- ) {
            $line = $http_response_header[$i];
            if ( substr_compare( $line, 'Content-Type', 0, 5, true ) == 0 ) {
                $content_type = $line;
                break;
            }
        }
         
        /* Get the MIME type and character set */
        preg_match( '@Content-Type:\s+([\w/+]+)(;\s+charset=(\S+))?@i', $content_type, $matches );
        if ( isset( $matches[1] ) )
            $mime = $matches[1];
        if ( isset( $matches[3] ) )
            $charset = $matches[3];
        else
            $charset = 'utf-8';
//        var_dump(strpos($url,'for-ua'));exit;
        if(strpos($url,'for-ua') > 0 || strpos($url,'for-ua') === 0)
            $charset = 'windows-1251';
        
        
        //if(!($html = iconv( $charset, "UTF-8//TRANSLIT", $html )))
            $html = iconv( $charset, "UTF-8//TRANSLIT", $html );
        
        // If we've got Tidy, let's clean up input.
        // This step is highly recommended - PHP's default HTML parser
        // often does a terrible job and results in strange output.
        if (function_exists('tidy_parse_string')) {
        	$tidy = tidy_parse_string($html, array(), 'UTF8');
        	$tidy->cleanRepair();
        	$html = $tidy->value;
        }
        
        // give it to Readability
        $readability = new Readability($html, $url);
        
        // print debug output? 
        // useful to compare against Arc90's original JS version - 
        // simply click the bookmarklet with FireBug's 
        // console window open
        $readability->debug = false;
        
        // convert links to footnotes?
        $readability->convertLinksToFootnotes = false;
        
        // process it
        $result = $readability->init();
        
        // does it look like we found what we wanted?
        $out = array('title'=>'Title','text'=>'Text');
        if ($result) {
        	$out['title'] = $readability->getTitle()->textContent;
        
        	$content = $readability->getContent()->innerHTML;
        
        	// if we've got Tidy, let's clean it up for output
        	if (function_exists('tidy_parse_string')) {
        		$tidy = tidy_parse_string($content, 
        			array('indent'=>true, 'show-body-only'=>true), 
        			'UTF8');
        		$tidy->cleanRepair();
        		$content = $tidy->value;
        	}
        	$out['text'] = $content;
        }
      	return $out;
    }
    
    public static function createAdminUrl($action,$model,$id)
    {
        return '/yiiadmin/manageModel/' . $action . '?model_name=' . $model . '&pk=' . $id;
    }
 
	public static function createTextImg($model)
	{	
        $file = $model->preview_source;
	    $path = 'http://'.$_SERVER['HTTP_HOST'] . '/' . News::PREVIEW_PATH;
		$file = $path . $file;
		//var_dump(file_get_contents($file));exit;
		if(file_exists($file))
		{
			//TODO add logic here.
		}

        $fname = $model->slug;
        //$image_path_name = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/preview/thumb2/'.$model->slug.".jpg";
        //$file_new = CGallery::generateImage($file);
        $text_preg = $model->getTeaserOrTitle();
        $presset = preg_match("/^<p>/",$text_preg);

        if (!$presset){
            $text_edit = $model->getTeaserOrTitle();
        }
        else {
            $text_edit = substr($model->getTeaserOrTitle(),3,-4);
        }
        
        $text = strip_tags(str_replace("\n", " ", $text_edit));

        $words = explode(" ", $text);
        for ($i=0; $i <= count($words)-1; $i++) {
            //$word = $words[$i];
            $word_length[] = strlen($words[$i]." ")/2;
            //$string_1 = $word_length[2];
        }

        $str_length = strlen($text)/2; //длина строки

        $image_data = file_get_contents($file);
        $im = imagecreatefromstring($image_data);

//        $im = imagecreatefromjpeg($file); old way of saving image don't


        $color = imagecolorallocate($im, 255, 255, 255);
        $color_bg = imagecolorallocatealpha($im, 0, 0, 0, 50);
        $sum_length = 0; // сумма всех слов (по началу равна нулю)
		$limit_str_length = (int)Aii::param('news_text_length');//33;
		$text_x = (int)Aii::param('news_text_x');//33;
		$text_y = (int)Aii::param('news_text_y');//442;
		$cright_x = (int)Aii::param('news_cright_x');//310;
		$cright_y = (int)Aii::param('news_cright_y');//465;
		$line_x1 = (int)Aii::param('news_line_x1');//310;
		$line_y1 = (int)Aii::param('news_line_y1');//467;
		$line_x2 = (int)Aii::param('news_line_x2');//460;
		$line_y2 = (int)Aii::param('news_line_y2');//467;

        $string_1 = "";
        $string_2 = "";
        $string_3 = "";
        $string_4 = "";
        $string_5 = "";
        $string_6 = "";
        $string_7 = "";
//var_dump($str_length);exit;
        if ($str_length >= $limit_str_length) {
            for ($i = 0; $i <= count($words)-1; $i++) {
                if ($sum_length <= $limit_str_length) {
                    $sum_length += $word_length[$i];
                    if ($words[$i] == "&ndash;") {
                    	$words[$i] = str_replace("&ndash;", "-", $words[$i]);
                    }


                    $string_1 .= $words[$i]." ";
                }
                else if (($sum_length > $limit_str_length) && ($sum_length <= $limit_str_length*2)){
                    $sum_length += $word_length[$i];
                    if ($words[$i] == "&ndash;") {
                    	$words[$i] = str_replace("&ndash;", "-", $words[$i]);
                    }

                    $string_2 .= $words[$i]." ";
                }
                else if (($sum_length > $limit_str_length*2) && ($sum_length <= $limit_str_length*3)){
                    $sum_length += $word_length[$i];
                    if ($words[$i] == "&ndash;") {
                    	$words[$i] = str_replace("&ndash;", "-", $words[$i]);
                    }

                    $string_3 .= $words[$i]." ";
                }
                else if (($sum_length > $limit_str_length*3) && ($sum_length <= $limit_str_length*4)){
                    $sum_length += $word_length[$i];
                    if ($words[$i] == "&ndash;") {
                    	$words[$i] = str_replace("&ndash;", "-", $words[$i]);
                    }

                    $string_4 .= $words[$i]." ";
                }
                else if (($sum_length > $limit_str_length*4) && ($sum_length <= $limit_str_length*5)){
                    $sum_length += $word_length[$i];
                    if ($words[$i] == "&ndash;") {
                    	$words[$i] = str_replace("&ndash;", "-", $words[$i]);
                    }

                    $string_5 .= $words[$i]." ";
                }
                else if (($sum_length > $limit_str_length*5) && ($sum_length <= $limit_str_length*6)){
                    $sum_length += $word_length[$i];
                    if ($words[$i] == "&ndash;") {
                    	$words[$i] = str_replace("&ndash;", "-", $words[$i]);
                    }

                    $string_6 .= $words[$i]." ";
                }
                else if (($sum_length > $limit_str_length*6) && ($sum_length <= $limit_str_length*7)){
                    $sum_length += $word_length[$i];
                    if ($words[$i] == "&ndash;") {
                    	$words[$i] = str_replace("&ndash;", "-", $words[$i]);
                    }
                    $string_7 .= $words[$i]." ";
                }
            }
        }

        $font_path = "fonts/arial.ttf";
        $font_nk = "fonts/MyriadPro-Regular.otf";
        $font_size = (int)Aii::param('news_font_size');
        $font_size_nk = (int)Aii::param('news_font_size_copyright');
        $interval = (int)Aii::param('news_font_interval');
        $bg_koef = (int)Aii::param('news_bg_height_koef');
        // www.newskeeper.net ----------
        //$nk_text = $_SERVER['HTTP_HOST'];
        $nk_text = Aii::param('news_copyright_text');
        //------------------------------
        
        // Когда выводится 1-а строка текста------------------------------------
        if ($str_length <= $limit_str_length) {
            for ($i = 0; $i <= count($words)-1; $i++) {
                $string_1 .= $words[$i]." ";    
            }
            $pattern_bg = imagefilledrectangle($im,0,400, News::PREVIEW_SIZE, News::PREVIEW_SIZE,$color_bg);
            imagettftext($im,$font_size,0,$text_x, $text_y, $color, $font_path, $string_1);
            // www.newskeeper.net
            imagettftext($im,$font_size_nk,0, $cright_x, $cright_y, $color, $font_nk, $nk_text);
            // Линия
            //imageline($im, $line_x1, $line_y1, $line_x2, $line_y2, $color);
        }
        
        // Когда выводится 2-е строки текста------------------------------------
        if (($sum_length > $limit_str_length) && ($sum_length <= $limit_str_length*2)) {
            $pattern_bg = imagefilledrectangle($im,0, $text_y-($bg_koef*2), News::PREVIEW_SIZE, News::PREVIEW_SIZE,$color_bg);
            imagettftext($im,$font_size,0,$text_x, $text_y-$interval, $color, $font_path, $string_1);
            imagettftext($im,$font_size,0,$text_x, $text_y, $color, $font_path, $string_2);
            // www.newskeeper.net
            imagettftext($im, $font_size_nk, 0, $cright_x, $cright_y, $color, $font_nk, $nk_text);
            // Линия
            //imageline($im, $line_x1, $line_y1, $line_x2, $line_y2, $color);
        }
        // Когда выводится 3-и строки текста------------------------------------
        if (($sum_length > $limit_str_length*2) && ($sum_length <= $limit_str_length*3)) {
            $pattern_bg = imagefilledrectangle($im,0, $text_y-($bg_koef*3), News::PREVIEW_SIZE, News::PREVIEW_SIZE,$color_bg);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*2), $color, $font_path, $string_1);
            imagettftext($im,$font_size,0,$text_x, $text_y-$interval, $color, $font_path, $string_2);
            imagettftext($im,$font_size,0,$text_x, $text_y, $color, $font_path, $string_3);
            // www.newskeeper.net
            imagettftext($im,$font_size_nk,0, $cright_x, $cright_y, $color, $font_nk, $nk_text);
            // Линия
            //imageline($im, $line_x1, $line_y1, $line_x2, $line_y2, $color);
        }
        // Когда выводится 4-е строки текста------------------------------------
        if (($sum_length > $limit_str_length*3) && ($sum_length <= $limit_str_length*4)) {
            $pattern_bg = imagefilledrectangle($im,0, $text_y-($bg_koef*4), News::PREVIEW_SIZE, News::PREVIEW_SIZE,$color_bg);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*3), $color, $font_path, $string_1);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*2), $color, $font_path, $string_2);
            imagettftext($im,$font_size,0,$text_x, $text_y-$interval, $color, $font_path, $string_3);
            imagettftext($im,$font_size,0,$text_x, $text_y, $color, $font_path, $string_4);
            // www.newskeeper.net
            imagettftext($im,$font_size_nk,0, $cright_x, $cright_y, $color, $font_nk, $nk_text);
            // Линия
            //imageline($im, $line_x1, $line_y1, $line_x2, $line_y2, $color);
        }
        // Когда выводится 5-е строки текста------------------------------------
        if (($sum_length > $limit_str_length*4) && ($sum_length <= $limit_str_length*5)) {
            $pattern_bg = imagefilledrectangle($im,0, $text_y-($bg_koef*5), News::PREVIEW_SIZE, News::PREVIEW_SIZE,$color_bg);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*4), $color, $font_path, $string_1);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*3), $color, $font_path, $string_2);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*2), $color, $font_path, $string_3);
            imagettftext($im,$font_size,0,$text_x, $text_y-$interval, $color, $font_path, $string_4);
            imagettftext($im,$font_size,0,$text_x, $text_y, $color, $font_path, $string_5);
            // www.newskeeper.net
            imagettftext($im,$font_size_nk,0, $cright_x, $cright_y, $color, $font_nk, $nk_text);
            // Линия
            //imageline($im, $line_x1, $line_y1, $line_x2, $line_y2, $color);
        }
        // Когда выводится 6-е строки текста------------------------------------
        if (($sum_length > $limit_str_length*5) && ($sum_length <= $limit_str_length*6)) {
            $pattern_bg = imagefilledrectangle($im,0, $text_y-($bg_koef*6), News::PREVIEW_SIZE, News::PREVIEW_SIZE,$color_bg);
            imagettftext($im,$font_size,0, $text_x, $text_y-($interval*5), $color, $font_path, $string_1);
            imagettftext($im,$font_size,0, $text_x, $text_y-($interval*4), $color, $font_path, $string_2);
            imagettftext($im,$font_size,0, $text_x, $text_y-($interval*3), $color, $font_path, $string_3);
            imagettftext($im,$font_size,0, $text_x, $text_y-($interval*2), $color, $font_path, $string_4);
            imagettftext($im,$font_size,0, $text_x, $text_y-$interval, $color, $font_path, $string_5);
            imagettftext($im,$font_size,0, $text_x, $text_y, $color, $font_path, $string_6);
            // www.newskeeper.net
            imagettftext($im,$font_size_nk,0, $cright_x, $cright_y, $color, $font_nk, $nk_text);
            // Линия
            //imageline($im, $line_x1, $line_y1, $line_x2, $line_y2, $color);
        }
        // Когда выводится 7-е строки текста------------------------------------
        if (($sum_length > $limit_str_length*6) && ($sum_length <= $limit_str_length*7)) {
            $pattern_bg = imagefilledrectangle($im,0, $text_y-($bg_koef*7), News::PREVIEW_SIZE, News::PREVIEW_SIZE,$color_bg);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*6), $color, $font_path, $string_1);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*5), $color, $font_path, $string_2);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*4), $color, $font_path, $string_3);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*3), $color, $font_path, $string_4);
            imagettftext($im,$font_size,0,$text_x, $text_y-($interval*2), $color, $font_path, $string_5);
            imagettftext($im,$font_size,0,$text_x, $text_y-$interval, $color, $font_path, $string_6);
            imagettftext($im,$font_size,0,$text_x, $text_y, $color, $font_path, $string_7);
            // www.newskeeper.net
            imagettftext($im,$font_size_nk,0, $cright_x, $cright_y, $color, $font_nk, $nk_text);
            // Линия
            //imageline($im, $line_x1, $line_y1, $line_x2, $line_y2, $color);
        }

        //$file_name = substr($model->preview_source,6);
        $image_path_name = News::DOWNLOADPATH . $model->slug . '_' . Yii::app()->language . '.png';
        //$image_path = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/preview/thumb2/';
        //header("Content-type: image/png");
        imagepng($im, $image_path_name);
        imageDestroy($im);

        return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $image_path_name;
	}
}