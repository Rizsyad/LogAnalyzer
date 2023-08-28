# Apache Log Analytic


json

```php
<?php 
require __DIR__ ."/vendor/autoload.php";

use Rizsyad\LogAnalyzer;

$log = new LogAnalyzer\Log();

$log->setAccessLog("/etc/httpd");
$logs = $log->getAccessLogs();
?>
```

output
```
Array
(
    [countLog] => 10583
    [ipUnique] => 300
    [ipVisited] => Array
        (
            [xxx.xxx.xxx.xxx] => 4787
            [xxx.xxx.xxx.xxx] => 2701
            [xxx.xxx.xxx.xxx] => 882
            [xxx.xxx.xxx.xxx] => 203
            [xxx.xxx.xxx.xxx] => 168
            [xxx.xxx.xxx.xxx] => 163
            [xxx.xxx.xxx.xxx] => 155
            [xxx.xxx.xxx.xxx] => 131
            ...
        )

    [requestType] => Array
        (
            [GET] => 10449
            [POST] => 120
            [HEAD] => 4
            [PUT] => 2
            [OPTIONS] => 2
            [MOVE] => 2
            [PATCH] => 2
        )

    [platformType] => Array
        (
            [Windows] => 5030
            [Macintosh] => 3588
            [Linux] => 1234
            [Android] => 355
            [null] => 349
            [iPhone] => 25
            [iPad] => 2
        )

    [browserType] => Array
        (
            [Firefox] => 4659
            [Chrome] => 3712
            [MSIE] => 1474
            [Opera] => 345
            [Cpanel-HTTP-Client] => 154
            [null] => 111
            [Edge] => 35
            [Safari] => 25
            [Googlebot] => 16
            [MiuiBrowser] => 12
            [Googlebot-Image] => 9
            [Expanse] => 9
            [WhatsApp] => 5
            [CheckMarkNetwork] => 4
            [-] => 4
            [curl] => 3
            [Yandex] => 2
            [python-requests] => 2
            [GBWhatsApp] => 1
            [Wget] => 1
        )

    [referer] => Array
        (
            [null] => 5481
            [www.google.com] => 839
            [www.usatoday.com] => 827
            [engadget.search.aol.com] => 794
            [127.0.0.1] => 6
            [localhost] => 6
            [l.instagram.com] => 3
            [www.shuct.net] => 2
        )

)
```

output webview
```php
<?php 

require __DIR__ ."/vendor/autoload.php";

use Rizsyad\LogAnalyzer\WebView;

$webview = new WebView();
$webview->setAccessLog("/etc/httpd");
$webview->view();
?>
```