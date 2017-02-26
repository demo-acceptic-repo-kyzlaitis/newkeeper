<?php
/**
 * FeedHelper helper class.
 *
 * $Id: arr.php 3769 2008-12-15 00:48:56Z zombor $
 *
 * @package    Core
 * @author     Art Gek
 * @copyright  (c) 2013
 */
Yii::import('ext.efeed.*');

class FeedHelper
{
    public static function getFeed($network)
    {
        // RSS 2.0 is the default type
        $feed = new EFeed();
        
        $model = new News;
        $fnews = $model->findAllByAttributes(array($network."_pub"=>1));
        
        $feed->title= 'News Keeper Feed';
        $feed->description = 'News Keeper Feed is used for auto-publishing news to social networks';
        
        $feed->setImage('News Keeper Feed','http://'.$_SERVER['HTTP_HOST'].'/rss',
        'http://'.$_SERVER['HTTP_HOST'].'/images/logo.png');
        
        $feed->addChannelTag('language', 'en-us');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', 'http://'.$_SERVER['HTTP_HOST'].'/rss' );
        
        // * self reference
        //$feed->addChannelTag('atom:link','http://nk.applemint.net/news/rss');
        foreach($fnews as $fn)
        {
            $item = $feed->createNewItem();
            
            $item->title = $fn->getTeaserOrTitle();
            $item->link = "http://".$_SERVER['HTTP_HOST']."/news/".$fn->id;
            $item->date = time();
			/*if($network == 'tw'){
				$tw_text = $fn->name;
				$tw_text = substr($tw_text,0,115);
				$item->description = $tw_text." "."http://".$_SERVER['HTTP_HOST']."/news/".$fn->id;
			}else{*/
				$item->description = $fn->getText();
			//}
            //$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');
            //$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
            //$item->addTag('guid', 'http://www.ramirezcobos.com/',array('isPermaLink'=>'true'));
            //CVarDumper::dump($fn->getTeaserOrTitle());
            $feed->addItem($item);
        }
        
        $feed->generateFeed();
    }
}