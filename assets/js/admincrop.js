$(document).ready(function(){
    
    initUploadAndCrop();
    //$('#cropped, #preview-pane').hide();
/*$('#addPic').click(function(){
    $.post('/news/fileupload',{'blog':$(this).parents('.display_thumb').attr('id')},function(data){
        $.colorbox({
            html:data,
            top:"10%",
            opacity: 0.5,
            transition:"fade",
            speed:100,
            width:850,
            //height: 800,
            closeButton:false,
            onComplete: function(){
                initUploadAndCrop();
                $('#cropped, #preview-pane').hide();
                $('#fileupload').click();
            },
        })
    })
})*/

});
function initUploadAndCrop()
{
    $('#fileupload').fileupload({
        autoUpload: true,
        dataType: 'json',
        //imageMaxWidth: 800,
        //disableImageResize: false,
        send: function (e, data)
        {
            loading('Загрузка..');
            $('.begin_upload').hide();
        },
        done: function(e, data)
        {console.log('done',data.result)
	        unloading();
	        window.result = data.result;
        	if(data.result.error == 1)
        	{
				alert(data.result.msg);
			}else{
	            window.imgname = data.originalFiles[0].name;
		        $.magnificPopup.open({
		    	  items: {
		    	      src: '/site/popup/cropava',
		    	      type: 'ajax'
		    	  },
		    	  callbacks: {
		    		  ajaxContentAdded: function() {  		      
	    		          $('.crop_ok').show();
		    		  	  initCrop();   		      
		    		      initJcrop(data);
		    		      $('.mfp-content *:not(.mfp-close)').addClass('mfp-prevent-close');
				      	  $('.blog_pop').width($('.jcrop-holder').width());
		    		  },
		              beforeOpen: function() {
		                  window.popup_opened = true;
		              },
			          open: function() {
			          	  //openActions();
			          },
			          close: function() {
			          	  //closeActions();
			          },
		              afterClose: function() {
		                  window.popup_opened = false;
		              }
		          }
		    	});
			}
		}
        /*send: function (e, data) {console.log('asdfas')
            $('#loader').show();
            $('.begin_upload, .jcrop-holder').hide();
        },
        done: function (e, data)
        {
            $.post('/news/fileupload',{'blog':$(this).parents('.display_thumb').attr('id')}, function(fileupload_data){
                $.colorbox({
                    html:fileupload_data,
                    top:"10%",
                    opacity: 0.5,
                    transition:"fade",
                    speed:100,
                    width:850,
                    //height: 800,
                    closeButton:false,
                    onComplete: function(){
                        initCrop();
                        initJcrop(data);
                        //$('#cropped, #preview-pane').hide();
                    },
                })
            })
        }*/
    });
    
    initCrop();
}

    function initJcrop(data)
    {
        $('.jcrop-holder').css('position','static');
        $('#colorbox, #cboxOverlay, #cboxWrapper').css('overflow', 'visible');
        console.log(data)
        window.imgname = data.originalFiles[0].name;
        $('.jcrop-preview').attr('src','/uploads/preview/'+window.imgname);
        $('.jcrop-holder img').attr('src','/'+data.result.tmp_full);
        $('#cropbox').attr('src','/'+data.result.tmp_full);
        
        //translite(data.originalFiles[0].name);
        $('#loader').hide();
        var jcrop_api = false;
        if(jcrop_api)
            jcrop_api.destroy();
            
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),
        
        xsize = $pcnt.width(),
        ysize = $pcnt.height();

        var minSizeDef = 350;
        var minSize = minSizeDef/data.result.koef;

        $('#cropbox').Jcrop({
            onSelect: updateCoords,
	        //onChange: updatePreview,
            aspectRatio: 1,
			allowSelect: false,
            minSize: [minSize, minSize],
            setSelect:   [ minSize, minSize, 50, 50 ],
            keySupport: false
        },function(){
            // Use the API to get the real image size
            var bounds = this.getBounds();
            window.boundx = bounds[0];
            window.boundy = bounds[1];

            jcrop_api = this;
            $('.jcrop-holder').addClass('mfp-prevent-close');
            $('.jcrop-holder *').addClass('mfp-prevent-close');
            
            preventCloseWhileDragSelected();
        });
        $('#cropped').show();
        $('.begin_upload').hide();
        $('.begin_upload').css('padding','10px 0');
        //console.log($('.jcrop-holder').width())
	    $('.mfp-content *:not(.mfp-close, #cropped_ava, #reset_popup_crop)').addClass('mfp-prevent-close');
    }

    function initCrop()
    {
        $('#cropped_ava').click(function(){
            $.post(
                '/news/crop',
                {
                    'x':$('#x').val(),'y':$('#y').val(),'w':$('#w').val(),'h':$('#h').val(),
                    'file_name':window.imgname,
	                'koef' : window.result.koef
                },
                function(data){
                    $('#loader').show();
                    $('#resetcrop').css('display','inline-block');
                    $('#cropbox').attr('src','/'+window.result.tmp_full_thumb);
                    $('.jcrop-holder').hide();
                    $('#cropbox').css({'display':'block','height':'auto','width':'auto','visibility':'visible'});
                    $('#NewsAdmin_preview_source, #News_preview_source').val(data.previewname);
                    $('#CategoryAdmin_media_source').val(data.previewname);
                        $('#result').remove();
                    setTimeout(function(){
                        $('#loader').hide();
                        if($('#preview_src').attr('src') != '/uploads/preview/'){
                            $('#change_arrow').show();
                            $('.new').show();
                        }
                        $('.img_cont').append('<img id="result" src="/'+data.preview_fullpath+'" />')
                        //$('#result').attr('src','/uploads/preview/tmp/'+data);
                        $.magnificPopup.close();
                    },100);
                },'json'
            );
        });
        
        $('#reset_popup_crop').click(function(){
            $.magnificPopup.close();
        })
        
        $('#resetcrop').click(function(){
            $.post(
                '/news/tmpremove',
                {
                    'path' : $('#result').attr('src'),
                },
                function(data){
                    $('#result').attr('src','');
                    $('#resetcrop').hide();
                    $('#change_arrow').hide();
                    $('.new').hide();
                }
            );
        })
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
function translite(string){
    $.post('/news/translite',{ 'str' : string },function(data){
        window.imgname = data;
        setTimeout(function(){
            $('.jcrop-preview').attr('src','/uploads/preview/'+window.imgname);
            $('.jcrop-holder img').attr('src','/uploads/preview/'+window.imgname);
            $('#cropbox').attr('src','/uploads/preview/'+window.imgname);
        },1500)
    })
}