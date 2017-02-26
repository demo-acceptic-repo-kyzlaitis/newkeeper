//(function( $ ) {
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
if(iOS)
	$('html').addClass('ios');

var msie = window.navigator.userAgent.indexOf("MSIE ");

if (msie > 0)
    $('html').addClass('ie');

    $(function(){
	window.scrollPosition = 0;
	window.scrollingUp = 0;
	var interval = 600;
 if ($(document).scrollTop() >= "250")
 {
 	$("#ToTop").fadeIn("slow");
 }
 
 
 $(document).scroll(function(){
	  if ($(document).scrollTop() <= "250")
	  {
	  	$("#ToTop").fadeOut(interval);	
	  	window.scrollingUp = 0;
	  }
	  else{	
	  	if (!window.scrollingUp)
	  	{
	  		$("#OnBottom").fadeOut(interval);
	  		$("#ToTop").fadeIn(interval);
		}
	  		
	  }
 });

 $("#ToTop").click(function(){
 	window.scrollingUp = 1;
 	
 	window.scrollPosition = $(document).scrollTop();
 	$("html,body").animate({scrollTop:0},interval);

 	$("#ToTop").fadeOut("slow");
    $("#OnBottom").fadeIn("slow");
 });
 $("#OnBottom").click(function(){
 	
 	$("html,body").animate({
 		scrollTop: window.scrollPosition
 	},interval);
 	
 	window.scrollingUp = 1;
 	
 	$("#OnBottom").fadeOut("slow");
 });
});


window.popup_opened = false;
window.queue = [];
window.lang = curLanguage();

