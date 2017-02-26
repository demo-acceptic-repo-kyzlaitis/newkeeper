<?php

$this->widget('zii.widgets.grid.CGridView',$listData);

?>
<script>
$(function(){
      initResizeCol()
      initSelectAllEvent()
      $('.delete').click(function() { return false; });
      $('.delete').click(function(){
        if(!$(this).parents('tr').hasClass('empty')){
          var flag = confirm('У данной категории есть новости. Нажмите ОК, чтобы присвоить их другой категории или Отмена, чтобы удалить их');
          if(flag){
              var class_arr = $(this).parents('tr').attr('class').split(' ');
              var id;
              $.each(class_arr, function(k,v){
                if(v.slice(0,2) == 'pk')
                    id = v.slice(2);
              });
              $.post('/category/getids',function(data){
                var opt_str = '';
                $.each(data,function(k,v){
                    opt_str += '<option value="'+k+'">'+v+'</option>';
                })
                $.colorbox({
                    html:'<div class="adm_pop"><div class="wrap">Переместить новости из категории '+data[id]+' в категорию: <select id="selcat">'+opt_str+'</select>'+
                    '<button id="ok_changecat">OK</button><div id="loading" style="display:none">Загрузка</div></div></div>',
                    top:"10%",
                    opacity: 0.5,
                    transition:"fade",
                    speed:100,
                    width:850,
                    //height: 800,
                    closeButton:false,
                    onComplete: function(){
                        $('#ok_changecat').attr('onclick','changeCat('+id+','+$('#selcat option').eq(0).val()+')');
                        $('#selcat').change(function(){
                            $('#ok_changecat').attr('onclick','changeCat('+id+','+$(this).val()+')');
                        })
                    },
                })
              },'json')
          }
        }else{
            var url = $(this).attr('href');
            var flag = confirm('Вы уверены, что хотите удалить данный элемент?');
            if(flag){
                $.post(url);
                $.fn.yiiGridView.update("objects-grid");
            }
        }
      })
});
</script>