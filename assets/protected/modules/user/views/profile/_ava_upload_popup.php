<style>
#fileupload_ava:before {
  content: '';
 }
</style>
<div class="blog_pop">
<div class="wrap">
<div id="fileUpload">
<img id="loader" src="/css/img/loaders/1d_2.gif" />
<!--<div class="begin_upload">
    <span><?php echo Yii::t('app','Загрузите фото')?></span>
    <input id="fileupload_ava" type="file" name="loadedFile" data-url="/news/upload" />
</div>-->
  <div id="preview-pane">
    <div class="preview-container">
      <img src="" class="jcrop-preview" alt="Preview" />
    </div>
  </div>
<img src="" id="cropbox" />
<form id="crop_submit" action="/news/crop" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" value="" id="file_save" name="file_save" />
            <div class="crop_ok" style="display: none;">
    			<span class="" id="cropped_ava" ><?php echo Yii::t('app','Обрезать')?></span>
    			<span class="" id="reset_popup_crop" ><?php echo Yii::t('app','Закрыть')?></span>
            </div>
</form>
</div>
</div>
</div>