popup_funcs = {
    category: function() {
        if(!window.popup_opened)
        $.magnificPopup.open({
    	  items: {
    	      src: '/'+window.lang+'/category/index',
    	      type: 'ajax'
    	  },
    	  callbacks: {
    		  parseAjax: function(mfpResponse) {},
    		  ajaxContentAdded: function() {
		      	  openActionsAjax();
		      },
              beforeOpen: function() {
                  window.popup_opened = true;
              },
	          open: function() {
	          	  openActions();
	          },
              afterClose: function() {
                  window.popup_opened = false;
                  showFromQueue();
              }
    	  }
    	});
    },
    followus: function() {
        if(!window.popup_opened)
        $.magnificPopup.open({
    	  items: {
    	      src: '/'+window.lang+'/site/popup/followus',
    	      type: 'ajax'
    	  },
    	  callbacks: {
    		  parseAjax: function(mfpResponse) {},
    		  ajaxContentAdded: function() {
		      	openActionsAjax();
		      },
              beforeOpen: function() {
                  window.popup_opened = true
              },
	          open: function() {
	          	  openActions();
	          },
	          close: function() {
	          	  closeActions();
	          },
              afterClose: function() {
	              window.popup_opened = false;
	              showFromQueue();
              }
    		},
    	});
    },

    reg: function() {
        console.log("reg");
        
        if(!window.popup_opened)
        $.magnificPopup.open({
    	  items: {
    	      src: '/'+window.lang+'/user/registration',
    	      type: 'ajax'
    	  },
    	  callbacks: {
    		  parseAjax: function(mfpResponse) {},
    		  ajaxContentAdded: function() {
    		     $(".modal-body").addClass("followus");
                 $('.followus > p').text($('.login_registration ul.tabs li').eq(0).text());
                 $('.login_registration ul.tabs li').click(function(){
                     $(".reg_row input").each(function(){
                         if($(this).val().length == 0)
                             $(this).siblings('.disappear').show();
                     });
                     $('.error_msg').text('');
                     //$('.reg_text').show();
                     var ind = $(this).index();
                     $('.login_registration ul.tabs li').removeClass('current');
                     $(this).addClass('current');
                     $('.login_registration .box').removeClass('visible');
                     $('.login_registration .box').eq(ind).addClass('visible');
                     $('.followus > p').text($(this).text());
                 });

                 $("#login-form input, #registration-form input").on('input', function(){
                     setTimeout(function(){
                        $(".reg_row input").each(function(){
                           if($(this).val().length != 0)
                             $(this).siblings('.disappear').hide();
                        });
                     },1);
                 });

                 $(".check").click(function(){
                    if($(this).hasClass('active'))
                      $(this).removeClass('active');
                    else
                      $(this).addClass('active');
                 });
		          openActionsAjax();
                  console.log(location.hash)
                  if(location.hash == '#reg')
                  {
                      $('.tabs li').removeClass('current');
                      $('.tabs li').last().addClass('current');
                      $('.box').removeClass('visible');
                      $('.box').last().addClass('visible');
                  }
                  location.hash = '';
    		  },
              beforeOpen: function() {
                  window.popup_opened = true
              },
	          open: function() {
	          	  openActions();
	          },
	          close: function() {
	          	  closeActions();
	          },
              afterClose: function() {
                  window.popup_opened = false;
                  showFromQueue();
              }
    		}
    	});
    },
    twitter: function() {
        if(!window.popup_opened)
        $.magnificPopup.open({
    	  items: {
    	      src: '/'+window.lang+'/site/popup/twitter',
    	      type: 'ajax'
    	  },
    	  callbacks: {
    		  parseAjax: function(mfpResponse) {},
    		  ajaxContentAdded: function() {
		      	openActionsAjax();
    		  },
              beforeOpen: function() {
                  window.popup_opened = true
              },
	          open: function() {
	          	  openActions();
	          },
	          close: function() {
	          	  closeActions();
	          },
              afterClose: function() {
	              window.popup_opened = false;
	              showFromQueue();
              }
          }
    	});
    },
    /*news: function() {
        $.magnificPopup.open({
    	  items: {
    	      src: $(this).attr('href'),
    	      type: 'ajax'
    	  },
    	  callbacks: {
    		  parseAjax: function(mfpResponse) {},
    		  ajaxContentAdded: function() {
    		      $('.mfp-content div, .mfp-content img, .mfp-content p, .mfp-content a').addClass('mfp-prevent-close');
    		      $('.mfp-bg').addClass('shadow-news');
    		  },
              beforeOpen: function() {
                  window.popup_opened = true;
              },
              afterClose: function() {
                  window.popup_opened = false;
              }
          }
    	});
    },*/
    cropava: function() {
  		if(window.result.error == 1)
  		{
			alert(window.result.msg);
		}else{
			console.log(window.result)
			
			var imgname_full = window.result.tmp_full;
			
	        $.magnificPopup.open({
	    	  items: {
	    	      src: '/'+window.lang+'/site/popup/cropava',
	    	      type: 'ajax'
	    	  },
	    	  callbacks: {
	    		  //open: function(mfpResponse) {alert('mfpResponse')},
	    		  ajaxContentAdded: function() {
	    		        $('.crop_ok').css('display','block');
	                    $('#loader').hide();
	                    //window.imgname = data.originalFiles[0].name;
	                    $('.jcrop-preview').attr('src','/'+imgname_full);
	                    $('.jcrop-holder img').attr('src','/'+imgname_full);
	                    $('#cropbox').attr('src','/'+imgname_full);
	                    //$('#News_preview_source').val('thumb/'+window.imgname);
	                    var jcrop_api = false;
	                    if(jcrop_api)
	                        jcrop_api.destroy();
	                        
	                    $preview = $('#preview-pane'),
	                    $pcnt = $('#preview-pane .preview-container'),
	                    $pimg = $('#preview-pane .preview-container img'),
	                    
	                    xsize = $pcnt.width(),
	                    ysize = $pcnt.height();
	                                                                              
	                    $('#cropbox').Jcrop({
	                        onSelect: updateCoords,
	        		        //onChange: updatePreview,
	                        aspectRatio: 1,
	                        allowSelect: false,
	                        minSize: [100,100],
            				setSelect:   [ 100, 100, 50, 50 ]
	                    },function(){
	                        // Use the API to get the real image size
	                        var bounds = this.getBounds();
	                        boundx = bounds[0];
	                        boundy = bounds[1];
	                                                          
	                        jcrop_api = this;
	                        //$preview.appendTo(jcrop_api.ui.holder);    
	                        $('.jcrop-holder').addClass('mfp-prevent-close');
	                        $('.jcrop-holder *').addClass('mfp-prevent-close');
	                        
	                        preventCloseWhileDragSelected();
	                    });
	                    
	                    $('#cropped').show();
	                    $('.begin_upload').hide();
	                    $('.begin_upload').css('padding','10px 0');
	    		        $('.blog_pop').addClass('mfp-prevent-close');
	    		        $('.blog_pop *').addClass('mfp-prevent-close');
	                    
	                    $('#cropped_ava').click(function(){
	                        $.post(
	                            '/user/profile/crop',
	                            {
	                                'x':$('#x').val(),'y':$('#y').val(),'w':$('#w').val(),'h':$('#h').val(),
	                                'file_name' : window.imgname,
	                                'koef' : window.result.koef
	                            },
	                            function(data){
	                                $('#loader').show();
	                                $('#resetcrop').css('display','inline-block');
	                                $('#cropbox').attr('src','/'+window.result.tmp_full_thumb);
	                                $('.jcrop-holder').hide();
	                                $('#cropbox').css({'display':'block','height':'auto','width':'auto','visibility':'visible'});
	                                $('#News_preview_source').val(data.preview_thumbpath);
	                                    $('#result').remove();
	                                setTimeout(function(){
	                                    $('#loader').hide();
	                                    $('#change_arrow').show();
	                                    $('.img_cont').append('<img id="result" src="/'+window.result.tmp_full_tmp+'" />')
	                					$('.avatar_profile img').attr('src','/'+data.preview_fullpath);
	                					$('.side_ava').attr('src','/'+data.preview_fullpath);
	                                    $.magnificPopup.close();
	                                },100);
	                            },'json'
	                        );
	                    });
	                    
	                    $('#reset_popup_crop').click(function(){
	                        $.magnificPopup.close();
	                        $('#crop').hide();
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
	                            }
	                        );
	                    });
			      	  openActionsAjax();
	    		  },
	              beforeOpen: function() {
	                  window.popup_opened = true;
	              },
		          open: function() {
		          	  openActions();
		          },
		          close: function() {
		          	  closeActions();
		          },
	              afterClose: function() {
	                  window.popup_opened = false;
	              }
	          }
	    	});
    	}
    },
    cropblog: function() {
  		if(window.result.error == 1)
  		{
			alert(window.result.msg);
		}else{
			console.log(window.result)
			
			var imgname_full = window.result.tmp_full;
			
	        $.magnificPopup.open({
	    	  items: {
	    	      src: '/'+window.lang+'/site/popup/cropava',
	    	      type: 'ajax'
	    	  },
	    	  callbacks: {
	    		  ajaxContentAdded: function() {    		      
	    		        $('.crop_ok').show();
	                    $('#loader').hide();
	                    $('.jcrop-preview').attr('src','/'+imgname_full);
	                    $('.jcrop-holder img').attr('src','/'+imgname_full);
	                    $('#cropbox').attr('src','/'+imgname_full);
	                    //$('#News_preview_source').val('thumb/'+window.imgname);
	                    window.jcrop_api = false;
	                    if(window.jcrop_api)
	                        window.jcrop_api.destroy();
	                        
	                    $preview = $('#preview-pane'),
	                    $pcnt = $('#preview-pane .preview-container'),
	                    $pimg = $('#preview-pane .preview-container img'),
	                    
	                    xsize = $pcnt.width(),
	                    ysize = $pcnt.height();
	                                                                              
	                    $('#cropbox').Jcrop({
	                        onSelect: updateCoords,
	        		        //onChange: updatePreview,
	                        aspectRatio: 1,
	                        allowSelect: false,
	                        minSize: [350,350],
            				setSelect:   [ 350, 350, 50, 50 ]
	                    },function(){
	                        // Use the API to get the real image size
	                        var bounds = this.getBounds();
	                        window.boundx = bounds[0];
	                        window.boundy = bounds[1];
	                                                          
	                        window.jcrop_api = this;
	                        //$preview.appendTo(window.jcrop_api.ui.holder); 
	                        $('.jcrop-holder').addClass('mfp-prevent-close');
	                        $('.jcrop-holder *').addClass('mfp-prevent-close');
	                        
	                        preventCloseWhileDragSelected();
	                    });
	                    
	                    $('#cropped').show();
	                    $('.begin_upload').hide();
	                    $('.begin_upload').css('padding','10px 0');
	    		        $('.blog_pop').addClass('mfp-prevent-close');
	    		        $('.blog_pop *').addClass('mfp-prevent-close');
	                    
	                    $('#cropped_ava').click(function(){
	                        $.post(
	                            '/news/crop',
	                            {
	                                'x':$('#x').val(),'y':$('#y').val(),'w':$('#w').val(),'h':$('#h').val(),
	                                'file_name' : window.imgname,
	                                'koef' : window.result.koef
	                            },
	                            function(data){
	                                $('#loader').show();
	                                $('#resetcrop').css('display','inline-block');
	                                $('#cropbox').attr('src','/'+window.result.tmp_full_thumb);
	                                $('.jcrop-holder').hide();
	                                //$('#cropbox').css({'display':'block','height':'auto','width':'auto','visibility':'visible'});
	                                $('#NewsAdmin_preview_source, #News_preview_source').val(data.previewname);
	                                $('#CategoryAdmin_media_source').val(data.previewname);
	                                    $('#result').remove();
	                                setTimeout(function(){
	                                    $('#loader').hide();
	                                    if($('#preview_src').attr('src') != '/uploads/preview/'){
	                                        $('#change_arrow').show();
	                                        $('.new').show();
	                                    }
	                                    $('.img_cont').append('<img id="result" src="'+data.preview_fullpath+'" />')
	                                    $('#result').attr('src','/'+data.preview_fullpath);
	                                    $.magnificPopup.close();
	                                },100);
	                            },'json'
	                        );
	                    });
	                    
	                    $('#reset_popup_crop').click(function(){
	                        $.magnificPopup.close();
	                        //$('#crop').html(window.crop_html);
	                        initUploadAndCropBlog()
	                    });
	                    
	                    $('#resetcrop').click(function(){
	                        $('#crop').html(window.crop_html);
	                        initUploadAndCropBlog()
	                        $.post(
	                            '/news/tmpremove',
	                            {
	                                'path' : $('#result').attr('src'),
	                            },
	                            function(data){
	                                $('#result').attr('src','');
	                                $('#resetcrop').hide();
	                                $('#change_arrow').hide();
	                            }
	                        );
	                    })
			      	openActionsAjax();
	    		  },
	              beforeOpen: function() {
	                  window.popup_opened = true;
	              },
		          open: function() {
		          	  openActions();
		          },
		          close: function() {
		          	  closeActions();
		          },
	              afterClose: function() {
	                  window.popup_opened = false;
	              }
	          }
	    	});
    	}
    }
};

