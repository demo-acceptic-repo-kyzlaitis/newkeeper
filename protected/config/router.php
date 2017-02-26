<?php 

$lang = '<lang:(ru)>/';

$modules = array(
    'user',
    'rights',
    'yiiadmin',
);

$rules = array(
	'gii'=>'gii',
	'yiiadmin'=>'yiiadmin',
	'rights'=>'rights/assignment',
	'gii/<controller:\w+>'=>'gii/<controller>',
	'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
    '/user/login'=>'user/registration',
    '/'=>'site/announcement',
    'rss'=>'site/rss',
    'instagram' => 'socialNetwork/instagram',
    'instagramLogin' => 'socialNetwork/instagramLogin',
    'searchUsers' => 'socialNetwork/searchUsers'
);

$basic_rules = array(
	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
	'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
	'<controller:\w+>/<action:\w+>/<slug>'=>'<controller>/<action>',
	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
    '<controller:\w+>'=>'<controller>/index',
);

$basic_rules_mod = array();
$modules_pattern = '<module:(' . implode('|', $modules) . ')>/';

foreach($basic_rules as $pattern=>$route)
{
    $basic_rules_mod[$modules_pattern . $pattern] = '<module>/' . $route;
}

$basic_rules = array_merge($basic_rules_mod, $basic_rules);

$rules_lang = array();
$basic_rules_lang = array();

foreach($rules as $pattern=>$route)
{
    $rules_lang[$lang . $pattern] = $route;
}

foreach($basic_rules as $pattern=>$route)
{
    $basic_rules_lang[$lang . $pattern] = $route;
}
$rules = array_merge($rules_lang, $rules);
$basic_rules = array_merge($basic_rules_lang, $basic_rules);

$rules = array_merge($rules, $basic_rules);
//var_dump($rules);exit;
return $rules;