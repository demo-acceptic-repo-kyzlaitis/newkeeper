<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
$.ajax({
      type: "POST",
      url:    "<? echo Yii::app()->createUrl('category/index'); ?>",
      //data:  {val1:1,val2:2},
      success: function(msg){
           alert("Sucess")
          },
      error: function(xhr){
      alert("failure"+xhr.readyState+this.url)

      }
    });
</script>