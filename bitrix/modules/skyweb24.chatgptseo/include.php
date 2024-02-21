<?php

require_once __DIR__ . "/vendor-scope/vendor/autoload.php";

\CJSCore::RegisterExt("skyweb24.chatgptseo",
    [
        "lang" => [
            "/bitrix/modules/skyweb24.chatgptseo/lang/" . LANGUAGE_ID . "/js/script.php",
        ],
        "js"   => [
            "/bitrix/js/skyweb24.chatgptseo/js/script.js",
            "/bitrix/js/skyweb24.chatgptseo/js/BuilderChartDiagram.js",
            "/bitrix/js/skyweb24.chatgptseo/js/BuilderChartGraph.js",
        ],
        "css"  => [
            "/bitrix/css/skyweb24.chatgptseo/css/styles.css"
        ],
    ]);
?> 