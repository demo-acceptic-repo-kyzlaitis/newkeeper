$(document).ready(function(){
        
    initUploadAndCropBlog();
    window.crop_html = $('#crop').html();
    $('#cropped, #preview-pane').hide();
    $('#addAva').click(function(){
    })

});
function initUploadAndCropBlog()
{
    $('#fileupload_blog').fileupload({
        dataType: 'json',
        autoUpload: true,
        //imageMaxWidth: 800,
        //disableImageResize: false,
        send: function (e, data)
        {
            $('#loader').show();
            $('.begin_upload').hide();
            loading();
        },
        done: function(e, data)
        {
        	unloading();
            window.imgname = data.originalFiles[0].name;
            window.result = data.result;
            popup_funcs['cropblog']();
        }
    });

    
    
}

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
  }
  
    function updatePreview(c)
    {
      if (parseInt(c.w) > 0)
      {
        var rx = xsize / c.w;
        var ry = ysize / c.h;

        $pimg.css({
          width: Math.round(rx * window.boundx) + 'px',
          height: Math.round(ry * window.boundy) + 'px',
          marginLeft: '-' + Math.round(rx * c.x) + 'px',
          marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
      }
    }