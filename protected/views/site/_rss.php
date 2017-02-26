<?php
header("Content-Type: application/xml; charset=utf-8");
?>
<?xml version="1.0" encoding="UTF-8" ?>
<rss  version="2.0">

    <channel>
        <title>Newskeeper</title>
        <link>newskeeper.ru</link>
        <description>news</description>

        <?php
        $HOST = "http://newskeeper.ru/";
        $HOST_NEWS = "news#news_";
        $IMAGE_PATH = $HOST . "news/sendshow?id=";

        foreach($news as $item) {
            $date=date("D, j M Y G:i:s", $item['create_time']). " GMT";

            echo '<item>';
//                echo '<title>' . html_entity_decode($item['teaser_ru'], ENT_COMPAT, 'utf-8') . '</title>';
//                echo '<link>' . html_entity_decode($HOST . $HOST_NEWS . $item['slug'], ENT_COMPAT, 'utf-8') . '</link>';
//                echo '<description>' . html_entity_decode($item['text_ru'], ENT_COMPAT, 'utf-8') . '</description>';
//                echo '<link>' . html_entity_decode($HOST . $HOST_NEWS . $item['slug'], ENT_COMPAT, 'utf-8') . '</link>';
//                echo '<description>' . html_entity_decode($item['text_ru'], ENT_COMPAT, 'utf-8') . '</description>';
                echo "<image url='$IMAGE_PATH$item[id]' type='image/*'  />";
//                echo '<pubDate>' . $date . '</pubDate>';
            echo '</item>';
        }
        ?>

    </channel>
</rss>