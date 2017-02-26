<?php
/**
 * Gallery helper class.
 *
 * $Id: arr.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Core
 * @author     Art Gek
 * @copyright  (c) 2013
 */
class CGallery
{
	const NOFOTO = 'nofoto.jpg';
    const CIRCLE = 1;
    const SQUARE = 2;
    const PREVIEW_QUALITY = 100;
    const PREVIEW_PNG_QUALITY = 9;
    const PREVIEW_MAXWIDTH = 600;
	
	public static function thumb_span($file,$path,$width,$height,$options = array(),$shape = "",$img = false)
	{
	    if($shape == self::CIRCLE){
	        $border_length = $width;
		    $width = $height;
        }
        $newname = self::thumbnailNameX($file,$path,$width,$height);
		if(!$newname)
			return "<div class='noimage'></div>";
		//$size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$path.'/thumb/'.$newname)
        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$path.'/'.$newname))
		{
            $size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$path.'/'.$newname);
        }else{
            return $path.'/'.$newname;
        }
        $margvert = '0';
        switch($shape)
        {
            case self::CIRCLE:
                $style['width'] = $border_length;$style['height'] = $border_length;
                if(isset($options['class'])){
    		         $options['class'] = $options['class'].' thumb';
    		    }else{
    		        $options['class'] = 'thumb';
    		    }
            break;
            case self::SQUARE: 
                $style['width'] = $width;$style['height'] = $width;
            break;
            default: 
                $style['width'] = $size[0];$style['height'] = $size[1];
            break;
        }
        
		$opt_str = "";
        $style_str = '';
		foreach($options as $k=>$v){
		  if($k == 'style')
            $style_str = $v;
          else
    		$opt_str .= $k."='".$v."'";
		}
		
        if($img)
            return "<img src='/".$path."/thumb/".$newname."' style='width:".$style['width']."px; height:".$style['height']."px;'>";
        else
		    return "<div style='background: url(/".$path."/".$newname.") no-repeat; width:".$style['width']."px; height:".$style['height']."px; ".$style_str."' ".$opt_str."></div>";
	}

	public static function slide_span($file,$width,$height,$options = array())
	{
		$newname = self::thumbnailName($file,$width,$height);
		if(!$newname)
			return "<span class='thumb' style='background: url(/uploads/pictures/thumb/angel160x130.jpg) no-repeat;'></span>";
		$opt_str = "";
		foreach($options as $k=>$v){
		    $opt_str .= $k."='".$v."'";
		}
		
		return "<span class='thumb' style='background: url(/uploads/pictures/thumb/".$newname.") no-repeat; ".$opt_str."></span>";
	}
	
	public static function thumbnailName($file,$path,$width,$height)
	{
		if(!file_exists($path.'/'.$file) || $file == '')
		{
			//$path = 'images';
			//$file = self::NOFOTO;
			//if(!file_exists($path.'/'.$file)) 
			return false;
		}
		$image = Yii::app()->image->load($path.'/'.$file);
        $size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$path.'/'.$file);
        if($size[0] > $size[1]){
		    $image->resize(0, $height);
        }else{
            $image->resize($width, 0);
        }
		
		$ar_file = explode(".",$file);
		$newname = strtolower($ar_file[0]).$width."x".$height.".jpg";//.$ar_file[1];
		//if($path == 'images') $path = 'preview';
		$image->save($path.'/thumb/'.$newname,false);
		return $newname;
	}
	
	public static function thumbnailNameX($file,$path,$width,$height)
	{
		if(!file_exists($path.'/'.$file) || $file == '')
		{
			//$path = 'images';
			//$file = self::NOFOTO;
			//if(!file_exists($path.'/'.$file)) 
			return false;
		}
		$image = Yii::app()->image->load($path.'/'.$file);
        $size = getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$path.'/'.$file);
        if($size[0] > $size[1]){
		    $image->resize(0, $height);
        }else{
            $image->resize($width, 0);
        }
		
		$ar_file = explode(".",$file);
		//$newname = strtolower($ar_file[0]).$width."x".$height.".jpg";//.$ar_file[1];
        $newname = $ar_file[0].'_'.$width.'x'.$height.".jpg";
		//if($path == 'images') $path = 'preview';
		$image->save($path.'/'.$newname,false);
		return $newname;
	}

    public static function uploadNews($path)
    {
    	$params = array(
    		'weight' => News::PREVIEW_WEIGHT,
    		'size' => News::PREVIEW_SIZE,
    	);
    	
    	return self::upload($path, $params);
    }

    public static function uploadAva($path)
    {
    	$params = array(
    		'weight' => News::PREVIEW_WEIGHT,
    		'size' => User::PREVIEW_SIZE,
    	);
    	
    	return self::upload($path, $params);
    }
    
    public static function upload($path, $params)
    {
    	$data = array('error' => 0);
    	
        $mimes = array('jpg','jpeg','png');
        
        $file_ar = explode('.',$_FILES['loadedFile']['name']);
        
        if(!in_array(strtolower($file_ar[sizeof($file_ar)-1]), $mimes))
        {
			$data['error'] = 1;
			$data['msg'] = 'Неверное расширение файла';
		}elseif(isset($params['weight']) && $_FILES['loadedFile']['size'] > $params['weight'])
		{
			$data['error'] = 1;
			$data['msg'] = 'Слишком большой файл';
		}else{
	        $filename = self::ruslat(str_replace(' ', '_', $_FILES['loadedFile']['name']));
	        $filename_tmp = time() . 'tmp' . $filename;
	        $file_save = $path . $filename;
	        $file_tmp_save = $path . $filename_tmp;
	        $file_save_thumb = $path.'thumb/'.$filename;
	        $file_save_tmp = $path.'tmp/'.$filename;
	        
	        $data['tmp'] = $filename_tmp;
	        $data['tmp_full'] = $file_tmp_save;
	        $data['tmp_full_thumb'] = $file_save_thumb;
	        $data['tmp_full_tmp'] = $file_save_tmp;

	        move_uploaded_file($_FILES['loadedFile']['tmp_name'], $file_save);
	        
	        $image = Yii::app()->image->load($file_save);
	        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $file_save;
	        $size = getimagesize($full_path);
	        
	        if(isset($params['size']) && ($size[0] < $params['size'] || $size[1] < $params['size']))
	        {
				$data['error'] = 1;
				$data['msg'] = 'Изображение меньше чем ' . $params['size'] . 'x' . $params['size'] . 'px';
		        unlink($full_path);
			}else{
		        /*if($size[0] > $size[1] && $size[0] > 700){
				    $image->resize(0, 700);
		        }else{
		            if($size[1] > 700)
		                $image->resize(700, 0);
		        }*/
		        $image->save($file_save,false);
		        
		        if($size[0] > self::PREVIEW_MAXWIDTH)
		        {
				    $image->resize(self::PREVIEW_MAXWIDTH, 0);
		        }
		        
		        $data['koef'] = $size[0] / self::PREVIEW_MAXWIDTH;
		        if($data['koef'] < 1)
		        	$data['koef'] = 1;
		        
		        
		        $image->save($file_tmp_save, false);
			}
		}
        
        return $data;
    }
    
    public static function crop($path, $size)
    {
    	$data = array();
    	
    	$x = $_POST['x'] * $_POST['koef'];
    	$y = $_POST['y'] * $_POST['koef'];
    	$w = $_POST['w'] * $_POST['koef'];
    	$h = $_POST['h'] * $_POST['koef'];
    	
    	$filename = self::ruslat (str_replace(' ','_', $_POST['file_name']));
        $imgar = explode('.',$filename);
        $format = array_pop($imgar);
        $name_wout_format = implode('.',$imgar);
        $thname = $name_wout_format . $w . 'x' . $h . '.' . $format;
        $thpath = $path.'thumb/';
        $tmppath = $path.'tmp/';
        $thpath = $tmppath;
        $tmp_save = $tmppath.$thname;
        $thumb_save = $tmp_save;
        switch(strtolower($format)){
            case 'jpg': $img_r = imagecreatefromjpeg($path.$filename);break;
            case 'jpeg': $img_r = imagecreatefromjpeg($path.$filename);break;
            case 'png': $img_r = imagecreatefrompng($path.$filename);break;
        }
        $croped = ImageCreateTrueColor( $w, $h );
        
        $x_cor = 0;
        $y_cor = 0;
        imagecopyresampled($croped, $img_r, 0, 0, $x+$x_cor, $y+$y_cor, $w, $h, $w, $h);
        
        switch(strtolower($format)){
            case 'jpg': imagejpeg($croped,$thumb_save,self::PREVIEW_QUALITY);break;
            case 'jpeg': imagejpeg($croped,$thumb_save,self::PREVIEW_QUALITY);break;
            case 'png':  imagepng($croped,$thumb_save,self::PREVIEW_PNG_QUALITY);break;
        }
        
        $image = Yii::app()->image->load($thumb_save);
        $image->resize($size, $size);
        $previewname = str_replace(' ','_', $name_wout_format.time().'.'.$format);
		$image->save($thpath.$previewname,false);
        
        $data['previewname'] = $previewname;
        $data['preview_fullpath'] = $path . $previewname;
        $data['preview_thumbpath'] = 'thumb/' . $previewname;
        
        return $data;
    }
    
    public static function moveAfterCrop($fname, $path)
    {
        $file = 'tmp/'.$fname;
        $tmppath = $path . $file;
        
        if(file_exists($tmppath))
        {
            if (!copy($tmppath, $path . $fname)) {
                echo "не удалось скопировать $tmppath...\n";
            }
            unlink($tmppath);
        }
        //var_dump($tmppath, $path);exit;
    }
    
    public static function ruslat ($string) # Задаём функцию перекодировки кириллицы в транслит.
    {
        $string = str_replace("ж","zh",$string);
        $string = str_replace("ё","yo",$string);
        $string = str_replace("й","i",$string);
        $string = str_replace("ї","i",$string);
        $string = str_replace("і","i",$string);
        $string = str_replace("ю","yu",$string);
        $string = str_replace("ь","",$string);
        $string = str_replace("ч","ch",$string);
        $string = str_replace("щ","sh",$string);
        $string = str_replace("ц","c",$string);
        $string = str_replace("у","u",$string);
        $string = str_replace("к","k",$string);
        $string = str_replace("є","e",$string);
        $string = str_replace("е","e",$string);
        $string = str_replace("н","n",$string);
        $string = str_replace("г","g",$string);
        $string = str_replace("ш","sh",$string);
        $string = str_replace("з","z",$string);
        $string = str_replace("х","h",$string);
        $string = str_replace("ъ","",$string);
        $string = str_replace("ф","f",$string);
        $string = str_replace("ы","y",$string);
        $string = str_replace("в","v",$string);
        $string = str_replace("а","a",$string);
        $string = str_replace("п","p",$string);
        $string = str_replace("р","r",$string);
        $string = str_replace("о","o",$string);
        $string = str_replace("л","l",$string);
        $string = str_replace("д","d",$string);
        $string = str_replace("э","ye",$string);
        $string = str_replace("я","ja",$string);
        $string = str_replace("с","s",$string);
        $string = str_replace("м","m",$string);
        $string = str_replace("и","i",$string);
        $string = str_replace("т","t",$string);
        $string = str_replace("б","b",$string);
        $string = str_replace("Ё","yo",$string);
        $string = str_replace("Й","I",$string);
        $string = str_replace("Ю","YU",$string);
        $string = str_replace("Ч","CH",$string);
        $string = str_replace("Ь","",$string);
        $string = str_replace("Щ","SH",$string);
        $string = str_replace("Ц","C",$string);
        $string = str_replace("У","U",$string);
        $string = str_replace("К","K",$string);
        $string = str_replace("Е","E",$string);
        $string = str_replace("Н","N",$string);
        $string = str_replace("Г","G",$string);
        $string = str_replace("Ш","SH",$string);
        $string = str_replace("З","Z",$string);
        $string = str_replace("Х","H",$string);
        $string = str_replace("Ъ","",$string);
        $string = str_replace("Ф","F",$string);
        $string = str_replace("Ы","Y",$string);
        $string = str_replace("В","V",$string);
        $string = str_replace("А","A",$string);
        $string = str_replace("П","P",$string);
        $string = str_replace("Р","R",$string);
        $string = str_replace("О","O",$string);
        $string = str_replace("Л","L",$string);
        $string = str_replace("Д","D",$string);
        $string = str_replace("Ж","Zh",$string);
        $string = str_replace("Э","Ye",$string);
        $string = str_replace("Я","Ja",$string);
        $string = str_replace("С","S",$string);
        $string = str_replace("М","M",$string);
        $string = str_replace("И","I",$string);
        $string = str_replace("Т","T",$string);
        $string = str_replace("Б","B",$string);
        
        return $string;
    }

} // End gal