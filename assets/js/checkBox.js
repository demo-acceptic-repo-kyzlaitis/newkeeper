
$(document).ready(function(){
// Checkbox

	// ����������� ������� ����� �� ���� � ������� check
	$('.checkboxes').find('.check').click(function(){
		// ����� �������: ���� ��������� � ��� ������� �������
		if( $(this).find('input').is(':checked') ) {
			// �� ������� ���������� � ����
			$(this).removeClass('active');
			// � ������� ������� checked (������ ������� �� ����������)
			$(this).find('input').removeAttr('checked');
		
		// ���� �� ������� �� �������, ��
		} else {
			// ��������� ����� ���������� ����
			$(this).addClass('active');
			// ��������� ������� checked ��������
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
        // ����� ����
        //��� ����� �� ������ "�������� ���" ���������� ��������
        $("#example_all").click( function() {
           $("#" + $(this).attr('rel') + " .check:enabled").attr('checked', true);
            return false;
        });
 
        // ��� ����� �� ������ "�������� ���" ������� �������
        $("#example_noone").click( function() {
           $("#" + $(this).attr('rel') + " input:checkbox:enabled").attr('checked', false);
            return false;
        });
    });