function regAfterCat()
{
	window.popup_opened = false;
    loggedAction()//popup_funcs['reg']();
}
function readNews(slug, lang, id)
{
    if (!lang)
        lang = $('html').attr('lang');
    $.magnificPopup.open({
	  items: {
	      src: '/'+lang+'/news/view/'+slug,
	      type: 'ajax'
	  },
	  callbacks: {
		  parseAjax: function(mfpResponse) {},
		  ajaxContentAdded: function() {
		      $('.mfp-content *:not(.mfp-close)').addClass('mfp-prevent-close');
			  $('.inner-article > *').removeAttr('style');
		      openActionsAjax();
		  },
          beforeOpen: function() {
              window.popup_opened = true;
          },
          open: function() {
          	  openActions();
		      $('.mfp-bg').addClass('shadow-news');
              $('.mfp-close').hide();
		      location.hash = slug;
		      //window.scrollTop = $(document).scrollTop();
          },
          close: function() {
          	  closeActions();
              removeHash();
          },
          afterClose: function() {
              window.popup_opened = false;
              showFromQueue();
		      //$("html,body").scrollTop(window.scrollTop);

              //initAfterNewsLoad();

              //$('#news'+id+' .inner').width($('#news'+id+' .inner').width() - 100);
              setTimeout(function(){
                //$('#news'+id+' .inner').width($('#news'+id+' .inner').width() + 100);
                  //$('#news'+id+' .inner').removeAttr('style');
              },10);
			  /*console.log($('.inner ').css('position'))
			  //alert('afterclosed',$('.image_news').css('position'))
			  $('.shadow_and_news_icon').hide()
			  setTimeout(function(){
				  $('.inner ').css('position','relative');
				  $('.image_news').addClass('hovered');
				  console.log($('.inner').css('position'))
			  },10);
			  //alert('afterclosed2',$('.image_news').css('position'))
			  setTimeout(function(){
				  $('.inner ').css('position','absolute');
				  $('.image_news').removeClass('hovered');
				  console.log($('.inner ').css('position'))
				  $('.shadow_and_news_icon').show()
                  initAfterNewsLoad();
                  $('.image_news').addClass('loaded');
			  },50);*/
          }
      }
	});
}
function openActionsAjax()
{
	
	openActions();
}
function openActions()
{
	$('.scroll_fix').addClass('popupped');
	//if (hasVerticalScroll()) {
		scrollFixWidth();
    //}
	//if ($(document).height() > $(window).height()) {
	//}
}
function closeActions()
{
	$('.scroll_fix').removeClass('popupped');
}

function initHovered()
{
    $('.image_news').off();

	if( isMobile.any() )
	{
		$('.image_news').on('click',function(){

			if($(this).hasClass('hovered'))
				$(this).removeClass('hovered');
			else
				$(this).addClass('hovered');
		});
	}else{
		$('.image_news').on('mouseover', function(){
			$(this).addClass('hovered');
		});

		$('.image_news').on('mouseleave', function(){
			$(this).removeClass('hovered');
		});
	}
	
//	if(iOS)
	/*$('.image_news').tap(function(){
		$(this).removeClass('hovered');
	});*/
}

