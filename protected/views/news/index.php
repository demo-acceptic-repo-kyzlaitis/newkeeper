<?php
/* @var $this NewsController */
/* @var $dataProvider CActiveDataProvider */
?>

<?php
if(!isset($empty_text))
    $empty_text = "";
    
$this->renderPartial('_loop', array(
    'dataProvider'=>$dataProvider,
    'empty_text'=>$empty_text,
    'blog'=>(isset($blog) ? $blog : false),
    'alien'=>(isset($alien) ? $alien : false),
    'bloger'=>(isset($bloger) ? $bloger : false),
    'search'=>isset($search) ? "search" : "",
)); ?>

<div class="pupua-news">
    <header class="news-header">
        <ul class="text-size">
                <li class="plus"><a href="javascript:void(0)" onclick="font(1)"></a></li>
                <li class="minus"><a href="javascript:void(0)" onclick="font(0)"></a></li>
        </ul>           
    </header>
    <div id="btn-closes" onclick="javascript:location.hash = '';"></div>                       
    <div id="id_view" class="id_view">
    </div>
</div>
<?php
// if isset popup_id open that news in popup
if(isset($popup_id)): ?>
    <script>
    $.post('/news/view/<?php echo $popup_id; ?>',function(html){ $('#id_view').html(html); });
    </script>
<?php endif; ?>