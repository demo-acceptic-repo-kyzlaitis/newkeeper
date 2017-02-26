
(function($) {
$(function() {

	$('ul.tabs').delegate('li:not(.current)', 'click', function() {
		$(this).addClass('current').siblings().removeClass('current')
			.parents('div.login_registration').find('div.box').hide().eq($(this).index()).fadeIn(150);
	})

})
})(jQuery)




$(function() {
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
      left: ($(window).width() - elem.width()) / 2 + 'px', // �������� ���������� ������ �� ������
      top: ($(window).height() - elem.height()) / 2 + 'px' // �������� ���������� ������ �� ������
    })
  }
})



$(function() {
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



