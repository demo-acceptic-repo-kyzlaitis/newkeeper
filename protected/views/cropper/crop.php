<section id="main_section">
  <script src="/js/jquery.Jcrop.js"></script>
  <link rel="stylesheet" href="/css/main.css" type="text/css" />
  <link rel="stylesheet" href="/css/demos.css" type="text/css" />
  <link rel="stylesheet" href="/css/jquery.Jcrop.css" type="text/css" />
<?php $h_arr = explode('_',$header);//var_dump($h_arr);exit();
if (isset($header) && count($h_arr) == 3){
    //var_dump($file);exit();
    	$file_name = $file->tempName;
    	$image = imagecreatefromjpeg($file_name);
    	$file_save_full = "http://".$_SERVER['HTTP_HOST']."/uploads/".$h_arr[0]."/temp_id_".$id.".jpg";
    	$file_save = "uploads/".$h_arr[0]."/temp_id_".$id.".jpg";
    //var_dump($file_save);exit();
    	imagejpeg($image,$file_save);
}
if (isset($header) && ($header == "cropped")){
	if (isset($h)){
		$targ_w = $w;
        $targ_h = $h;
		$jpeg_quality = 90;

		$src = $file_save;
		$img_r = imagecreatefromjpeg($src);
		// echo "</pre>";
		// var_dump($src);
		// echo "<pre>"; 
		// die("HERE");
		
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

		imagecopyresampled($dst_r,$img_r,0,0,$x,$y,	$targ_w,$targ_h,$w,$h);
		switch($engine)
        {
		    case 'avatars': $fname = "avatar_id_".$id.".jpg";
                            $file_save = "uploads/".$engine."/".$fname;
                            break;
            case 'preview': $fname = "thumb".rand(1000,9999).".jpg";
                            $file_save = "uploads/".$engine."/".$fname;
                            break;
		}
        
		imagejpeg($dst_r,$file_save,$jpeg_quality);
		//die(var_dump($file_save));
        $send = json_encode(array('file_save'=>$fname,'type'=>$type,'id'=>$id));        
		$this->redirect(array('/cropper/doit','params'=>$send));
	}
	else $this->redirect("crop");
}

// If not a POST request, display page below:
if($h_arr[2] == 'image')
    $aspect_ratio = 0;
else
    $aspect_ratio = 1;
?>


 
<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      onSelect: updateCoords,
      aspectRatio: <?php echo $aspect_ratio; ?>,
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
<style type="text/css">
  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }


</style>
		<!-- This is the image we're attaching Jcrop to -->
		<img src="<?=($file_save_full) ? $file_save_full : ''?>" id="cropbox" />

<?php //var_dump($h_arr);exit(); ?>
		<!-- This is the form that our event handler fills -->
		<form id="crop_submit" action="/cropper/crop" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="engine" name="engine" value="<?php echo $h_arr[0];?>" />
			<input type="hidden" id="type" name="type" value="<?php echo $h_arr[2];?>" />
			<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
			<input type="hidden" value="<?=($file_save_full) ? $file_save_full : ''?>" id="file_save_full" name="file_save" />
			<input type="submit" value="Crop Image" class="btn btn-large btn-inverse" />
		</form>
</section>