$(document).ready(function()
{
    if (Modernizr.touch) {
        $(".radio-options").bind("click", function(event) {
            if (!($(this).parent('.radio-container').hasClass("active")))   {
                $(this).parent('.radio-container').addClass("active");
                event.stopPropagation();
            }
        });
        $(".toggle").bind("click", function(){
            $(this).parents('.radio-container').removeClass("active");
            return false;
        });
    }


    setTimeout(function(){
        $('.main-menu').css('overflow','visible');
        $('.main-menu').css('height','auto');
        $('.main-menu').css('margin','0');
        
        $('#mainNavbar').flexMenu();
    },1000);

    switch(location.hash){
        case '#login': loggedAction();
            break;
        case '#reg': loggedAction();
            break;
        default:
            if(location.hash.length > 5)
            {
                readNews(location.hash.slice(1));
            }
    }
	//$('.inner ').css('position','absolute');
/*    $(":input[placeholder]").placeholder({
        'class':'disappear'
    });*/
    
    $('.mob_search').click(function(){
        if(!$('.search_wrap').hasClass('showed'))
            $('.search_wrap').show().addClass('showed');
        else
            $('.search_wrap').hide().removeClass('showed');
    })
    
    $('.social.naver').click(function(){
        if(!$('.naver-container').hasClass('showed'))
            $('.naver-container').show().addClass('showed');
        else
            $('.naver-container').hide().removeClass('showed');
    })
//********************* ADM PANEL ********************

$('.adm_but.show').click(function(){
    $(this).hide()
    $('.notshow').show()
    $('.main').show()
})
$('.adm_but.notshow').click(function(){
    $(this).hide()
    $('.show').show()
    $('.main').hide()
})

//********************* END ADM PANEL ********************

//********************* CABINET ********************
    $(".catcheck div.check").click(function(){
        var id = $(this).attr("id");
        $.post("/category/subscribe/"+id);
        if(allChecked('catcheck'))
            $('.check.all_theme').addClass('active');
    });
    $(".blogcheck div.check").click(function(){
        var id = $(this).attr("id");
        $.post("/bloger/subscribe/"+id);
        if(allChecked('blogcheck')){
            $('.check.all_blog').addClass('active');
        }
    });
    $(".subscription .checkboxes div.check").click(function(){
        loggedAction('subscribeBlog', $(this));
    });
    
    if(allChecked('catcheck')){
        $('.check.all_theme').addClass('active');
    }
    
    if(allChecked('blogcheck')){
        $('.check.all_blog').addClass('active');
    }
    
    $(".all_theme").click(function(){
        if(!allChecked('catcheck')){
            $(this).parent().find('.check').addClass('active');
            $(".catcheck div.check").each(function(){
                if(!$(this).hasClass("active")){
                    var id = $(this).attr("id");
                    $.post("/category/subscribe/"+id);
                }
            });
            $(".catcheck div.check").addClass("active");
            $(".catcheck div.check input").attr("checked","checked");
        }else{
            $(this).parent().find('.check').removeClass('active');
            $(".catcheck div.check").each(function(){
                var id = $(this).attr("id");
                $.post("/category/subscribe/"+id);
            });
            $(".catcheck div.check").removeClass("active");
            $(".catcheck div.check input").removeAttr("checked");
        }
    });
    $(".all_blog").click(function(){
        if(!allChecked('blogcheck')){
            $(this).parent().find('.check').addClass('active');
            $(".blogcheck div.check").each(function(){
                if(!$(this).hasClass("active")){
                    var id = $(this).attr("id");
                    $.post("/bloger/subscribe/"+id);
                }
            });
            $(".blogcheck div.check").addClass("active");
            $(".blogcheck div.check input").attr("checked","checked");
        }else{
            $(this).parent().find('.check').removeClass('active');
            $(".blogcheck div.check").each(function(){
                var id = $(this).attr("id");
                $.post("/bloger/subscribe/"+id);
            });
            $(".blogcheck div.check").removeClass("active");
            $(".blogcheck div.check input").removeAttr("checked");
        }
    });
    
    var path = window.location.pathname.split("/");
    if(path[1] == 'news' && path[2] == 'blog')
        $(".profile_information .three_info").addClass("active");
		
    if(path[1] == 'news' && path[2] == 'blog')
        $(".different_indormation .three_info").addClass("active");
        
    //******************** AVATAR NAME **************
    // if($('.cabinet_avatar span').length > 0){
    //     while($('.cabinet_avatar span').width() >= $('.cabinet_avatar p').width() && $('.cabinet_avatar span').css('font-size').substr(0,2)>8)
    //     {
    //         var font = $('.cabinet_avatar span').css('font-size');
    //         $('.cabinet_avatar span').css('font-size',font.substr(0,2)-1)
    //     }
    //     if($('.cabinet_avatar span').width() >= $('.cabinet_avatar').width())
    //         var font = $('.cabinet_avatar span').css('font-size');
    //     $('.cabinet_avatar span').css('font-size',font.substr(0,2)-1)
    // }



//********************* END CABINET ********************

//********************* BLOGERS ********************
    $(".blogger_blocks li").click(function(){
        $(".blogger_blocks li").removeClass("selected");
        $(this).addClass("selected");
        var id = $(this).attr("id");
        var path = window.location.pathname;
        var pathar = path.split("/");
        var lang = pathar[1];
        $.post("/bloger/blogerdesc/"+id, { 'lang' : lang }, function(html){
            $(".curvedContainer .description_blogger").html(html);
        });
    });
//********************* END BLOGERS ********************

//********************* CURRENCY ********************
    initCurr('side');
    initCurr('wiget-panel-top');

function initCurr(divobj)
{
    $("."+divobj+" .currency li").hide();
    $("."+divobj+" .currency li .active").parent().show();

    $("."+divobj+" .info2 a.arrow_down").click(function() {
        console.log('donw');
        var ind = $("."+divobj+" .currency li .active").parent().index();
        if($("."+divobj+" .currency li").length != ind+1){
            $("."+divobj+" .currency li a").removeClass("active").parent().hide();
            $("."+divobj+" .currency li").eq(ind+1).find('a').addClass("active");
            $("."+divobj+" .currency li .active").parent().show();
        }else{
            $("."+divobj+" .currency li a").removeClass("active").parent().hide();
            $("."+divobj+" .currency li").eq(0).find('a').addClass("active");
            $("."+divobj+" .currency li .active").parent().show();
        }
        var id = $("."+divobj+" .currency li .active").attr('id').slice(2);
        $.post('/widgetcurrencyelement/getcourse/', {'id':id}, function(html){
            currency(html);
        },'json');
    });

    $("."+divobj+" .info2 a.arrow_up").click(function() {
        var ind = $("."+divobj+" .currency li .active").parent().index();
        //alert($("ol.currency li").length)
        //alert(ind)
        console.log('up');
        if(ind != 0){
            $("."+divobj+" .currency li a").removeClass("active").parent().hide();
            $("."+divobj+" .currency li").eq(ind-1).find('a').addClass("active");
            $("."+divobj+" .currency li .active").parent().show();
        }else{
            $("."+divobj+" .currency li a").removeClass("active").parent().hide();
            $("."+divobj+" .currency li").eq($("."+divobj+" .currency li").length-1).find('a').addClass("active");
            $("."+divobj+" .currency li .active").parent().show();
        }
        var id = $("."+divobj+" .currency li .active").attr('id').slice(2);

        $.post('/widgetcurrencyelement/getcourse/',{'id':id},function(html){
            currency(html);
        },'json');
    });
}

    function currency(html)
    {
        $(".money.sale").html(html[0])
        $(".money.buy").html(html[1])
        $(".currency_main").html(html[0])
    }
//********************* END CURRENCY ********************

//********************* LANGS ********************
	$(".languages li a").click(function(){
		$(".languages li a").removeClass("active");
		$(this).addClass("active");
	});
//********************* END LANGS ********************

//********************* WEATHER ********************

    //Does not work
	$("#slider1 li a").click(function(){
		$("#slider1 li a").removeClass("active");
		$(this).addClass("active");
	});

    //Does not work
    $("#slider2 li a").click(function(){
        $("#slider1 li a").removeClass("active");
        $(this).addClass("active");
    });


    $("#overview-3 li a").click(function() {

        $("#overview-3 li a").removeClass("active");
        $(this).addClass("active")

        var cityName = $(this).text();

        //Get weather from database and put inside
        $.ajax({
            url: "/city/getweatherbycitymame",
            type: "get",
            data: { city: cityName },
            dataType: "json",
            success: function(data) {
                console.log(data.temperature);
                var temperatureString = data.temperature.split("&")[0] + "°";
                $("#temperature").text(temperatureString);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.error, ajaxOptions.error, thrownError.error);
            }
        });
    });
$(document).ready(function () {
    $(function () {
        $('.jcarousel').jcarousel();
    });

    $("#jcarousel-prev-3").click(function() {
        $('.jcarousel').jcarousel('scroll', '-=1');
    });

    $("#jcarousel-next-3").click(function() {
        $('.jcarousel').jcarousel('scroll', '+=1');
    });
});




//********************* END WEATHER ****************
//********************* TRAFFIC ********************
	$(".three_info li a").click(function() {
		$(".three_info li a").removeClass("active");
		$(this).addClass("active");
	});
//********************* END TRAFFIC ********************

//********************* CABINET SIDEBAR ********************
	// $("#cabinet .user-panel li").click(function(){
	// 	$("#cabinet li").removeClass("active");
	// 	$(this).addClass("active");
	// });
 //        $("#cabinet .user-panel li a").each(function(){
 //            if(window.location.pathname == $(this).attr('href')){
 //                $(this).parent().addClass('active');
 //            }
 //        });
    
//********************* END CABINET ********************

//********************* REGISTER POPUP ********************

$("#registration-form .reg_ok_close").click(function () {
    var uname = $(this).parents("#registration-form").find("input#UserLogin_username").val();
    var pass = $(this).parents("#registration-form").find("input#UserLogin_password").val();
    var vpass = $(this).parents("#registration-form").find("input#UserLogin_verifyPassword").val();
    var email = $(this).parents("#registration-form").find("input#UserLogin_email").val();
    $.post('/user/registration',{ 'RegistrationForm' : {'username' : uname, 'password' : pass, 'verifyPassword' : vpass, 'email' : email}},function(resp){
        if(resp[0] == 0) {
            $('.error_msg').text(resp[1]);
        } else {
            window.location = resp[1];
        }
    },'json');
});
//********************* REGISTER POPUP END ********************

//********************* NEWS FORM ********************
/*if($('#News_type_id').val() == 1){
        $('#News_media_source.text').removeAttr('disabled');
        $('.source').hide();
        $('.source').siblings('.preview').hide();
    }else{
        $('#News_media_source.text').attr('disabled','').hide();
        $('.source').show();
        $('.source').siblings('.preview').show();
    }
$('#News_type_id').change(function(){
    if($(this).val() == 1){
        $('#News_media_source.text').removeAttr('disabled').show();
        $('.source').hide();
        $('.source').siblings('.preview').hide();
    }else{
        $('#News_media_source.text').attr('disabled','').hide();
        $('.source').show();
        $('.source').siblings('.preview').show();
    }

});*/
$('.cleditorMain iframe').css('color','#fff');
//********************* END NEWS FORM ********************

$('.social_news a').click(function(){
    var news_id = $(this).parents('.activity_news').data('id');
	   $.post('/news/sharecount/'+news_id,function(resp){
            $('.activity_news#'+news_id).find(".news_stat span.share_stat").html(resp);
        });
});
/*
$(".image_news").hover(function(){
    $(".shadow_and_news_icon",this).stop(true,true).fadeIn(100);
    //$(".description_news",this).stop(true,true).fadeOut(100);
    //$(".shadow_and_news_icon",this).css("border-left","1px solid #333333");
    window.block = $(this);
    $(".news_bookmark",this).fadeOut(100);
},
function(){
    $(".news_bookmark",this).fadeIn(100);
    $(".shadow_and_news_icon",this).stop(true,true).fadeOut(100);
    //$(".description_news",this).stop(true,true).fadeIn(100);
    $(this).removeAttr("style");
});*/

//********************* ADMIN ********************

$(".search-button").click(function(){
    if ( $(".search-form").is(":visible") ) {
        //$(".widget").css("margin-top","0");
    } else { 
        //$(".widget").eq(1).css("margin-top","425px");
    }
});

//********************* END ADMIN ********************
$("#login-form .reg_row ".selector).click(function(){
    alert($("#login-form .reg_row ".selector).text())
});



var selector = '#UserLogin_username';
$(selector).parent("#login-form .reg_row").find(".disappear").click(function(){
    
    if($("#login-form .reg_row input"+selector).text().length == 0)
        $("#login-form .reg_row input"+selector).siblings(".disappear").show();
});

$('.different_indormation > li > a').on('click', function() {
    loggedAction($(this).attr('href'), false, true);
    return false;
});


centerPopup();
scrollFixWidth();
//adjustFontsize();
headerOnDocumentReady();
cabinetPosition();

$('.description_news').attr('data-loaded', 1);

	initHovered();
	
	//$('body').append('<div class="showheight">'+$(window).height()+'</div>');
    //checkLogged();
}); // end ready

