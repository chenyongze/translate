<?php

include dirname(__DIR__) . "/vendor/autoload.php";

use Yong\Translate\TranslateManager;

$config = [
    'default' => 'google',
    'drivers' => [
        'google' => [
            'app_id' => '',
            'app_key' => '',
        ],
        'baidu' => [
            'ssl' => true,
            'app_id' => '20200806000534294',
            'app_key' => 'xxx',
        ],
        'youdao' => [
            'ssl' => true,
            'app_id' => '478ddab3c227c427',
            'app_key' => 'xxxx',
        ],
        'jinshan' => [
            'app_id' => '',
            'app_key' => '',
        ]
    ],
];

$translate = new TranslateManager($config);

try {
    // $result = $translate->driver()->translate('测试', 'zh', 'en');
    // $result = $translate->driver('google')->translate('测试', 'zh', 'en');
    $result = $translate->driver('baidu')->translate('mp', 'auto', 'zh');
    // $result = $translate->driver('youdao')->translate('测试', 'zh', 'en');
    // $result = $translate->driver('jinshan')->translate('测试', 'zh', 'en');

    // var_dump($result);
    // var_dump($result->getSrc());
    var_dump($result->getDst());
    // var_dump($result->getOriginal());
} catch (\Throwable $th) {
    //throw $th;
    var_dump($th->getMessage());
    var_dump($th->getCode());
}
