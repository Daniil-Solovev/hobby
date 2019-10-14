<?php

return [
    'load'           => 'site/loadArticles',
    'modal/([0-9]+)' => 'site/modal/$1',
    'page/([0-9]+)'  => 'site/index/$1',
    ''               => 'site/index',   // actionIndex  в SiteController
];