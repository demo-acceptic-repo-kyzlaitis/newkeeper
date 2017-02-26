<?php

$instamood = Yii::app()->session['instagramApp'];
echo '<a href="' .  'https://api.instagram.com/oauth/authorize/?client_id=878485ccc2974b909703fb107dee7372&redirect_uri=http://newskeeper.ru/instagram?&response_type=code&scope=likes+comments+relationships' . '"> login<a/> ' ;

