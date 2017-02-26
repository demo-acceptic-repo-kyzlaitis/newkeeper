<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<?php //phpinfo();exit;?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru" logged="0">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, target-densityDpi=device-dpi"/>
    <meta name="language" content="en"/>
    <meta name="robots" content="noindex">

    <link rel="shortcut icon" href="/images/favicon.ico"/>

    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/virgo/cleditor/cleditor.css"/>
    <link href="/css/virgo/icons.css" rel="stylesheet" type="text/css"/>
    <link href="/css/virgo/mystyles.css" rel="stylesheet" type="text/css"/>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
    <!--[if lt IE 10]>
    <link href="css/ie.css" rel="stylesheet" type="text/css"/>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->


    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="css/ie8.css">
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.placeholder.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.Jcrop.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mynaver.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.mCustomScrollbar.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/magnific-popup.css"/>

    <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />-->

    <!--<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/style.less" />
	<link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/less/responsive.less" />-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/old-style.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/responsive.css"/>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!--<script src="/js/jquery.js" type="text/javascript"></script>-->
    <!--<script src="http://yui.yahooapis.com/3.8.0/build/yui/yui-min.js"></script>-->
    <script type="text/javascript">less = {env: 'development'};</script>
    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.7.3/less.min.js"></script>
    <script src="html2canvas.js"></script>-->


    <?php
    $baseUrl = Yii::app()->baseUrl;
    $js_arr = array(
        'download',
        'delete_photo',
        'flexmenu',
        'shares',
        'small_scripts',
        //'jquery.tinycarousel',
        'tabMenu',
        'tabs',
        'checkBox',
        'litebox',
        'male',
        'jquery-ui-1.10.3.custom',
        'jquery.placeholder.min',
        'jquery.jcarousel',
        //'admincrop',
        'admin_scripts',
        'plugins/cleditor/jquery.cleditor',
        'plugins/naver/jquery.fs.naver.min',
        'plugins/jcrop/jquery.Jcrop.min',
        'plugins/fileupload/jquery.fileupload',
        'plugins/mcustomscrollbar/jquery.mCustomScrollbar.concat.min',
        'search_engine',
        'modernizr',
        'jquery.magnific-popup.min',
        'funcs',
        'scripts',
        'less',
    );
    $cs = Yii::app()->getClientScript();
    foreach ($js_arr as $js) {
        $cs->registerScriptFile($baseUrl . '/js/' . $js . '.js');
    }
    ?>
    <?php foreach ($js_arr as $js) { ?>
        <!--<script src="<?= $baseUrl ?>/js/<?= $js ?>.js"></script>-->
    <?php } ?>

    <!--[if (IE 8)]>
    <script>
        $(document).ready(function () {
            $(".radio-options li").bind("click", function () {
                $(this).siblings(".checked").removeClass("checked");
                $(this).addClass("checked");
            });
        });
    </script>
    <![endif]-->

    <title><?php echo Yii::app()->name; ?> - <?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body onresize="onBodyResize()">
<div class="scroll_fix">
    <?php
    //var_dump(Yii::app()->settings->set('param', 'ips', '1111'));exit;

    //echo Aii::param('ips')?>
    <img src="http://nk.applemint.net/home.jpg" style="
        position: absolute;
        top: 1px;
        left: 50%;
        margin-left: -803px;
        z-index: 9999999;
        opacity: 0.5;
        display: none;
    ">

    <?php
    require_once('pop-ua.php') ?>

    <div id="top-border"></div>
    <header class="header">
        <div class="container">
            <?php //Yii::app()->language != 'ru' ? $url = Yii::app()->language : $url = '/'; echo CHtml::link('', Yii::app()->createUrl('/news'), array('class'=>'logo')); ?>
            <a href="<?php echo(Yii::app()->createUrl('/news')); ?>"><img
                    src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="newskeeper"
                    class="logo"/></a>

            <?php if ($this->layout == '//layouts/column2'): ?>
                <?php if (Yii::app()->user->isGuest): ?>
                    <a href="#" onclick="$('.regPopup').click();" class="cabinet">
                        Войти
                        <!--<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/menu-next.png" />-->
                    </a>
                <?php else: ?>
                    <a href="/news/bookmarks" class="cabinet">
                        Кабинет
                        <!--<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/menu-next.png" />-->
                    </a>
                <?php endif; ?>
            <?php elseif ($this->layout == '//layouts/column3'): ?>
                <?= (Yii::app()->user->id) ? CHtml::link(Yii::t("app", "Выйти"), '/user/logout', array('class' => 'cabinet logaut')) : "" ?>
            <?php endif; ?>



            <nav class="main-menu">
                <?php
                $this->widget('application.components.widgets.ActiveMenu');
                ?>
            </nav>

            <a href="<?php echo(Yii::app()->createUrl('/news')); ?>" class="logo-min">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/retina_mobile_logo.png" alt="newskeeper"/>
            </a>



            <?php if ($this->layout == '//layouts/column2'): ?> <!-- commenting out this line fixes widgets-->