$(window).resize(function(){
	centerPopup();
	heightBlock();
    cabinetPositionResize();
    heightBlockResize();
	//$('.showheight').text($(window).innerHeight());
});

function onBodyResize()
{
	scrollFixWidth();
}
function cabinetPosition()
{
    $('#cabinet_wrapper').css({
        'left' : $('#content').offset().left
    });
}
function cabinetPositionResize()
{
    var done = false;
    var content_left = $('#content').offset().left;

    var intervalID = setInterval(function(){

        if(!done && $('#content').offset().left != content_left)
        {
            cabinetPosition();
            done = true;
            clearInterval(intervalID);
        }
    },100);

    setTimeout(function(){
        clearInterval(intervalID);
    },2000);
}
function heightBlock(fornew)
{
    var widthBlock = $('.image_news').width();
    //$('.image_news').height(widthBlock);

    /*$('.image_news .inner').height(function(){
        if($(this).parents('.you_news').length)
        {
            return widthBlock - 6;
        }else{
            return widthBlock;
        }

    });*/
    adjustFontsize(fornew);
}
function heightBlockResize()
{
    var done = false;
    var widthBlock = $('.image_news').css('width');

    var intervalID = setInterval(function(){

        if(!done && $('.image_news').css('width') != widthBlock)
        {
            widthBlock = $('.image_news').width();
            //$('.image_news').height(widthBlock);
            /*$('.image_news .inner').height(function(){
                return widthBlock - 6;
            });*/
            done = true;
            clearInterval(intervalID);
        }
    },100);

    setTimeout(function(){
        clearInterval(intervalID);
    },2000);
}

