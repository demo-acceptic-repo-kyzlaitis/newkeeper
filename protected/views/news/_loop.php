<?php 
    $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
    'viewData'=>array('blog'=>(isset($blog) ? $blog : false),
                      'alien'=>(isset($alien) ? $alien : false),
                      'bloger'=>(isset($bloger) ? $bloger : false)),
	'itemView'=>'_view',
    'tagName'=>'section',
    'id'=>'main_section',
    'ajaxUpdate'=>false,
    'template'=>'<div id="searchresultdata" class="faq-articles"> </div>{items}{pager}',
    'htmlOptions'=>array('class'=>isset($search) ? "search" : ""),
    'emptyText'=>(isset($empty_text) ? $empty_text : ''),
    'pager'=>array(
            'htmlOptions'=>array(
                'class'=>'paginator',
            ),
    ),
));
?>

<?php //echo $dataProvider->totalItemCount.' '; echo $dataProvider->pagination->pageSize; ?>
<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize): ?>
 
    <!--p id="loading" style="display:none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="" /></p-->
 
    <script type="text/javascript">
    /*<![CDATA[*/
        (function($)
        {
            // скрываем стандартный навигатор
            $('.pager').hide();
 
            // запоминаем текущую страницу и их максимальное количество
            var page = parseInt('<?php echo (int)Yii::app()->request->getParam('page', 1); ?>');
            var pageCount = parseInt('<?php echo (int)$dataProvider->pagination->pageCount; ?>');

            var loadingFlag = false;
            
            $(document).scroll(function()
            {
                if ($(this).scrollTop() > 150) {	
                    $("#back-top").fadeIn()	
                } else {	
                    $("#back-top").fadeOut()	
                }
                // защита от повторных нажатий
                if (!loadingFlag && ($(window).scrollTop() + 1) >= ($(document).height() - $(window).height()) && page < pageCount)
                {
                    // выставляем блокировку
                    loadingFlag = true;
 
                    // отображаем анимацию загрузки
                    //$('#loading').show();

                    var url = window.location.href;
                    var keyword = '';
                    if ($('#main_section').hasClass('while_search')) {
                        keyword = $("#faq_search_input").val();
                        url = "/news/SearchEngine";
                    }

                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {
                            // передаём номер нужной страницы методом POST
                            'page': page + 1,
                            '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>',
                            keyword: keyword
                        },
                        success: function(data)
                        {
                            // увеличиваем номер текущей страницы и снимаем блокировку
                            page++;                            
                            loadingFlag = false;                            
 
                            // прячем анимацию загрузки
                            $('#loading').hide();
 
                            // вставляем полученные записи после имеющихся в наш блок
                            $('#main_section').append(data);
                            $('#main_section > div > .items > .image_news.name_blogger').remove();
                            var ajax_added = $('#main_section > div > .items').html();
                            if ($('#main_section').hasClass('while_search') && typeof ajax_added != 'undefined') {
                                $('#searchresultdata .items').html($('#searchresultdata .items').html() + ajax_added);
                            } else {
                                $('#main_section > .items').html($('#main_section > .items').html() + ajax_added);
                            }
                            $('#main_section > div > .items').remove();
                            
                            initAfterNewsLoad();
            				$('.image_news').addClass('loaded');
                        }
                    });
                }
                return false;
            })
        })(jQuery);
    /*]]>*/
    </script>
 
<?php endif; ?>