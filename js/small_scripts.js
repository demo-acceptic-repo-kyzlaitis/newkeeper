
//validation
$(document).ready(function(){
  $('#form_registration').bind('submit', function(event) {
    $('[type=text]').each(function() {
      if(!$(this).val().length) {	
	    event.preventDefault();
        $(this).css('boxShadow', 'inset 0 0 5px red');
      }
    });
  });
});

//litebox
$(document).ready(function(){
  $('.popup1').hide(); // ������ ��� � ����������� ����
  $('#hide-layout').css({opacity: .5}); // ��������������� ������������
  alignCenter($('.popup1')); // ������������ ����
  $(window).resize(function() {
    alignCenter($('.popup1')); // ������������� ��� ������� ����
  })
  $('.click-me1').click(function() {
    $('#hide-layout, .popup1').fadeIn(300); // ������ ���������
  })
  $('.btn-close, #hide-layout').click(function() {
    $('#hide-layout, .popup1').fadeOut(300); // ������ ��������
  })
  $('#btn-yes, #btn-no').click(function() {
    alert('��������� �����-�� ��������, ����� �������� ����...'); // ������� ���-��...
    $('#hide-layout, .popup1').fadeOut(300); // ������
  })
  // ������� �������������
  function alignCenter(elem) {
    elem.css({
      //left: ($(window).width() - elem.width()) / 2 + 'px', // �������� ���������� ������ �� ������
      top: ($(window).height() - elem.height()) / 2 + 'px' // �������� ���������� ������ �� ������
    })
  }
})

$(document).ready(function(){
  $('.popup2').hide(); // ������ ��� � ����������� ����
  $('#hide-layout2').css({opacity: .5}); // ��������������� ������������
  alignCenter($('.popup2')); // ������������ ����
  $(window).resize(function() {
    alignCenter($('.popup2')); // ������������� ��� ������� ����
  })
  $('.click-me1').click(function() {
    $('#hide-layout2, .popup2').fadeIn(300); // ������ ���������
  })
  $('.btn-close2, #hide-layout2').click(function() {
    $('#hide-layout2, .popup2').fadeOut(300); // ������ ��������
  })
  $('#btn-yes, #btn-no').click(function() {
    alert('��������� �����-�� ��������, ����� �������� ����...'); // ������� ���-��...
    $('#hide-layout2, .popup2').fadeOut(300); // ������
  })
  // ������� �������������
  function alignCenter(elem) {
    elem.css({
      left: ($(window).width() - elem.width()) / 2 + 'px', // �������� ���������� ������ �� ������
     /*  top: ($(window).height() - elem.height()) / 2 + 'px' */ // �������� ���������� ������ �� ������
    })
  }
})

//tab menu
$(document).ready(function(){
$(function() {

	$('ul.tabs').delegate('li:not(.current)', 'click', function() {
		$(this).addClass('current').siblings().removeClass('current')
			.parents('div.login_registration').find('div.box').hide().eq($(this).index()).fadeIn(150);
	})

})
})
//tab menu 2 for bloggers
$(document).ready(function() {

    $(".blogger_blocks li[id^=tab_menu]").click(function() {
        var curMenu=$(this);
        $(".blogger_blocks li[id^=tab_menu]").removeClass("selected");
        curMenu.addClass("selected");

        var index=curMenu.attr("id").split("tab_menu_")[1];
        $(".curvedContainer .tabcontent").css("display","none");
        $(".curvedContainer #tab_content_"+index).css("display","block");
    });
});

//fixed right menu
/* $(document).ready(function(){ 
	 var h_hght = 130; // ������ �����
	  var h_mrg = 100;     // ������ ����� ����� ��� �� �����
	  $(function(){
	   $(window).scroll(function(){
		  var top = $(this).scrollTop();
		  var elem = $('#cabinet');
		  if (top+h_mrg < h_hght) {
		   elem.css('top', (h_hght-top));
		  } else {
		   elem.css('top', h_mrg);
		  }
		});
	  });
}); */


//scroller in site
$(document).ready(function(){ 
	$(window).scroll(function () {if ($(this).scrollTop() > 0) {$('#scroller').fadeIn();} else {$('#scroller').fadeOut();}});
	$('#scroller').click(function () {$('body,html').animate({scrollTop: 0}, 400); return false;});
});

//hide image_news {
$(document).ready(function(){
	$('.hide1').hover(function() {
		//$('.add_news').hide();
	},
		function() { $('.add_news').show();
	});
});

//my type
$(document).ready(function() {
		$('.add_ok a span').click(function(){
			$(this).toggleClass('mytype_ok');
		});
});