function adjustFontsizeElem(elem)
{
    var fsize = parseInt(elem.find('.title').css('font-size'));
    var parentH = elem.parents('.image_news').height();
    var elemH = elem.height();
    console.log(fsize, elemH, parentH);
    if(elemH >= parentH && parentH != 0)
    {
        elem.find('.title').css({
            //'font-size' : --fsize+'px'
        });
        //adjustFontsizeElem(elem);
        //$(this).addClass('fontsize-adjusted');
    }else{
        var zazor = parentH - elemH;
        if(zazor > 100)
        {
            //$(this).find('.title').css({
            //	'font-size' : ++fsize+'px'
            //});
            elem.find('.title').removeAttr('style');
            //$(this).removeClass('fontsize-adjusted');
        }
    }
}
function adjustFontsize(fornew)
{
    if(fornew)
        $('.description_news').each(function(){
            if(!$(this).data('loaded'))
            {
                adjustFontsizeElem($(this));
                adjustAvasizeElem($(this));
                $(this).attr('data-loaded', 1);
            }
        });
    else
        $('.description_news').each(function(){
            adjustFontsizeElem($(this));
            adjustAvasizeElem($(this));
        });
}
function adjustAvasizeElem(elem)
{
    var elemW = elem.width();
    if(elemW <= 200)
    {
        elem.addClass('mini_ava');
    }else{
        elem.removeClass('mini_ava');
    }
}
function headerOnDocumentReady()
{
    $('.logo').show();
    $('.header nav').css({
       // 'position' : 'static'
    });
    //$('.header:after').css('left','0');
}
function scrollFixWidth()
{
	var minusWidth = 17;
	if(hasVerticalScroll() && !$('.scroll_fix').hasClass('popupped'))
    {
        minusWidth = 0;
        scrollWidth = 0;
    }

    var resultWidth = $(window).width() - minusWidth;

	$('.scroll_fix, .header, .footer, #cabinet_wrapper').width(function(){
		return resultWidth;
	});

    /*if($(window).width() < 1055)
    {
        $('#cabinet').css({
            'right' : resultWidth / 2 ,
            'margin-right' : - (resultWidth / 2 - 20)
        });
    }*/
}

function hasVerticalScroll()
{
	var out = false;
	
	if(typeof $('#content').offset() != 'undefined')
	{
	    if($('#content').outerHeight() + $('#content').offset().top + 134 > $(window).innerHeight())
	    	out = true;
	}
    	
    return out;
}

function centerPopup()
{
	var elem = $('.mfp-content');
	var marginTop = parseInt(elem.css('margin-top'));//console.log(elem.outerHeight(), $(window).height(), marginTop)
	if(elem.outerHeight() != 0 && elem.outerHeight() < $(window).height())
    elem.css({
      top: ($(window).height() - elem.outerHeight()) / 2 - marginTop + 'px'
    })
}

function disappear(selector)
{
    //setTimeout($(".reg_row input"+selector).focus(),1);
    $(".reg_row input"+selector).parent().find(".disappear").hide();
}
function appear(selector)
{
    //alert($(selector).text())
    if($("#login-form .reg_row input"+selector).text().length == 0)
      $("#login-form .reg_row input"+selector).siblings(".disappear").show();
}

function font(sign)
{
    $.post('/user/user/font/sign/'+sign,function(resp){
        $('.inner-article *').css('font-size',resp+'px');
    });
}

function recoverPopup()
{
    /*var lang = curLanguage();
    $.post('/'+lang+'/user/recovery',function(html){
            $(".mfp-content").html(html);
        });*/
    $('.login_registration_tab').hide();
    $('.recovery_tab').show();
}

function recoverBack()
{
    $('.login_registration_tab').show();
    $('.recovery_tab').hide();
}

function checkLogged(callback, arg)
{
    var logged = 0;
    $.post('/user/user/checklogged',function(data){
        logged = parseInt(data);
        $('html').attr('logged',logged);
        if(logged)
            $('.reg_hide').hide();
    }).done(function(){
		callback()
		//loggedAction(callback, arg)
	});
}

function loggedAction(_func, arg, link)
{
    var callback = function(){
        if(!parseInt($('html').attr('logged'))){
            popup_funcs['reg']();
        }
        else{console.log('_func'+_func)
            switch(_func)
            {
                case 'subscribeBlog':
                    subscribeBlog(arg);
                    break;
                case 'bkmrkNews':
                    bkmrkNews(arg);
                    break;
                case false:
                    break;
                default:
                    if(link)
                        window.location.href = _func;
                    else{
                        console.log('reload')
                        window.location.reload();
                    }
                    break;
            }
        }
    };

    checkLogged(callback);
}

function regPopup() {
    console.log("regPopup");
    
    var lang = curLanguage();
    if (!window.popup_opened) {
        $.magnificPopup.open({
            items: {
                src: '/' + lang + '/user/registration',
                type: 'ajax'
            },
            callbacks: {
                parseAjax: function (mfpResponse) {
                },

                ajaxContentAdded: function () {
                    $(".modal-body").addClass("followus");
                    $('.followus > p').text($('.login_registration ul.tabs li').eq(0).text());
                    $('.login_registration ul.tabs li').click(function () {
                        $(".reg_row input").each(function () {
                            if ($(this).val().length == 0)
                                $(this).siblings('.disappear').show();
                        });
                        $('.error_msg').text('');
                        //$('.reg_text').show();
                        $('.login_registration ul.tabs li').removeClass('current');
                        $(this).addClass('current');
                        $('.login_registration .box').removeClass('visible');
                        $('.login_registration .box form#' + $(this).attr('id')).parent().addClass('visible');
                        $('.followus > p').text($(this).text());
                    });
                    $("#login-form input, #registration-form input").on('input', function () {
                        setTimeout(function () {
                            $(".reg_row input").each(function () {
                                if ($(this).val().length != 0)
                                    $(this).siblings('.disappear').hide();
                            });
                        }, 1);
                    });
                    $(".check").click(function () {
                        if ($(this).hasClass('active'))
                            $(this).removeClass('active');
                        else
                            $(this).addClass('active');
                    });
                },
                beforeOpen: function () {
                    window.popup_opened = true
                },
                afterClose: function () {
                    window.popup_opened = false
                }
            }
        });
    }
}

