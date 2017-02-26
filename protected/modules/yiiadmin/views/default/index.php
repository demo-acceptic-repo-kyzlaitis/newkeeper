<?php
$this->pageTitle=$title;
?>
<div class="column span-12">
    <div class="module" id="app_auth">
        <h2><?php echo YiiadminModule::t('Список Разделов'); ?></h2>

        <?php foreach($models as $m): ?>
            <div class="row">
              <div class="left_cell">
                <div class="mainlink">
                <?php 
                print (CHtml::link(
                        $this->module->getModelNamePlural($m),
                        $this->createUrl('manageModel/list',array('model_name'=>$m))
                    )); ?></div>
                <div class="sublinks">
                 <?php
                 $mod = $m::model();
                 if(method_exists($mod,'getStatuses')){ 
                    //echo $m;
                    //var_dump(method_exists($mod,'getStatuses'));
                    $statuses = array_flip($mod::getStatuses());
                 }else{ 
                    $statuses = array();
                 }
                 if(!empty($statuses)):
                 $st_title = $mod::getStatusTitles();
                 foreach($statuses as $st):
                 ?>
                 <?php print CHtml::link($st_title[$st],$this->createUrl('manageModel/list',array('model_name'=>$m,'status'=>$st))); ?>
                 <?php endforeach; ?>
                 <?php endif; ?>
                 </div>
               </div>
               <div class="right_cell">
                  <ul class="actions">
                    <li class="add-link">
                    <?php echo CHtml::link(YiiadminModule::t('Создать'),$this->createUrl('manageModel/create',array('model_name'=>$m))); ?>
                    </li><!--
                    <li class="change-link">
                    <?php //echo CHtml::link(YiiadminModule::t('Изменить'),$this->createUrl('manageModel/list',array('model_name'=>$m))); ?> 
                    </li> -->
                  </ul>
                  <div style="clear:both"></div>
               </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    
    <div class="module"> 
        <h2><?php echo YiiadminModule::t('Права'); ?></h2>

            <div class="row">
                <div class="mainlink"><a href="/rights/assignment/view">Присвоение ролей</a></div>
            </div>
            <div class="row">
                <div class="mainlink"><a href="/rights/authItem/permissions">Права доступа</a></div>
            </div>
            <div class="row">
                <div class="mainlink"><a href="/rights/authItem/roles">Роли</a></div>
            </div>
            <div class="row">
                <div class="mainlink"><a href="/rights/authItem/tasks">Задачи</a></div>
            </div>
            <div class="row">
                <div class="mainlink"><a href="/rights/authItem/operations">Операции</a></div>
            </div>
    </div>
</div> 

<!--
<div class="column span-6 last"> 
    <div class="module actions" id="recent-actions-module"> 
        <h2>Последние действия</h2>
        <div class="module"> 
                <ul>
                    <li>action text</li>
                </ul>
        </div>
    </div> 
</div> 
-->
