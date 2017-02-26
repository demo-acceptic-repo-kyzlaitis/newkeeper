<?php //var_dump(Yii::app()->session['cat_choice']);exit;

if (Yii::app()->user->isGuest) {
    //unset(Yii::app()->session['cat_choice']);
    if (!isset(Yii::app()->session['cat_choice'])) {
        Yii::app()->session['cat_choice'] = time();
    }
    if ((time() - Yii::app()->session['cat_choice']) < 30) {
        ?>
        <script>
            if(!isMobile.any) {

                setTimeout(function () {
                    if (!window.popup_opened) {
                        popup_funcs['category']();
                    }
                    else
                        window.queue.push('category');
                    /*
                     $.post('/'+lang+'/category/index',{"asDialog" : 1},function(html){
                     if($('#registration').attr('class') == 'active'){
                     $("#id_category").html(html);
                     $('#id_category').addClass('stop');
                     } else{
                     $("#id_category").html(html);
                     $('#id_category, #shadow').show();
                     }
                     }).done(function(){
                     $(".modal-body").addClass("mytape");
                     });*/
                }, 30000 -<?php print 1000*(time() - Yii::app()->session['cat_choice']); ?>);
            }
        </script>
    <?php
    }


    if (isset(Yii::app()->session['tw_verify'])) {
        ?>
        <script>
            if (!window.popup_opened) {
                popup_funcs['twitter']();
            }
            else
                window.queue.push('twitter');
        </script>
    <?php }
} else {
    //unset(Yii::app()->session['followus_time']);
    if (!isset(Yii::app()->session["followus_time"]) || (((time() - Yii::app()->session["followus_time"]) > 3600 * 24 * 7) && Yii::app()->session["follow_later"] == 1)) { ?>
        <script>
            if(!isMobile.any) {
                setTimeout(function () {
                    if (!window.popup_opened) {
                        popup_funcs['followus']();
                    }
                    else
                        window.queue.push('followus');
                }, 30000);
            }
        </script>
        <?php Yii::app()->session["followus_time"] = time();
    }

    //unset(Yii::app()->session['friends_time']);
    if (!isset(Yii::app()->session["friends_time"]) || (((time() - Yii::app()->session["friends_time"]) > 3600 * 24) && Yii::app()->session["friends_later"] == 1)) { ?>
        <script>
            //       setTimeout(function(){
            //           showPopup('friends');
            //           $.getScript("http://nk.applemint.net/js/send2friends.js");
            //           $('#friends, #shadow').show()
            // }, 5000);
        </script>
        <?php Yii::app()->session["friends_time"] = time();
    }
    /* такого поки немае
    //unset(Yii::app()->session['mobile_time']);
    if(!isset(Yii::app()->session["mobile_time"]) || (((time() - Yii::app()->session["mobile_time"]) > 3600*24) && Yii::app()->session["mobile_later"] == 1)){ ?>
        <script>
        setTimeout(function(){
            showPopup('mobile');
        }, 1000);
        </script>
        <?php Yii::app()->session["mobile_time"] = time();
    }*/
}
?>