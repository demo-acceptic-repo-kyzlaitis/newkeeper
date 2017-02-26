<?php


Yii::import('application.extensions.yiinstagram.*');

/**
 * Class SocialNetworkController
 */
class SocialNetworkController extends Controller
{


    //TODO: add ctor

    public $instagram;
    public $session;

    public function actionInstagramLogin()
    {

        $this->instagram = Yii::app()->instagram->getInstagramApp();

        Yii::app()->session['instagramApp'] = $this->instagram;


        $this->renderPartial('instagramLogin');

        //$this->instagram->openAuthorizationUrl();
    }

    public function actionInstagram()
    {
        $this->instagram =  Yii::app()->session['instagramApp'] ;

        //TODO: optimize
        if (isset($_GET['code'])) {
            echo '<pre>';
            var_dump($this->instagram);
            echo '</pre>';
            $accessToken = Yii::app()->session['accessToken'] = $this->instagram->getAccessToken();

            $this->instagram->setAccessToken($accessToken);

            Yii::app()->session['instagramApp'] = $this->instagram;

            $user = $this->instagram->getCurrentUser();
        }

        $this->renderPartial('instragram');
    }


    public function actionSearchUsers()
    {
        $instagram = Yii::app()->session['instagramApp'];


        $instagramUserNames = $instagram->searchUser(Yii::app()->request->getQuery('instaName'));

        header('Content-type: application/json');

        echo json_encode($instagramUserNames);
    }

    public function actionStartFollowingUsers()
    {
        $instagram = Yii::app()->session['instagramApp'] ;
        $users = Yii::app()->request->getQuery('usersId');
        $users = json_decode($users);

        foreach ($users as $user) {
            //gets all users wich is follows for specified user
            $usersFollowedBy =  $instagram->getUserFollowedBy($user);

            //TODO implement pagination;

            shuffle($usersFollowedBy['data']);//shuffle array for pretending as if we are user

            $resutl = $instagram->modifyUserRelationship($usersFollowedBy['data'][2], 'follow');

            var_dump($resutl);
//            foreach ($usersFollowedBy['data'] as $userFollowedBy) {
//                $result =
//
//                var_dump($result);
////                $randSec = rand(120, 180); //get rand number from 120 for 180 sec
////
////                sleep($randSec);
//            }
        }

    }

    public function actionTest()
    {
        $instagram = Yii::app()->session['instagramApp'] ;
        $users = Yii::app()->request->getQuery('usersId');


        $users = json_decode($users);

        foreach ($users as $user) {
            $usersFollowedBy =  $instagram->getUserFollowedBy($user);

            shuffle($usersFollowedBy['data']);
            var_dump($usersFollowedBy['data']);
        }



    }

}