<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php echo $content; ?>
    <div id="cabinet_wrapper">
        <aside id="cabinet">
            <div class="cabinet_inner">
                <div class="cabinet_avatar">
                    <?php
                    if (Yii::app()->user->id)
                        $img = User::model()->findByPk(Yii::app()->user->id)->getAvatar(65, 'side_ava');
                    else
                        $img = CHtml::image("/images/avatar_unregistered.jpg");
                    ?>
                    <?php print((Yii::app()->user->id) ? CHtml::link($img . "<div>" . Yii::t("app", "Кабинет"), Yii::app()->createUrl("/news/bookmarks")) . "</div>" : "") ?>
                    <?php print((Yii::app()->user->id ? "" : CHtml::link($img . "<div class='open'>" . Yii::t("app", "Войти"), 'javascript:void(0);', array('class' => 'regPopup')) . "</div>")) ?>
                </div>

                <script>
                    $(function () {
                        $('.jcarousel').jcarousel();
                    });

                    $("#jcarousel-prev-3").click(function () {
                        $('.jcarousel').jcarousel('scroll', '-=1');
                    });

                    $("#jcarousel-next-3").click(function () {
                        $('.jcarousel').jcarousel('scroll', '+=1');
                    });

                    $(function () {
                        //var pos = 4;
                        var pos = 0;
                        $(".overview:first li a", "#slider1").each(function (index) {

                            var className = $(this).attr('class');

                            if (className == 'active') pos = index;
                        });
                        //alert(pos);
                        if (pos > 22) pos = 22;
                        $('#jcarousel-1')
                            .on('jcarousel:createend', function () {
                                var mov = pos - 2;
                                if (mov < 0) mov = 0;
                                $(this).jcarousel('scroll', mov, false);
                            })
                            .jcarousel({
                                animation: 10
                            })

                        $('#jcarousel-prev-1').jcarouselControl({target: '-=1'});
                        //$('#jcarousel-next-1').jcarouselControl({target: '+=1'});
                        $('#jcarousel-next-1').click(function () {
                            var top = $('.overview:first', "#slider1").css('top');

                            if (top != '-600px') {

                                $('#jcarousel-1').jcarousel('scroll', '+=1');
                            }
                        });

                        var top = (pos - 2) * 30;
                        $('.overview:first', "#slider1").css('top', '-' + top + 'px');
                    });

                    $(function () {
                        var pos = 0;
                        $(".overview:first li a", "#slider2").each(function (index) {

                            var className = $(this).attr('class');

                            if (className == 'active') pos = index;
                        });

                        if (pos > 22) pos = 22;

                        $('#jcarousel-2')
                            .on('jcarousel:createend', function () {
                                var mov = pos - 2;
                                if (mov < 0) mov = 0;
                                $(this).jcarousel('scroll', mov, false);

                            })
                            .jcarousel({
                                animation: 10
                            })

                        $('#jcarousel-prev-2').jcarouselControl({target: '-=1'});
                        //$('#jcarousel-next-2').jcarouselControl({target: '+=1'});
                        $('#jcarousel-next-2').click(function () {
                            var top = $('.overview:first', "#slider2").css('top');

                            if (top != '-600px') {

                                $('#jcarousel-2').jcarousel('scroll', '+=1');
                            }
                        });

                        var top = (pos - 2) * 30;
                        $('.overview:first', "#slider2").css('top', '-' + top + 'px');
                    });

                </script>
                <script>
                    $(function () {
                        //var pos = 4;
                        var pos = 0;
                        $(".overview:first li a", "#slider3").each(function (index) {

                            var className = $(this).attr('class');
                            if (className == 'active') pos = index;
                        });
                        //alert(pos);
                        if (pos > 22) pos = 22;
                        $('#jcarousel-3')
                            .on('jcarousel:createend', function () {
                                var mov = pos - 2;
                                if (mov < 0) mov = 0;
                                $(this).jcarousel('scroll', mov, false);

                            })
                            .jcarousel({
                                animation: 10
                            })

                        $('#jcarousel-prev-3').jcarouselControl({target: '-=1'});
                        //$('#jcarousel-next-1').jcarouselControl({target: '+=1'});
                        $('#jcarousel-next-3').click(function () {
                            var top = $('.overview:first', "#slider3").css('top');

                            if (top != '-600px') {

                                $('#jcarousel-3').jcarousel('scroll', '+=1');
                            }
                        });

                        $('#overview-3 li a').click(function () {
                            var index_to = $(this).parent().index();

                            $(".overview:first li a", "#slider3").each(function (index) {
                                if (index == index_to) $(this).attr('class', 'active'); else $(this).attr('class', '');
                            });
                        });

                        var top = (pos - 2) * 30;
                        $('.overview:first', "#slider3").css('top', '-' + top + 'px');
                    });

                    $(function () {
                        var pos = 0;
                        $(".overview:first li a", "#slider4").each(function (index) {

                            var className = $(this).attr('class');

                            if (className == 'active') pos = index;
                        });
                        //alert(pos);
                        if (pos > 22) pos = 22;

                        $('#jcarousel-4')
                            .on('jcarousel:createend', function () {
                                var mov = pos - 2;
                                if (mov < 0) mov = 0;
                                $(this).jcarousel('scroll', mov, false);

                            })
                            .jcarousel({
                                animation: 10
                            })

                        $('#jcarousel-prev-4').jcarouselControl({target: '-=1'});

                        $('#jcarousel-next-4').click(function () {
                            var top = $('.overview:first', "#slider4").css('top');

                            if (top != '-600px') {

                                $('#jcarousel-4').jcarousel('scroll', '+=1');
                            }
                        });

                        var top = (pos - 2) * 30;
                        $('.overview:first', "#slider4").css('top', '-' + top + 'px');
                    });

                </script>
                <ul class="different_indormation widget-panel side">
                    <li class="one_info">
                        <div id="temperature" class="widget-info">
                            <?php $this->widget('application.components.widgets.Temperature'); ?>
                        </div>
                        <span></span>


                        <ul id="slider3" class="info1 sliders">
                            <a href="#" class="arrow_up buttons prev" id="jcarousel-prev-3"></a>

                            <div class="viewport">
                                <div class="jcarousel-skin-default">
                                    <div class="jcarousel jcarousel-vertical" id="jcarousel-3">
                                        <?php $this->widget('application.components.widgets.WeatherMenu', array('html_id' => '3')); ?>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="arrow_down buttons next" id="jcarousel-next-3"></a>
                        </ul>


                    </li>

                    <li class="two_info">

                        <div class="currency_main widget-info">
                            <?php $this->widget('application.components.widgets.Currency'); ?>
                        </div>
                        <span></span>

                        <ul class="info2">
                            <div class="currency_trade">
                                <span><?= Yii::t("app", "покупка") ?></span>
                                <span
                                    class="money sale"><?php $this->widget('application.components.widgets.Currency'); ?></span>
                                <span><?= Yii::t("app", "продажа") ?></span>
                                <span
                                    class="money buy"><?php $this->widget('application.components.widgets.CurSale'); ?></span>
                            </div>
                            <div class="valuta">
                                <a class="arrow_up" href="javascript:void(0);"></a>
                                <?php $this->widget('application.components.widgets.CurrencyMenu'); ?>
                                <a class="arrow_down" href="javascript:void(0);"></a>
                            </div>
                        </ul>
                    </li>
