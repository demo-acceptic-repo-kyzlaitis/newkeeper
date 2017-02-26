
$(document).ready(function(){
// Checkbox

	// Отслеживаем событие клика по диву с классом check
	$('.checkboxes').find('.check').click(function(){
		// Пишем условие: если вложенный в див чекбокс отмечен
		if( $(this).find('input').is(':checked') ) {
			// то снимаем активность с дива
			$(this).removeClass('active');
			// и удаляем атрибут checked (делаем чекбокс не отмеченным)
			$(this).find('input').removeAttr('checked');
		
		// если же чекбокс не отмечен, то
		} else {
			// добавляем класс активности диву
			$(this).addClass('active');
			// добавляем атрибут checked чекбоксу
			$(this).find('input').attr('checked', true);
		}
		
	});
		
		
// RadioButton
	$('.recommendations_radioblock').find('.radio').click(function(){
		var valueRadio = $(this).html();
		$(this).parent().find('.radio').removeClass('active');
		$(this).addClass('active');
		$(this).parent().find('input').val(valueRadio);
	});
		
});

//all checkbox
    $(document).ready( function() {
        // Выбор всех
        //При клике по кнопке "отметить все" активируем чекбоксы
        $("#example_all").click( function() {
           $("#" + $(this).attr('rel') + " .check:enabled").attr('checked', true);
            return false;
        });
 
        // При клике по кнопке "сбросить все" убираем отметки
        $("#example_noone").click( function() {
           $("#" + $(this).attr('rel') + " input:checkbox:enabled").attr('checked', false);
            return false;
        });
    });





