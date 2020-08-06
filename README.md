<h1 align="center">Translate</h1>

# Requirement

```
PHP >= 7.0
```

# Installation

```shell
$ composer require "chenyongze/translate" -vvv
```

# Usage


```php
<?php

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
            'app_id' => 'your-baidu-app_id',
            'app_key' => 'your-baidu-app_key',
        ],
        'youdao' => [
            'ssl' => false,
            'app_id' => '你的有道智云 应用ID',
            'app_key' => '你的有道智云 应用密钥',
        ],
        'jinshan' => [
            'app_id' => '',
            'app_key' => '',
        ]
    ],
];

$translate = new TranslateManager($config);

$result = $translate->driver()->translate('测试', 'zh', 'en');
$result = $translate->driver('google')->translate('测试', 'zh', 'en');
$result = $translate->driver('baidu')->translate('测试', 'zh', 'en');
$result = $translate->driver('youdao')->translate('测试', 'zh', 'en');
$result = $translate->driver('jinshan')->translate('测试', 'zh', 'en');

var_dump($result);
var_dump($result->getSrc());
var_dump($result->getDst());
var_dump($result->getOriginal());
```
