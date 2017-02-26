<?php
Yii::setPathOfAlias('Imagine',Yii::getPathOfAlias('application.vendors.Imagine'));
/*Yii::setPathOfAlias('Box',Yii::getPathOfAlias('application.vendors.Imagine.Image.Box'));
Yii::setPathOfAlias('Point',Yii::getPathOfAlias('application.vendors.Imagine.Image.Point'));*/

/*Yii::import('application.vendors.Imagine.Gd.Imagine');
Yii::import('application.vendors.Imagine.Image.Box');
Yii::import('application.vendors.Imagine.Image.Point');*/

class Thumb
{
    const ORIGINAL_DIR = 'uploads';
    const THUMB_DIR = 'thumbs';
    
    public static function preview($_path, $thumb = array('width' => 444, 'height' => 310))
    {
        return self::thumbnail($_path, $thumb);
    }  
    
    public static function show($_path, $thumb = array('width' => 540, 'height' => 390))
    {
        return self::thumbnail($_path, $thumb, true);
    }
    
    public static function crop($_path, $thumb = array('width' => News::PREVIEW_SIZE, 'height' => News::PREVIEW_SIZE))
    {
        return self::thumbnail($_path, $thumb);
    }
    
    public static function listadmin($_path, $thumb = array('width' => 100, 'height' => 100))
    {
        return self::thumbnail($_path, $thumb);
    }
    
    public static function front_program($_path, $thumb = array('width' => 614, 'height' => 350))
    {
        return self::thumbnail($_path, $thumb);
    }
    
    public static function front_artist($_path, $thumb = array('width' => 422, 'height' => 240))
    {
        return self::thumbnail($_path, $thumb);
    }
    
    public static function front_slide($_path, $thumb = array('width' => 1920, 'height' => 600))
    {
        return self::thumbnail($_path, $thumb);
    }
    
    public static function side_slide($_path, $thumb = array('width' => 392, 'height' => 275))
    {
        return self::thumbnail($_path, $thumb);
    }
    
    public static function thumbnail($_path, $thumb = array('width' => 201, 'height' => 134), $_inset = false)
    {
        $path_arr = explode('/', $_path);
        $fname = $_path;//end($path_arr);
        $dirname = $thumb['width'] . 'x' . $thumb['height'];
        $thumbpath = '/' . self::THUMB_DIR . '/' . $dirname . '/' . $fname;
        $original = $_SERVER['DOCUMENT_ROOT'] . '/' . self::ORIGINAL_DIR . '/' . $_path;
        
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $thumbpath))
        {
            $imagine = new Imagine\Gd\Imagine();
            if(file_exists($original))
                $image = $imagine->open($original);
            else
                return;
            
            $dirpath = $_SERVER['DOCUMENT_ROOT'] . '/' . self::THUMB_DIR . '/' . $dirname;
            
            if(!is_dir($_SERVER['DOCUMENT_ROOT'] . '/' . self::THUMB_DIR))
                mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . self::THUMB_DIR);
            if(!is_dir($dirpath))
                mkdir($dirpath);

            $size = $image->getSize();
            if($size->getWidth() < $thumb['width'])
            {
                $thumb['width'] = $size->getWidth();
            }
            if($size->getHeight() < $thumb['height'])
            {
                $thumb['height'] = $size->getHeight();
            }
                
            if($size->getWidth() > $size->getHeight())
            {
                $resize = self::calculateResizeByHeight($thumb, $size);
                
                if($_inset == true)
                {
                    if($resize['width'] < $thumb['width'])
                    {
                        $resize = self::calculateResizeByWidth($thumb, $size);
                    }else{
            		    $resize = self::calculateResizeByHeight($thumb, $size);
                    }
                }else{
                    if($resize['width'] < $thumb['width'])
                    {
                        $resize = self::calculateResizeByWidth($thumb, $size);
                    }else{
            		    $resize = self::calculateResizeByHeight($thumb, $size);
                    }
                }
                    
                $offset = self::calculateCropOffsetWidth($thumb, $resize);
            }else{
                $resize = self::calculateResizeByWidth($thumb, $size);
                
                if($_inset == true)
                {
                    if($resize['height'] < $thumb['height'])
                    {
                        $resize = self::calculateResizeByWidth($thumb, $size);
                    }else{
            		    $resize = self::calculateResizeByHeight($thumb, $size);
                    }
                }else{
                    if($resize['height'] < $thumb['height'])
                    {
            		    $resize = self::calculateResizeByHeight($thumb, $size);
                    }else{
                        $resize = self::calculateResizeByWidth($thumb, $size);
                    }
                }
                
                $offset = self::calculateCropOffsetHeight($thumb, $resize);
            }

            if($_inset){
                $image
                    ->resize( new Imagine\Image\Box($resize['width'], $resize['height']) )
                    ->save( $_SERVER['DOCUMENT_ROOT'] . $thumbpath )
                ;
            }
            else{
                $image
                    ->resize( new Imagine\Image\Box($resize['width'], $resize['height']) )
                    ->crop( new Imagine\Image\Point($offset['width'], $offset['height']), new Imagine\Image\Box($thumb['width'], $thumb['height']) )
                    ->save( $_SERVER['DOCUMENT_ROOT'] . $thumbpath )
                ;
            }
        }
        
        return $thumbpath;
    }
    
    protected static function calculateResizeByWidth($thumb, $size)
    {
        $width = $thumb['width'];
        $k = $width / $size->getWidth();
        $height = $k * $size->getHeight();
        
        return array('width' => $width, 'height' => $height);
    }
    
    protected static function calculateResizeByHeight($thumb, $size)
    {
	    $height = $thumb['height'];
        $k = $height / $size->getHeight();
        $width = $k * $size->getWidth();
        
        return array('width' => $width, 'height' => $height);
    }
    
    protected static function calculateCropOffsetWidth($thumb, $resize)
    {          
        $offset = array(
            'width' => ($resize['width'] - $thumb['width']) / 2,
            'height' => 0
        );
        if($offset['width'] < 0)
            $offset['width'] = 0;
        
        return $offset;
    }
    
    protected static function calculateCropOffsetHeight($thumb, $resize)
    {
        $offset = array(
            'width' => 0, 
            'height' => ($resize['height'] - $thumb['height']) / 2,
        );
        if($offset['height'] < 0)
            $offset['height'] = 0;
        
        return $offset;
    }
}