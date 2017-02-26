
$(function() {
  $('.popup1').hide(); // скрыли фон и всплывающее окно
  $('#hide-layout').css({opacity: .5}); // кроссбраузерная прозрачность
  alignCenter($('.popup1')); // центрировали окно
  $(window).resize(function() {
    alignCenter($('.popup1')); // центрирование при ресайзе окна
  })
  $('.click-me1').click(function() {
    $('#hide-layout, .popup1').fadeIn(300); // плавно открываем
  })
  $('.btn-close, #hide-layout').click(function() {
    $('#hide-layout, .popup1').fadeOut(300); // плавно скрываем
  })
  $('#btn-yes, #btn-no').click(function() {
    alert('Выполнили какое-то действие, затем скрываем окно...'); // сделали что-то...
    $('#hide-layout, .popup1').fadeOut(300); // скрыли
  })
  // функция центрирования
  function alignCenter(elem) {
    elem.css({
      //left: ($(window).width() - elem.width()) / 2 + 'px', // получаем координату центра по ширине
      top: ($(window).height() - elem.height()) / 2 + 'px' // получаем координату центра по высоте
    })
  }
})



$(function() {
  $('.popup2').hide(); // скрыли фон и всплывающее окно
  $('#hide-layout2').css({opacity: .5}); // кроссбраузерная прозрачность
  alignCenter($('.popup2')); // центрировали окно
  $(window).resize(function() {
    alignCenter($('.popup2')); // центрирование при ресайзе окна
  })
  $('.click-me1').click(function() {
    $('#hide-layout2, .popup2').fadeIn(300); // плавно открываем
  })
  $('.btn-close2, #hide-layout2').click(function() {
    $('#hide-layout2, .popup2').fadeOut(300); // плавно скрываем
  })
  $('#btn-yes, #btn-no').click(function() {
    alert('Выполнили какое-то действие, затем скрываем окно...'); // сделали что-то...
    $('#hide-layout2, .popup2').fadeOut(300); // скрыли
  })
  // функция центрирования
  function alignCenter(elem) {
    elem.css({
      left: ($(window).width() - elem.width()) / 2 + 'px', // получаем координату центра по ширине
     /*  top: ($(window).height() - elem.height()) / 2 + 'px' */ // получаем координату центра по высоте
    })
  }
})