<!--                <a> class="enter_cab" href="/news/bookmarks">Кабинет</a>-->
<!---->
<!--                <div class="wiget-panel-top">-->
<!--                    <ul class="different_indormation widget-panel">-->
<!--                        <li class="one_info">-->
<!--                            <div id="temperature_top" class="widget-info">-->
<!--                                --><?php //$this->widget('application.components.widgets.Temperature'); ?>
<!--                            </div>-->
<!--                            <span></span>-->
<!---->
<!--                            <ul id="slider1" class="info1 sliders">-->
<!--                                <a href="#" class="arrow_up buttons prev" id="jcarousel-prev-1"></a>-->
<!---->
<!--                                <div class="viewport">-->
<!--                                    <div class="jcarousel-skin-default">-->
<!--                                        <div class="jcarousel jcarousel-vertical" id="jcarousel-1">-->
<!--                                            --><?php //$this->widget('application.components.widgets.WeatherMenu'); ?>
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <a href="#" class="arrow_down buttons next" id="jcarousel-next-1"></a>-->
<!--                            </ul>-->
<!---->
<!--                        </li>-->
<!---->
<!--                        <li class="two_info">-->
<!---->
<!--                            <div class="widget-info currency_main">-->
<!--                                --><?php //$this->widget('application.components.widgets.Currency'); ?>
<!--                            </div>-->
<!--                            <span></span>-->
<!---->
<!--                            <ul class="info2">-->
<!--                                <div class="currency_trade">-->
<!--                                    <span>--><?//= Yii::t("app", "покупка") ?><!--</span>-->
<!--                                    <span-->
<!--                                        class="money sale">--><?php //$this->widget('application.components.widgets.Currency'); ?><!--</span>-->
<!--                                    <span>--><?//= Yii::t("app", "продажа") ?><!--</span>-->
<!--                                    <span-->
<!--                                        class="money buy">--><?php //$this->widget('application.components.widgets.CurSale'); ?><!--</span>-->
<!--                                </div>-->
<!--                                <div class="valuta">-->
<!--                                    <a class="arrow_up" href="javascript:void(0);"></a>-->
<!--                                    --><?php //$this->widget('application.components.widgets.CurrencyMenu'); ?>
<!--                                    <a class="arrow_down" href="javascript:void(0);"></a>-->
<!--                                </div>-->
<!--                            </ul>-->
<!--                        </li>-->
<!---->
<!--                        <li class="three_info">-->
<!---->
<!--                            <div id="traffic_top" class="widget-info">-->
<!--                                --><?php //$this->widget('application.components.widgets.Traffic'); ?>
<!--                            </div>-->
<!--                            <span></span>-->
<!---->
<!--                            <ul id="slider2" class="info1 sliders">-->
<!--                                <a href="#" class="arrow_up buttons prev" id="jcarousel-prev-2"></a>-->
<!---->
<!--                                <div class="viewport">-->
<!--                                    <div class="jcarousel-skin-default">-->
<!--                                        <div class="jcarousel jcarousel-vertical" id="jcarousel-2">-->
<!--                                            --><?php //$this->widget('application.components.widgets.TrafficMenu'); ?>
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <a href="#" class="arrow_down buttons next" id="jcarousel-next-2"></a>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                    </ul>-->
                    <?php $this->widget('application.components.widgets.LangMenu'); ?>
<!--                </div>-->
            <?php elseif ($this->layout == '//layouts/column3'): ?>
                <div class="top-seting-block">
                    <?
                        if (!isset($uri)) $uri = "";
                        if (!isset($uid)) $uid = "";
                    ?>
                    <ul class="different_indormation user-panel">
                        <li class="one_info<?php print(($uri == '/news/bookmarks' || substr($uri, 3) == '/news/bookmarks') ? ' active' : ' ') ?>">
                            <a href="<?php echo Yii::app()->createUrl('/news/bookmarks'); ?>">
                                <i class="bookmarks"></i>
                            </a>
                        </li>

                        <li class="two_info<?php print(($uri == '/category/mythemes' || substr($uri, 3) == '/category/mythemes') ? ' active' : ' ') ?>">
                            <a href="<?php echo Yii::app()->createUrl('/category/mythemes'); ?>" class="">
                                <i class="mythemes"></i>
                            </a>
                        </li>
