$(document).ready(function(){
        $('ul.main li a').removeClass('active');
        //$('.submain > div').hide();
        
        $('ul.main li a').click(function(){
            $('ul.main li a').removeClass('active');
            $(this).addClass('active');
            $('.submain > div').hide();
            var curr = $(this).attr('href').slice(1);
            $('.submain > div#'+curr+'_item').fadeIn();
        })
        $('ul.main li a').each(function(i){
            var path = window.location.pathname.split("/");
            if(path[1] == 'ru' || path[1] == 'en' || path[1] == 'ua')
                var key = path[2];
            else
                var key = path[1];
            if('#'+key == $(this).attr('href') || '#'+key+'_item' == $(this).attr('href')){
                $(this).addClass('active');
                $('.submain > div#'+key+'_item').show();
            }
        });
        $('textarea').each(function(i){
            if($('.smf').length > 0)
                var color = '#000';
            else
                var color = '#fff';
            if($(this).attr('id').search('text') != -1){
                $(this).cleditor({'width':840,'height':460,'bodyStyle':"margin: 10px 4px 4px; font:10pt Arial,Verdana; cursor:text; color:"+color+"; line-height:18px; "});
            }
        });
        
    var lang = $('#News_lang').val();
    var langs = {1:'en',2:'ru',3:'uk'};
    $('.news_title .row-form').hide();
    $('#News_name_'+langs[lang]).parent().show();
    $('.news_text .row-form').hide();
    $('#News_text_'+langs[lang]+'_em_').parent().show();
    
    $('#News_lang').change(function(){
        $('.news_title .row-form').hide();
        $('.news_text .row-form').hide();
        $('#News_name_'+langs[$(this).val()]).parent().show();
        $('#News_text_'+langs[$(this).val()]+'_em_').parent().show();
    });
});