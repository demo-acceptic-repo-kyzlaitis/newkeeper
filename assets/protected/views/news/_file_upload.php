<div class="wrap">
<div id="fileUpload">
<img id="loader" src="/css/img/loaders/1d_2.gif" />
<div class="begin_upload">
    <span>Загрузите фото</span>
    <input id="fileupload" type="file" name="loadedFile" data-url="/news/upload" multiple />
</div>
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
            <div class="adm_btn_popup">
    			<span class="btn btn-success" id="cropped" >Обрезать</span>
    			<span class="btn btn-danger" id="reset_popup_crop" >Закрыть</span>
            </div>
</form>
</div>
</div>