<!--comment-out for activating blogger ref-->
<!--                        <li class="three_info--><?php //print(($uri == '/news/blog/' . $uid || substr($uri, 3) == '/news/blog/' . $uid) ? ' active' : ' ') ?><!--">-->
<!--                            <a href="--><?php //echo Yii::app()->createUrl('/bloger/request'); ?><!--">-->
<!--                                <i class="request"></i>-->
<!--                            </a>-->
<!--                        </li>-->

                        <li class="four_info<?php print(($uri == '/user/profile/edit' || substr($uri, 3) == '/user/profile/edit') ? ' active' : ' ') ?>">
                            <?php if (Yii::app()->user->isGuest): ?>
                                <?php echo CHtml::link('<i class="edit"></i>', 'javascript:void(0);', array('onclick' => 'regPopup()')); ?>
                            <?php else: ?>
                                <?php echo CHtml::link('<i class="edit"></i>', Yii::app()->createUrl('/user/profile/edit')); ?>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <?php if (Yii::app()->getModule('user')->isWithHighPermissions()): ?>
        <?php include('admin_menu.php'); ?>
    <?php endif; ?>

    <?php
    $this->widget('application.components.widgets.ActiveMenuNaver');
    ?>

    <div id="content" class="container zoom_<?php echo NKHelper::getZoom(); ?>"
         data-zoom="<?php echo NKHelper::getZoom(); ?>">

        <script type="text/javascript">
            $("#mainNavbar").on("click", function () {
                $('#mainNavbarNaver-2').toggleClass('active');
            });
        </script>

        <?php echo $content; ?>

        <div class="clear"></div>
    </div>
    <!-- content -->

    <footer class="footer">
        <div class="footer-outer container">

            <!--START mobile new-->
            <a href="" class="about-us-mobile">О нас</a>

            <ul class="mobile-app-mobile">
                <li class="soc"><a class="android" href="#"></a></li>
                <li class="soc"><a class="apple" href="#"></a></li>
            </ul>


            <ul class="social-mobile">
                <li><a class="fb" href="https://www.facebook.com/newskeeper.russia" target="_blank"></a></li>
                <li><a class="in" href="http://instagram.com/newskeeper_russia" target="_blank"></a></li>
                <li><a class="tw" href="https://twitter.com/newskeeper_ru" target="_blank"></a></li>
                <li><a class="vk" href="https://vk.com/newskeeper_ru" target="_blank" ></a></li>
                <!--                <li> <a class="shit-shit" id="" href="javascript:void(0);" onclick="shitRemove();"> Black </a> </li>-->
            </ul>


<!--END m new mobile footer-->

            <ul class="social">
                <li class="open"><span></span></li>
                <li class="soc"><a class="apple_icon" href="#"></a></li>
                <li class="soc"><a class="android_icon" href="#"></a></li>
            </ul>

            <ul class="contact_copyright">
                <li><span
                        class="all_rights"><?php echo Yii::t("app", "Все права защищены") ?> &copy; <?php echo date('Y'); ?>
                        \&nbsp;</span></li>
                <li class="about_footer_linck"><a
                        href="<?php echo Yii::app()->createUrl("/site/contact"); ?>"><?php echo Yii::t("app", "О нас") ?></a>
                    \&nbsp;</li>
                <li class="about_footer_linck"><a
                        href="<?php echo Yii::app()->createUrl("/site/terms"); ?>"><?php echo Yii::t("app", "Правила") ?></a>
                </li>
            </ul>

            <!-- search starts -->
            <?php
            /*To import the client script*/
            $baseUrl = Yii::app()->baseUrl;
            $cs = Yii::app()->getClientScript();
            ?>

            <!-- search ends -->

            <ul class="social2">
                <li><a class="fb" href="https://www.facebook.com/newskeeper.russia" target="_blank"></a></li>
                <li><a class="in" href="http://instagram.com/newskeeper_russia" target="_blank"></a></li>
                <li><a class="tw" href="https://twitter.com/newskeeper_ru" target="_blank"></a></li>
                <li><a class="vk" href="https://vk.com/newskeeper_ru" target="_blank" ></a></li>
<!--                <li> <a class="shit-shit" id="" href="javascript:void(0);" onclick="shitRemove();"> Black </a> </li>-->
            </ul>

            <script>
                function shitRemove() {
                    $('.custom-popup').magnificPopup( {
                        type: 'inline',
                        // When elemened is focused, some mobile browsers in some cases zoom in
                        // It looks not nice, so we disable it:
                        callbacks: {
                            beforeOpen: function() {
                                console.log('custom-test-popup');
                            }
                        }
                    } );
                }
            </script>


            <div class="search-block">
                <?php
                $model_name = Yii::app()->controller->id;
                $current_url = $baseUrl . "/news";
                ?>
                <input class="current_url" type="hidden" id="<?php echo $current_url; ?>" value="Поиск по сайту"/>

                <form name="search_form" id="searchForm">
                    <input name="query" type="text" id="faq_search_input"/>
                </form>
            </div>

        </div>
    </footer>
    <div id="footer-bg"></div>

    <!--<p id="back-top">
        <a href="#top" ><img src="/images/scroller_up.png" /></a>
    </p> -->
    <div class="go-up" title="Вверх" id='ToTop'></div>
    <div class="go-down" title="Вниз" id='OnBottom'></div>
    <div id="dictionary" data-loading="<?php echo Aii::tr('loading') ?>"></div>


</div>
<!-- END SCROLL_WRAP -->


<!-- Yandex.Metrika informer -->
<a href="https://metrica.yandex.com/stat/?id=29892879&amp;from=informer" style="display: none"
   target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/29892879/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                                       style="width:88px; height:31px; border:0;" alt="Yandex.Metrica"
                                       title="Yandex.Metrica: data for today (page views, visits and unique users)"
                                       onclick="try{Ya.Metrika.informer({i:this,id:29892879,lang:'en'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter29892879 = new Ya.Metrika({
                    id: 29892879,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div><img src="//mc.yandex.ru/watch/29892879" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>