function login_ok()
{
    var email = $('.login_ok_close').parents("#login-form").find("input#UserLogin_username").val();
    var pass  = $('.login_ok_close').parents("#login-form").find("input#UserLogin_password").val();
    var rem   = $('.login_ok_close').parents("#login-form").find("input#UserLogin_rememberMe").attr('checked');

    if(rem == 'checked')
        var rememberMe = 1;
    else
        var rememberMe = 0;

    var lang = curLanguage();

    $.post('/'+lang+'/user/login',{ 'UserLogin' : {'username' : email, 'password' : pass, 'rememberMe' : rememberMe}},function(resp){
        if(resp[0] == 0){
            $('.error_msg').text(resp[1]);
        } else {
            setTimeout(function(){
                window.location = resp;
            },300);
        }
    },'json');
}
function reg_ok()
{
    var name = $('.reg_ok_close').parents("#registration-form").find("input#UserLogin_username").val();
    var pass = $('.reg_ok_close').parents("#registration-form").find("input#UserLogin_password").val();
    var vpass = $('.reg_ok_close').parents("#registration-form").find("input#UserLogin_verifyPassword").val();
    var email = $('.reg_ok_close').parents("#registration-form").find("input#UserLogin_email").val();
    
    var lang = curLanguage();
    $.post('/'+lang+'/user/registration',{ 'RegistrationForm' : {'username' : name, 'password' : pass, 'verifyPassword' : vpass, 'email' : email }},function(resp){
        if(resp[0] == 0){
            $('.error_msg').text(resp[1]);
            //$('.reg_text').hide();
        }else{
            $('ul.tabs').hide();
            $(".login_registration .error_msg").css({'top':'180px'});
            popupSuccess(resp[1]);
        }
    },'json');
}
function recover_ok()
{
    var lang = curLanguage();
    var email = $('.login_ok_close').parents("#recover-form").find("input#UserRecoveryForm_login_or_email").attr('value');
    console.log(email)
    $.post('/'+lang+'/user/recovery',{ 'UserRecoveryForm' : {'login_or_email' : email}}, function(resp){
        //if(resp[0] == 0){
            $('.error_msg').text(resp[1]);
        //}else{
          //  $('.error_msg').text('');
            //popupSuccess(resp);
        //}
        recoverBack();
    },'json');
}
function popupSuccess(text)
{
    $(".login_registration .box").hide();
    $(".login_registration .error_msg").css({
    	'color':'#fff',
    	'top':'115px',
		'line-height': '30px',
		'position': 'relative'
    }).text(text);
    setTimeout(function(){
        //$.colorbox.close();
    },5000);
}
function showPopup(view)
{
    var lang = curLanguage();
    if(!window.popup_opened)
    $.magnificPopup.open({
	  items: {
	      src: '/'+lang+'/site/popup/'+view,
	      type: 'ajax'
	  },
	  callbacks: {
		  parseAjax: function(mfpResponse) {},
		  ajaxContentAdded: function() {}
		},
        beforeOpen: function() {
          window.popup_opened = true
        },
        afterClose: function() {
          window.popup_opened = false
        }
	});
    /*$.post('/'+lang+'/site/popup', {'view' : view }, function(html){
        $("#"+view).html(html);
    }).done(function(){
    });*/
}

function radioLater(name)
{
    $('.radio.never').removeClass('active');
    $('.radio.later').addClass('active');
    $('.followus_ok_close').attr('onclick','setLater(1,"'+name+'")');
}
function radioNever(name)
{
    $('.radio.later').removeClass('active');
    $('.radio.never').addClass('active');
    $('.followus_ok_close').attr('onclick','setLater(0,"'+name+'")');
}

function setLater(later, name)
{
    $.post('/site/later', { 'is_later' : later, 'name' : name },function(resp){
        $.magnificPopup.close();
    });
}

//news bookmarking
	function bookmark(html,news_id)
    {
	   var news_panel = $('.image_news#news'+news_id).find('.shadow_and_news_icon');
            if(html[0]){
                $('.image_news#news'+news_id+" .bookmark").addClass('greenbook');
                
                news_panel.parents('.image_news').prepend(html[0]);
                    news_panel.parents('.image_news').find('.news_bookmark').remove();
                    news_panel.parents('.image_news').addClass('activity_news').prepend(html[0]);
                    news_panel.siblings('div.unread_news').show();
                    news_panel.find(".news_stat span.bkmrk_stat").html(html[2]);
                    news_panel.siblings('.unread_msg').show();
                    setTimeout(function(){
                        news_panel.parents('.inner').fadeOut(100);
                        news_panel.siblings('.unread_msg').hide();
                    },2000);
                    setTimeout(function(){
                        news_panel.siblings('.preview').show();
                        news_panel.siblings('div.unread_news').hide();
                        news_panel.siblings('p.unread_msg').hide();
                        news_panel.parents('.inner').fadeIn(1);
                        news_panel.parents('.activity_news').removeClass('activity_news');
                    },2100);
            } else {
                $('.image_news#news'+news_id+" .bookmark").removeClass('greenbook');
                $('.image_news#news'+news_id+" .news_bookmark").hide();
                      
                    news_panel.siblings('.preview').hide();

                    news_panel.siblings('p.unread_msg').html(html[1]).show();
            }
    }
//downloaded
// commented window.open - 3 windows opened in safari
function downloaded(news_id)
    {

            var news_panel = $('.image_news#news' + news_id).find('.shadow_and_news_icon');

            news_panel.parents('.image_news').addClass('activity_news-1');

//						news_panel.parents('.inner').siblings('.downloaded').show();

            //news_panel.css('left','-9999px');
            //news_panel.siblings('.description_news').css('text-indent','-9999px');
//						news_panel.siblings('.preview').hide();

            setTimeout(function () {
//    						news_panel.parents('.inner').fadeOut(100);
//    						news_panel.css('left','0');
                //news_panel.siblings('.description_news').css('text-indent','0').show();
//    						news_panel.siblings('.preview').show();

                //news_panel.siblings('div.unread_news').hide();

                //news_panel.siblings('p.unread_msg').hide();

                //news_panel.parents('.inner').siblings('.downloaded').hide();

//    						news_panel.parents('.inner').fadeIn(1);

                //news_panel.parents('.activity_news').find('a.exit').remove();

//                            news_panel.parents('.inner').siblings('.downloaded').hide();

//    						news_panel.parents('.activity_news').removeClass('activity_news');

                news_panel.parents('.image_news').removeClass('activity_news-1');

            }, 3000);
    setTimeout(function() {
            //window.open('/'+window.lang+'/news/sendfile?id=' + news_id);
        }, 500);
    }
//sharing news
	function share(news_id)
    {
	   var news_panel = $('.image_news#news'+news_id).find('.shadow_and_news_icon');
                      news_panel.parents('.image_news').addClass('activity_news');
                      news_panel.parents('.inner').siblings('.social_news').show();
                      //news_panel.css('left','-9999px');
                      //news_panel.siblings('.description_news').css('text-indent','-9999px');
                      news_panel.siblings('.preview').hide();
                      news_panel.parents('.news-parent').append('<a class="exit" href="javascript:void(0)"></a>');
                      news_panel.parents('.news-parent').find('.exit').click(function(){
                           news_panel.parents('.inner').hide();
                          //news_panel.parents('.activity_news').find("div._share_fb").hide();
                          //news_panel.parents('.activity_news').find(".social_news > a").show();
                            news_panel.css('left','0');
                            //news_panel.siblings('.description_news').css('text-indent','0').show();
                            news_panel.siblings('.preview').show();
                            news_panel.siblings('div.unread_news').hide();
                            news_panel.siblings('p.unread_msg').hide();
                            news_panel.parents('.inner').siblings('.social_news').hide();
                            news_panel.parents('.inner').show(1);
                            news_panel.parents('.news-parent').find('a.exit').remove();
                            news_panel.parents('.activity_news').removeClass('activity_news');
                            news_panel.parents('.image_news').find('.social_news').children().removeAttr('style');
                      });
        }
