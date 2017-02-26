<?php //dd($dataProvider);
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'ajaxUpdate'=>false,
    'template' => "{items}",
    'viewData'=>array('blog'=>(isset($blog) ? $blog : false),
                      'alien'=>(isset($alien) ? $alien : false),
                      'bloger'=>(isset($bloger) ? $bloger : false)),
    'htmlOptions'=>array('class'=>isset($search) ? "search" : ""),
    'emptyText'=>(isset($empty_text) ? $empty_text : ''),
)); ?>