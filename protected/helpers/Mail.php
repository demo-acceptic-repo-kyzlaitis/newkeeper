<?php

class Mail {
    
    public static function send ($to, $subj, $body)
    {
        $message            = new YiiMailMessage;
        $message->view      = "mail";
        $params             = array('body' => $body);
        $message->subject   = $subj;
        $message->setBody($params, 'text/html');
        $message->addTo($to);
        $message->from = Yii::app()->params['adminEmail'];
        Yii::app()->mail->send($message);
    }
}