<!--                    <li class="three_info">-->
<!---->
<!--                        <div id="traffic" class="widget-info">-->
<!--                            --><?php //$this->widget('application.components.widgets.Traffic'); ?>
<!--                        </div>-->
<!--                        <span></span>-->
<!---->
<!--                        <ul id="slider4" class="info1 sliders">-->
<!--                            <a href="#" class="arrow_up buttons prev" id="jcarousel-prev-4"></a>-->
<!---->
<!--                            <div class="viewport">-->
<!--                                <div class="jcarousel-skin-default">-->
<!--                                    <div class="jcarousel jcarousel-vertical" id="jcarousel-4">-->
<!--                                        --><?php //$this->widget('application.components.widgets.TrafficMenu'); ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <a href="#" class="arrow_down buttons next" id="jcarousel-next-4"></a>-->
<!--                        </ul>-->
<!--                    </li>-->
                </ul>
                    <?php $this->widget('application.components.widgets.LangMenu'); ?>
                    <?php //$this->widget('application.components.widgets.LangMenuSelect');?>

                    <div id="zoomer">
                        <div id="plus"></div>
                        <div id="minus"></div>
                        <!--<span id="zoomval"></span>-->
                    </div>
                    <script>
                        $('#plus').click(function () {
                            var zoom = $('#content').data('zoom');
                            if (zoom < 2) {
                                $('#content').removeClass('zoom_' + zoom);
                                zoom++;
                                $('#content').data('zoom', zoom);
                                $('#content').addClass('zoom_' + zoom);
                                $.post('/site/zoom', {'zoom': zoom});
                                heightBlock();
                                adjustFontsize();
                            }
                            $('#zoomval').text(zoom);
                        });
                        $('#minus').click(function () {
                            var zoom = $('#content').data('zoom');
                            if (zoom > 1) {
                                $('#content').removeClass('zoom_' + zoom);
                                zoom--;
                                $('#content').data('zoom', zoom);
                                $('#content').addClass('zoom_' + zoom);
                                $.post('/site/zoom', {'zoom': zoom});
                                heightBlock();
                                adjustFontsize();
                            }
                            $('#zoomval').text(zoom);
                        });

                        $('#zoomer span').click(function () {
                            $('.image_news').height($('.image_news').width());
                        });
                    </script>

                    <div class="logout_wrap">
                        <?php print (((Yii::app()->user->id)) ? CHtml::link(Yii::t("app", "Выйти"), '/user/logout', array('class' => 'logout')) : "") ?>
                    </div>
            </div>
        </aside>
        <div id="sidebar">

            <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => 'Operations',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items' => $this->menu,
                'htmlOptions' => array('class' => 'operations'),
            ));
            $this->endWidget();
            ?>
            <?php //$this->widget('application.components.weather.GoogleWeatherAPI', array('location'=>$location));
            //$location  = "Kiev"; // can also be: Denver,CO
            //$API_url = "http://api.worldweatheronline.com/free/v1/weather.ashx?q=".$location."&format=xml&num_of_days=1&key=rcsvmajxeyqsedyw69mvgzjj";

            //$xml  = simplexml_load_file($API_url);
            //print($xml->current_condition->temp_C);
            ?>
        </div>
        <!-- sidebar -->
    </div><!-- sidebar wrapper -->
<?php $this->endContent(); ?>