<?php
    $this->pageTitle=$title;

    $cs=Yii::app()->getClientScript();
    $cs->registerScriptFile($this->module->assetsUrl.'/tinymce/jscripts/tiny_mce/tiny_mce.js');
    $cs->registerScriptFile($this->module->assetsUrl.'/tinymce/jscripts/tiny_mce/jquery.tinymce.js'); 
    $cs->registerScriptFile($this->module->assetsUrl.'/tinymce_setup/tinymce_setup.js');
/*
    $rules = $model->rules();
    if(get_class($model) == 'UserAdmin')
        $rules = $model->rulesAdmin();        
   
    foreach ($rules as $rule)
    {
        // Атрибуты поиска нас не интерисуют.
        if ($rule['on']!='search')
            $attr_string.=$rule[0].',';
    }
    
    // TODO: unset primaryKey;
    $attributes=array_filter(array_unique(array_map('trim',explode(',',$attr_string))));*/
    
    $attr_arr = $model->attributeWidgets();
    
    $first = 'first_step';
    $second = 'second_step';
    $third = 'third_step';
    $ru = ' ru';
    $uk = ' uk';
    
    $steps = array(
        'source' => $first,
        'ru' => $first,
        'uk' => $first,
        'categories' => $second,
        'author_id' => $second,
        'type_id' => $second,
        'status' => $second,
        'hot' => $second,
        'fixed' => $second,
        'blog' => $second,
        'preview_source' => $second,
        'name_ru' => $third,// . $ru,
        'name_uk' => $third,// . $uk,
        'teaser_ru' => $third,// . $ru,
        'teaser_uk' => $third,// . $uk,
        'text_ru' => $third,// . $ru,
        'text_uk' => $third,// . $uk,
    );
    $attributes = array();
    
    foreach ($attr_arr as $k=>$r)
    {
        $val = array();
        if(isset($r[2]))
            $val = $r[2];
            
        $attributes[$r[0]] = $val;
    }
    
    $langs_class = '';
    if(get_class($model) == 'NewsAdmin')
    {
        /*if($model->ru)  
            $langs_class .= ' ru';
        if($model->uk)  
            $langs_class .= ' uk';*/
        if(!$model->blog)  
            $langs_class .= ' noblog';
        if(isset($update))
        {
            $langs_class = ' second';
        }
    }
?>

<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>get_class($model).'-id-form',
    ));
?>

<div class="container-flexible<?php echo $langs_class?>">
        <?php if($model->hasErrors()): ?>
            <p class="errornote"><?php echo YiiadminModule::t('Пожалуйста, исправьте ошибки, указанные ниже.'); ?></p>
            <?php foreach ($model->errors as $error): ?>
                <?php foreach ($error as $error_text): ?>
                    <p class="errornote"><?php echo $error_text;?></p>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="form-container">
        <div>
            <fieldset class="module wide">
            <?php //var_dump($attributes);exit;
                foreach ($attributes as $attribute=>$widg_arr):
                
                if( $model->tableSchema->columns[$attribute]->isPrimaryKey===true && $attribute != 'user_id')
                    continue;
                if(isset($update) && method_exists($model,'excludeUpdate') && in_array($attribute,$model->excludeUpdate())){
                    $setPredefined = 1;
                    $adm_attr = $attribute.'Predefined';
        			$user = User::model()->findByPk($model->$attribute);
                    $model->$adm_attr = $user->email;
                }else{
                    $setPredefined = 0;
                }
            ?>
            <div class="row <?php if($widg_arr['widget'] == 'hidden') echo 'hidden';?> <?php if($model->getError($attribute)) echo 'errors'; ?> <?php echo $steps[$attribute] ?>">
                <div>
                <div class="max_char_string"></div>
                    <div class="column span-4"><?php echo $form->labelEx($model, $attribute); ?></div>
                    <div class="column span-flexible">
                        <?php echo $this->module->createWidget($form, $model, $attribute, $setPredefined, $widg_arr); ?>
                        <ul class="errorlist"><li><?php echo $form->error($model, $attribute); ?></li></ul>
                        <!-- <p class="help">Enter the same password as above, for verification.</p>-->
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            </fieldset>

<div class="module footer">
    <ul class="submit-row">
    <?php if (!$model->isNewRecord): ?>
        <li class="left delete-link-container">
            <?php echo CHtml::link(YiiadminModule::t('Удалить'),$this->createUrl('manageModel/delete',array(
                    'model_name'=>get_class($model),
                    'pk'=>$model->primaryKey,
                )),
                array(
                    'class'=>'delete-link',
                    'confirm'=>YiiadminModule::t('Удалить запись ID ').$model->primaryKey.'?',
            )); ?>
        </li> 
    <?php endif; ?>
        <li class="submit-button-container">
            <input type="submit" value="<?php echo YiiadminModule::t('Сохранить');?>" class="default" name="_save" />
        </li>
        <li class="submit-button-container">
            <input type="submit" value="<?php echo YiiadminModule::t('Сохранить и создать новую запись');?>" name="_addanother" />
        </li>
        <li class="submit-button-container">
            <input type="submit" value="<?php echo YiiadminModule::t('Сохранить и редактировать');?>" name="_continue" />
        </li><!--
        <li class="submit-button-container">
            <input type="submit" value="<?php echo YiiadminModule::t('Назад к списку');?>" class="default" name="_back" onclick="window.location = history.back()" />
        </li>-->
    </ul>
    <br clear="all" />
</div>
 
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>
<script>
$('#NewsAdmin-id-form .noblog .<?php echo $second?>, #NewsAdmin-id-form .noblog .<?php echo $third?>').hide();
$('#NewsAdmin-id-form .second .<?php echo $second?>').show();
$('#NewsAdmin-id-form .uk .uk.<?php echo $third?>, #NewsAdmin-id-form .ru .ru.<?php echo $third?>').show();
$('<div class="row readability"><button id="loadsource">Выкачать</button></div>').insertAfter($('.<?php echo $first?>').last());
$('<div class="row row_title .<?php echo $second?>">Редактор текста</div>').prependTo($('#NewsAdmin_text_ru').parents('.row'));
$('<div class="row row_title .<?php echo $second?>">Редактор заголовка</div>').prependTo($('#NewsAdmin_name_ru').parents('.row'));
$('<div class="row row_title .<?php echo $second?>">Редактор анонса</div>').prependTo($('#NewsAdmin_teaser_ru').parents('.row'));
$('#loadsource').click(function(){
	$.post('/news/readfromsource', { 'source' : $('#NewsAdmin_source').val()}, function(data){
		console.log(data)
		$('.row').show();
		$('#NewsAdmin_name_ru').val(data.title);
		$('#tinymce').text(data.text);
		tinymce.activeEditor.execCommand('mceSetContent', false, data.text);
	},'json');
	
	return false;
});
//$('#NewsAdmin-id-form .second .readability').hide();
</script>