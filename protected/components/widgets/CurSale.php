<?php

class CurSale extends CWidget {

    public function run()
    {
        $currency_id = WidgetCurrencyElement::getAssignedCurrencyId();
        $model = WidgetCurrencyElement::model()->findByPk($currency_id);

        $course_ar = $model->getCurrency();
        echo $course_ar[1];
    }
}