function instshare(news_id)
{
    var news_panel = $('.image_news#news'+news_id);

    $('.social_news a, .share_text', news_panel).hide();
    $('.share_inst', news_panel).show();
}
function catSubcribe(id)
{
    $.post('/category/subscribe/'+id,function(resp){
        if(resp == 1) jQuery('.csubscribe#'+id+' .mytape_ok').show();
        else jQuery('.csubscribe#'+id+' .mytape_ok').hide();
    });
}

function allChecked(div_class)
{
    if($("."+div_class+" div.check.active").length == $("."+div_class+" div.check").length)
        return true;
}

function goLocation(link)
{
    window.location = $(link).data('url');
}

function curLanguage()
{
    var lang = window.location.pathname.substr(1,2);
    if(lang != 'ru' && lang != 'en' && lang != 'ua')
        lang = 'ru';
        
    return lang;
}

function subscribeBlog(elem)
{
    var id = elem.attr("id");
    $.post("/bloger/subscribe/"+id);
}
function bkmrkNews(id)
{
    $.post('/news/bookmark/'+id,function(data){
        bookmark(data,id);
    },'json');
}

function initDownload()
{
	$(".download").each(function(){
	    if(!$(this).hasClass('inited'))
        {
    	    $(this).click(function(){
            	dataString = $(this).parents('.image_news').attr("id");
            	window.open('/news/sendfile?id='+dataString);
        	});
            
            $(this).addClass('inited');
        }
	})
}
function showFromQueue()
{
    if(window.queue.length > 0)
        popup_funcs[window.queue.shift()]();
}

function initAfterNewsLoad()
{
    initDownload();
    initHovered();
	heightBlock(true);
}

function removeHash () {
    var scrollV, scrollH, loc = window.location;
    if ("pushState" in history)
        history.pushState("", document.title, loc.pathname + loc.search);
    else {
        // Prevent scrolling by storing the page's current scroll offset
        scrollV = document.body.scrollTop;
        scrollH = document.body.scrollLeft;

        loc.hash = "";

        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scrollV;
        document.body.scrollLeft = scrollH;
    }
}
//popup

$(document).ready(function () {
    
    //initDownload();
    
    $('.read_news').click(function(){/*
        $.magnificPopup.open({
    	  items: {
    	      src: $(this).data('href'),
    	      type: 'ajax'
    	  },
    	  callbacks: {
    		  parseAjax: function(mfpResponse) {},
    		  ajaxContentAdded: function() {
    		      $('.mfp-content *').addClass('mfp-prevent-close');
    		  },
              beforeOpen: function() {
                  window.popup_opened = true;
              },
              afterClose: function() {
                  window.popup_opened = false;
                  showFromQueue();
              }
          }
    	});
        
        return false;*/
    });
    /*$('.read_news').magnificPopup({
		type: 'ajax',
		//closeOnContentClick: false
	});*/

/*
    $('.pupua-news #btn-closes, #shadow-news').click(function(){
        $('.pupua-news, #shadow-news').hide(); 
        $('#id_view').html('');
        window.location.hash = '';
    });

    $('#id_category .btn-close, #id_category .btn-ok').on( "click", function() {
        $('#id_category, #shadow').hide();
    });

    $('#registration .btn-close, #registration .btn-ok').on( "click", function() {
            $('#registration, #shadow').hide();
            $('#registration').removeClass('active');
            if($('#id_category').attr('class') == 'stop'){
                $('#id_category, #shadow').show();
                $('#id_category').removeClass('stop');
            }
    });*/
                 
    $('.regPopup').on( "click", function() {
        if($(this).hasClass('reg'))
            location.hash = '#reg';

        loggedAction();

        if($('.regPopup').length < 2)
            return false;
    });
                 
    $('.termsPage').on( "click", function() {
        var lang = curLanguage();
        window.location = '/'+lang+'/site/terms';
    });

    $('.followus_ok_close').on( "click", function() {
		
        // розкоментувать для вивиода вікна faceboock
        // showPopup('friends');
        // $.getScript("http://"+window.location.hostname+"/js/send2friends.js");
        // $('#friends, #shadow').show();
    });
    
    // розкоментувать для вивиода вікна faceboock
    // $('#friends .btn-close, #friends .btn-recommendations a').on( "click", function() {
    //     $('#friends, #shadow').hide();
    // });*/

//#shadow

    function fixBody(){
        if ($('#shadow').css('display') == 'block'){
            $('body').css({
                'position': 'fixsed',
                'width' : '100%'
            });
        }        
    }
    function fixBodyOut(){
            $('body').removeAttr('style');
    }
/*
    $('#shadow').on( "click", function() {

        if ($('#id_category').css('display') == 'block'){
            $('#id_category, #shadow').hide();
        }

        if ($('#registration').css('display') == 'block'){
            $('#registration').removeClass('active');
            if($('#id_category').attr('class') == 'stop'){
                $('#registration').hide();
                $('#id_category').show();
                $('#id_category').removeClass('stop');
            } else {
                $('#registration, #shadow').hide();
            }
        }

        // розкоментувать для вивиода вікна faceboock
        // if ($('#friends').css('display') == 'block'){
        //     $('#friends, #shadow').hide();
        // }

        if ($('#followus').css('display') == 'block'){
            $('#followus').hide();

            // розкоментувать для вивиода вікна faceboock
            // showPopup('friends');
            // $.getScript("http://"+window.location.hostname+"/js/send2friends.js");
            // $('#friends').show();
        }

    });*/


    // search focus
    $('#faq_search_input').focus(function() {
    	//alert($(this).width(), $(this).height())
    	$('.search-block, .footer, .header, #top-border').addClass('focused');
        $('.about_footer_linck').addClass('hide');
        $('.popup-nk').css('margin-top','-9999px');
    });

    $('#faq_search_input').focusout(function(){
    	$('.search-block, .footer, .header, #top-border').removeClass('focused');
        $('.about_footer_linck').removeClass('hide');
        $('.popup-nk').css('margin-top','0');
    });


    $("button#subscribe").click(function() {
        console.log($("#subscribe-email").val());
        var email = $("#subscribe-email").val()
        $.post("/site/subscribe",
            {
                email: email
            },
            function(data, textStatus, jqSHR) {
                console.log(data);
            }
        );

    });

}); //end of $(document).ready()


//})( jQuery );