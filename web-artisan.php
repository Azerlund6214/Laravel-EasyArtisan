<?php
    # - ### ### ### ###

    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Artisan;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\File;

    # - ### ### ### ###
    #   **/ ARTISAN \**

    # Для красоты убираю все портянки сюда, отдельно.
    function AT_UI_getRandomBg()
    {
        $bg = [ # Рандомные фоны страницы, надоело белое полотно.
            'background: -webkit-linear-gradient(45deg,#fff25c,#f39ed9,#868adc); background: linear-gradient(45deg,#fff25c,#f39ed9,#868adc);',
            'background: -webkit-linear-gradient(90deg,#bc69dc,#5d2df4); background: linear-gradient(90deg,#bc69dc,#5d2df4);',
            'background: -webkit-linear-gradient(90deg,#bc69dc,#5d2df4); background: linear-gradient(90deg,#bc69dc,#5d2df4);',
            'background: -webkit-linear-gradient(90deg,#fa7ed1,#8886fc); background: linear-gradient(90deg,#fa7ed1,#8886fc);',
            'background-blend-mode: screen; background: linear-gradient(limegreen, transparent), linear-gradient(90deg, skyblue, transparent), linear-gradient(-90deg, coral, transparent);',
            'background-color: #f3a183; background-image: linear-gradient(transparent 0px, transparent 49px, rgba(255,255,255, 0.2) 50px, transparent 51px, transparent 99px, rgba(255,255,255, 0.2) 100px),
                linear-gradient(120deg, transparent 0, transparent 48px, rgba(255,255,255, 0.2) 49px, transparent 50px, transparent 98px, rgba(255,255,255, 0.2) 99px, transparent 100px),
                linear-gradient(60deg, transparent 0, transparent 48px, rgba(255,255,255, 0.2) 49px, transparent 50px, transparent 98px, rgba(255,255,255, 0.2) 99px, transparent 100px),
                linear-gradient(90deg, #f3a183, #eC6f66); background-size: 100px 100px, 115px 100px, 115px 100px, auto;'
        ];

        return $bg[ array_rand($bg) ];
    }
    function AT_UI_getArrMyUrls()
    {
        return [
                'DEV' => ['/test','/w','/o','/500','/404'],
                'DEV2' => [
                	['http://127.0.0.1/openserver/phpmyadmin/index.php','PMA OS 127'],
                	['http://'.$_SERVER['SERVER_ADDR'].'/openserver/phpmyadmin/index.php','PMA OS RealIP'],
                    'http://'.$_SERVER['SERVER_ADDR'].':1516','/al','/service','/micro-func'],
                'IP-MY' => [['https://ipinfo.io/','ipinfo.io'],['https://2ip.ru/','2ip.ru'],['https://whoer.net/ru','whoer.net'],
                    ['https://ipinfo.io/what-is-my-ip','ipinfo.io']
                ],
                'IP-BL' => ['https://dnschecker.org/ip-blacklist-checker.php'],
                'IP Convert' => ['https://dnschecker.org/ipv6-to-ipv4.php'],
                'IP Info' => ['https://dnschecker.org/ip-location.php','https://ipinfo.io/'],
                'IP Loopback API' => ['https://api.myip.com','https://api.ipify.org?format=json'],
                'UA' => ['https://dnschecker.org/user-agent-info.php',''],
                'DNS Propagation' => ['https://dnschecker.org/#A'],
                'DNS Records' => ['https://dns-lookup.com/','https://dnschecker.org/all-dns-records-of-domain.php'],
                'SSL Info' => ['https://dnschecker.org/ssl-certificate-examination.php'],
                'WHOIS IP' => ['https://dnschecker.org/ip-whois-lookup.php'],
                'WHOIS DOMAIN' => ['https://webbrowsertools.com/whois-lookup/'],
                'WHOIS ASN' => ['https://dnschecker.org/asn-whois-lookup.php'],
                'WEB SPEED' => ['https://webbrowsertools.com/network-information/'],
                'Ping site' => ['https://dnschecker.org/ping-ipv4.php'],
                'Lint' => ['https://jsonlint.com/'],
                'Time' => ['https://www.unixtimestamp.com/index.php'],
                'Generate' => [['https://dnschecker.org/mac-address-generator.php','MAC Address'],
                    ['https://www.random1.ru/generator-pasportnyh-dannyh','Паспорт'],
                    ['https://www.random1.ru/generator-inn-snils-oms-ogrn-kpp','ИНН ОМС и тд'],
                    ['https://www.random1.ru/','ФИО др тлф и тд'],
                    ['https://www.fakepersongenerator.com/imei-generator','IMEI Основной'],
                    ['https://www.axonwireless.com/toolbox/iccid-generator/','iccid Основной(Дал 3к за раз)'],
                    ['https://user-agents.net/random','UserAgent'],
                    ['https://products.aspose.app/html/ru/iframe-generator','IFRAME'],
                    ['',''],
                ],
                'JSON View' => ['https://webbrowsertools.com/json-beautifier/','https://dnschecker.org/online-json-viewer-beautifier.php'],
                'Decode' => ['https://www.urldecoder.org/','https://www.base64decode.org/'],
                'CRX Extractor' => ['https://crxextractor.com/'],
                'Теория и шпоры' => [
                    ['https://hcdev.ru/html/uni-attr/','HTML-hcdev'],['https://htmlbook.ru/html','HTML-htmlbook']
                ],
                'Leaks-webbrowsertools' => [
                    ['https://webbrowsertools.com/ip-address/','IP'],
                    ['https://webbrowsertools.com/useragent/','UA !!!'],
                    ['https://webbrowsertools.com/canvas-fingerprint/','CANVAS'],
                    ['https://webbrowsertools.com/webgl-fingerprint/','WEB-GL'],
                    ['https://webbrowsertools.com/test-webrtc-leak/','WEB-RTC'],
                    ['https://webbrowsertools.com/font-fingerprint/','FONT'],
                    ['https://webbrowsertools.com/screen-size/','SCREEN'],
                    ['https://webbrowsertools.com/timezone/','TIME'],
                ],
                'Leaks-browserleaks' => [
                    ['https://browserleaks.com/ip','IP'],
                    ['https://browserleaks.com/javascript','JS+SCREEN'],
                    ['https://browserleaks.com/canvas','CANVAS'],
                    ['https://browserleaks.com/webgl','WEB-GL + UA'],
                    ['https://browserleaks.com/webrtc','WEB-RTC'],
                    ['https://browserleaks.com/fonts','FONT'],
                ],
                'Обфускаторы и тп' => ['https://jscompress.com/'],
                'Прочее' => ['https://dnschecker.org/url-opener.php'],
                'Мощность пароля' => ['https://www.nexcess.net/web-tools/secure-password-generator/'],
                #'TEST' => [  ['/w','text'] , '123'  ],
                'QR-Code' => [  ['https://webbrowsertools.com/qrcode-reader/','Read'] , ['https://webbrowsertools.com/qrcode-generator/','Make']  ],

                #'123' => ['','','','','','',''],
                # https://dnschecker.org/credit-card-generator.php https://dnschecker.org/bin-checker.php
                # https://dnschecker.org/online-traceroute.php
        ];
    }

    function AT_getModelsInfo(): Array
    {
        # После миграции на PHP 8.x все сломалось и пришлось переписывать все с 0 руками.
        #  Костыльно, зато работает.

        # TODO: Оптимизировать выборку сразу до корня
        $pathsFromRoot = [];
        foreach(collect(File::allFiles(app_path())) as $file)
        {
            $path = $file->getRelativePathName();
            if( ! str_contains($path, '\\') ) # Файл НЕ в папке
                if( ! str_contains($path, ' ') ) # Это не мой тхт с комментом и тд
                    if( str_contains($path, '.php') ) # Это точно пхп
                        $pathsFromRoot []= str_replace('.php','',$path); # Сразу убераю расширение
        }

        $pathsValid = [];
        foreach ($pathsFromRoot as $className)
        {
            try { $reflection = new \ReflectionClass('App\\'.$className);
            } catch (ReflectionException $e) {  continue;  }

            if( ($reflection->isSubclassOf(Model::class) && !$reflection->isAbstract())  )
                $pathsValid []= 'App\\'.$className;
        }

        $modelsInfo = [];
        foreach($pathsValid as $path)
        {
            $modelName = explode('\\',$path)[1];
            $modelsInfo[$modelName]['NAME'] = $modelName;
            $modelsInfo[$modelName]['NAMESPACE'] = $path;

            $inst = new $path;
            $modelsInfo[$modelName]['DB_TABLE'] = $inst->getTable();

            try{
                $modelsInfo[$modelName]['DB_COUNT'] = $inst->count();
            }catch(\Exception $e){
                $modelsInfo[$modelName]['DB_COUNT'] = '=ОШИБКА='; // Если таблицы не существует.
            }
            $modelsInfo[$modelName]['DB_PK']     = $inst->getKeyName();
            $modelsInfo[$modelName]['DB_PK_TYPE'] = $inst->getKeyType();
        }

        return $modelsInfo;
    }
    function AT_echoFinalInfoAndDD($cmd)
    {
        echo "<style>  html { background: -webkit-linear-gradient(90deg,#bc69dc,#5d2df4); background: linear-gradient(90deg,#bc69dc,#5d2df4); } </style>";
        dump("Исполнено   =>   ".$cmd);
        dump("DB_Env <=> DB_Conn   ------>   ".env("DB_DATABASE").' <=> '.DB::connection()->getDatabaseName()."   ------>   ".((env("DB_DATABASE")===DB::connection()->getDatabaseName())?'GOOD':'!!!! BAD !!!!')); echo "<br><br><br><br>";
        dump(Artisan::output()); echo "<br><br><br><br>";

        dd('End');
    }
    function AT_composerDumpAutoload()
    {
        echo '<style> html,body {
        background: -webkit-linear-gradient(90deg,#bc69dc,#5d2df4);
        background:         linear-gradient(90deg,#bc69dc,#5d2df4);
        }</style>';

        set_time_limit(180);
        dump('Тайм лимит = 180сек');

        ignore_user_abort(false);
        dump('Юзер аборт отменен');

        # - ###

        $pathPhp = (new \Symfony\Component\Process\PhpExecutableFinder)->find(false); # ...modules\php\PHP_8.1\php.exe
        $pathPhar = realpath('../composer.phar');  # ...\composer.phar
        $pathWorkRoot = realpath('../'); # Корень проекта

        echo '<hr color="red">';
        dump($pathPhp,$pathPhar,$pathWorkRoot);
        echo '<hr color="red">';

        # - ###

        $command = array_merge([$pathPhp,$pathPhar], [ 'dump-autoload' , '--optimize' ] ); #
        # '--working-dir='.$pathWorkRoot


        dump('* Запускаю процесс *');
        dump('Команда ===> '.implode(' ',$command));
        dump('Рабочая папка ===> '.$pathWorkRoot);
        dump('Окружение ===> COMPOSER_HOME='.$pathWorkRoot);

        $proc = (new \Symfony\Component\Process\Process($command,$pathWorkRoot,['COMPOSER_HOME'=>$pathWorkRoot]))->setTimeout(null);
        $proc->enableOutput();
        $proc->run();
        #$proc->start();

        $proc->stop(); # В целом юзлес, но пусть будет

        echo '<hr color="red"><hr color="red"><hr color="red">';
        dump('Процесс - Отработал');

        dump('Ком Строка: '.$proc->getCommandLine());
        dump('Код выхода: '.$proc->getExitCodeText());

        dump($proc->getOutput());



        dd('Все');
    }

    # Единое место для всех настроек, паролей и тд.
    function AT_GetArrSettings()
    {
    	return [
    		'AT_VERSION' => '2023-08-08',
    		
		    'AT__PASS_NEED' => true,
		    'AT__PASS_TEXT' => '1243',
    		'' => '',
    		'DB_SLIV_PASS' => '123',
	    ];
    }

    Route::get('/artisan', function ()
    {
        # - ### ### ###
    	$arrSettings = AT_GetArrSettings();
        $AT_ModelsInfo = AT_getModelsInfo();
    	#dd($AT_ModelsInfo);
        # - ### ### ###

        try{ $allSessFilesCount = count( File::allFiles(storage_path('framework\sessions')) );
        }catch(\Exception $e){ $allSessFilesCount = 'Вылет'.$e->getMessage(); }

        # - ### ### ###

        echo '
			<title>Easy Artisan</title>
			<link rel="icon" type="image/png" sizes="32x32" href="https://laravel.com/img/favicon/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="16x16" href="https://laravel.com/img/favicon/favicon-16x16.png">
			<link rel="shortcut icon" href="https://laravel.com/img/favicon/favicon.ico">

			<style> html { '.AT_UI_getRandomBg().' }</style>
			<style>.box form { display:inline-block; }</style>
			<style>
			    button { font-size: 16px; padding: 12px; border-radius: 12px; border: 3px solid #4D3E96; transition: 0.3s; }
			    button:hover{  border-color: red;  }
			 </style>
			';

        # - ### ### ###

        if( $arrSettings['AT__PASS_NEED'] === true ) # NOTE: Именно тут, чтоб вывел фон и стили.
        {
            if( @$_GET['pass'] !== $arrSettings['AT__PASS_TEXT'] )
            {
                echo '<br><br><br><form method="get" action="/artisan"><input type="text"   name="pass" placeholder="Пароль" value=""><button type="submit">Отправить</button></form>';
                dd('Неверный пароль',$_GET,$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']);
            }
        }

        # - ### ### ###

        echo '
			<hr><h1>~ EasyArtisan ~ v'.$arrSettings['AT_VERSION'].' ~</h1><hr>
            <h2>Общая часть</h2>

            <div class="box">
				<form method="get" action="/artisan-migrate"        target="_blank">  <button type="submit">migrate</button></form>
				<form method="get" action="/artisan-migrate-status" target="_blank">  <button type="submit">migrate:status</button></form>
				<form method="get" action="/artisan-migrate-fresh"  target="_blank">  <button type="submit">migrate:fresh --seed</button></form>
			</div>
            <div class="box">
				<form method="get" action="/artisan-keygen"         target="_blank"> <button type="submit">key:generate</button></form>
				<form method="get" action="/artisan-optimize-clear" target="_blank"> <button type="submit">optimize:clear</button></form>
				<form method="get" action="/artisan-del-sess-files" target="_blank"> <button type="submit">Удалить файлы сессий ('.$allSessFilesCount.'шт)</button></form>
			</div>
            <div class="box">
				<form method="get" action="/artisan-route-list"   target="_blank">   <button type="submit">route:list</button></form>
				<form method="get" action="/artisan-route-list-2" target="_blank">   <button type="submit">route:list --compact</button></form>
			</div>
            <div class="box">
				<form method="get" action="/composer-dump" target="_blank">  <button type="submit">[ composer dump-autoload --optimize ]</button></form>
			</div>
            <div class="box">
                Easy SSL:
				<form method="get" action="/easy-ssl/1/clearTbl" target="_blank">  <button type="submit">(1) Clear TBL</button></form>
				<form method="get" action="/easy-ssl/2/makeSslKey" target="_blank">  <button type="submit">(2) Make SSL Key</button></form>
				<form method="get" action="/easy-ssl/3/moveFiles" target="_blank">  <button type="submit">(3) Move Files</button></form>
				<form method="get" action="/easy-ssl/4/delStorageLeFolder" target="_blank">  <button type="submit">(4) Del Stor LE Folder</button></form>
				<form method="get" action="/easy-ssl/5/copyVhostToRoot" target="_blank">  <button type="submit">(5) Copy Vhost To Root</button></form>
				<form method="get" action="/easy-ssl/6/delVhostFromRoot" target="_blank">  <button type="submit">(6*) Del Vhost From Root</button></form>
				<form method="get" action="/easy-ssl/7/delSSL" target="_blank">  <button type="submit">(7*) Del SSL</button></form>
			</div>
		';

        # - ### ### ###

        echo '<hr><h2>Работа с БД</h2>';

        try { DB::connection()->getPdo(); DB::connection()->getDatabaseName();
        } catch (\Exception $e) { dump('Нет подключения к СУБД или БД',$e, DB::connection()->getConfig()); return; }

        # - ### ### ###

        $dbConfig = DB::connection()->getConfig();
        dump("Конфиг БД:  ".$dbConfig['host'].':'.$dbConfig['port'].'  ->  '.
            $dbConfig['database'].'@'.$dbConfig['username'].'  ->  '.'Префикс: '.$dbConfig['prefix'] );

        # - ### ### ###
	
	    dump(implode(' => ',[
	    'SERVER' , ($_SERVER['HTTP_HOST'  ] ?? 'UNDEF'),($_SERVER['SERVER_ADDR'] ?? 'UNDEF').' : '.($_SERVER['SERVER_PORT'] ?? 'UNDEF'),
	    ]));
	    
        # - ### ### ###

        echo '<h3>Чистка таблиц</h3>';
        echo '<div class="box">';
        echo '
                <form method="GET" action="/artisan-tbl-clear" target="_blank">
                    <input type="text"   name="target" placeholder="Имя без префикса" value="">
                    <button type="submit">Очистить</button>
                </form> | <===> | ';
        foreach($AT_ModelsInfo as $key=> $val)
        {
            echo '
                <form method="GET" action="/artisan-tbl-clear" target="_blank">
                    <input type="hidden"   name="target"  value="'.$val['DB_TABLE'].'">
                    <button type="submit">'.$val['DB_TABLE'].' ('.$val['DB_COUNT'].')'.'</button>
                </form> ||| ';
        }
        echo '</div>';

        # - ### ### ###

        echo '<hr><h3>Слив всей БД в JSON</h3>
            <div class="box">
                <form method="GET" action="/artisan-sliv" target="_blank">
                    <input type="text"   name="pass" placeholder="Пароль"  value="">
                    <button type="submit">Скачать</button>
                </form>
             </div>';

        # - ### ### ###

        echo '<hr><h3>Быстрый скан доступности сервера</h3>
            <h4>3389-RDP | 80-HTTP | 443-HTTPS | 21-FTP | 3306-MySQL</h4>
            <div class="box">
                <form method="GET" action="/artisan-alifer" target="_blank">
                    <input type="text"   name="host" placeholder="ip или домен"  value="">
                    <input type="text"   name="port" placeholder="Один порт"  value="3389">
                    <button type="submit">Проверить</button>
                </form>
             </div>';

        echo '<hr>';

        # - ### ### ###

        echo '<h3>Файлы логов ошибок и вылетов</h3>';
        $allLogFiles = File::allFiles(storage_path('logs'));
        #dd($allLogFiles);
        echo '<div class="box"> Скачать: ==> ';
        foreach($allLogFiles as $oneFile)
        {
            if( $oneFile->isFile() )
            {
                if( $oneFile->getRelativePath() !== '' ) continue; # Скип логов в подпапках.
                $size = floor($oneFile->getSize() / 1024);
                $name = $oneFile->getFilename();
                $nameFull = "{$name} (~{$size}Кб)";
                echo '<form method="GET" action="/artisan-download-one-log-file/'.$name.'" target="_blank">
                            <button type="submit">'.$nameFull.'</button>
                        </form> <=> ';
            }
        }
        echo '</div>';
        echo '<div class="box"> Удалить: ==> ';
        foreach($allLogFiles as $oneFile)
        {
            if( $oneFile->isFile() )
            {
                if( $oneFile->getRelativePath() !== '' ) continue; # Скип логов в подпапках.
                $size = floor($oneFile->getSize() / 1024);
                $name = $oneFile->getFilename();
                $nameFull = "{$name} (~{$size}Кб)";
                echo '<form method="GET" action="/artisan-delete-one-log-file/'.$name.'" target="_blank">
                            <button type="submit">'.$nameFull.'</button>
                        </form> <=> ';
            }
        }
        echo '</div>';

        # - ### ### ###

        echo '<hr><h3>Быстрый Telegram</h3>
            <div class="box">
                <form method="GET" action="/artisan-telegram" target="_blank">
                    <input type="text"   name="token" placeholder="Токен"  value="">
                    <input type="text"   name="chat" placeholder="Чат"  value="">
                    <input type="text"   name="msg" placeholder="Сообщение"  value="">
                    <button type="submit">Отправить</button>
                </form>
             </div>';

        # - ### ### ###

        echo '<hr><h3>Быстрые ссылки</h3>';
        # TODO: Добавить в массив подключи для каждоый ссылки - выводимое название + цвет.   если массив, то чекаю иначе туп овывод.

        foreach( AT_UI_getArrMyUrls() as $key=>$val )
        {
            echo '<div class="box">'.$key.': ==> ';
            foreach($val as $url)
            {
                if( is_array($url) )
                {
                    $text = $url[1];
                    $url = $url[0]; # Именно такой порядок
                }
                else
                    $text = $url;

                echo '<form method="get" action="'.$url.'" target="_blank"><button type="submit">'.str_replace('https://','',$text).'</button></form>';
            }
            echo '</div>';
        }
        echo "Сделать плитку как тут = https://webbrowsertools.com/";



    }  );

    Route::get('/artisan-migrate',        function () { Artisan::call('migrate');          AT_echoFinalInfoAndDD('migrate');  } );
    Route::get('/artisan-migrate-fresh',  function () { Artisan::call('migrate:fresh', ['--seed' => true]);  AT_echoFinalInfoAndDD('migrate:fresh --seed');    } );
    Route::get('/artisan-migrate-status', function () { Artisan::call('migrate:status');   AT_echoFinalInfoAndDD('migrate:status');  } );
    Route::get('/artisan-optimize-clear', function () { Artisan::call('optimize:clear');   AT_echoFinalInfoAndDD('optimize:clear');  } );
    Route::get('/artisan-keygen',         function () { Artisan::call('key:generate');     AT_echoFinalInfoAndDD('key:generate');    } );
    Route::get('/artisan-route-list',     function () { Artisan::call('route:list');       AT_echoFinalInfoAndDD('route:list');      } );
    Route::get('/artisan-route-list-2',   function () { Artisan::call('route:list', ['--compact' => true]);   AT_echoFinalInfoAndDD('route:list --compact');   } );
    Route::get('/artisan-composer-dump',     function () { AT_composerDumpAutoload(); } );

    Route::get('/artisan-sliv',function()
    {
        $pass = @$_GET['pass'];
        if($pass !== AT_GetArrSettings()['DB_SLIV_PASS'])
            dd('Неверный пароль',@$_GET['pass']);

        $contents = '';
        $contents .= PHP_EOL;

        foreach(AT_getModelsInfo() as $key=> $val)
        {
            $contents .= 'Модель: '.$val['NAME'].PHP_EOL;
            $contents .= 'Таблица: '.$val['DB_TABLE'].PHP_EOL;
            $contents .= 'Строк: '.$val['DB_COUNT'].PHP_EOL;

            $inst = new $val['NAMESPACE'];
            $json = json_encode($inst::all()->toArray());
            $contents .= 'Длина JSON: '.strlen($json).PHP_EOL;
            $contents .= $json;
            $contents .= PHP_EOL.PHP_EOL.PHP_EOL;
        }
        $contents .= PHP_EOL.'End';

        #$filename .= '='.$_SERVER['HTTP_HOST']; # $_SERVER['SERVER_NAME']
        $filename = '';
        $filename .= date("Y-m-d H.i");
        $filename .= ' = '.DB::connection()->getDatabaseName();
        $filename .= ' = JSON.txt';
        # 2022-01-29 21.53 = rpc_main = JSON.txt

        return response()->streamDownload(function () use ($contents) {
            echo $contents;
        }, $filename);
    } );
    Route::get('/artisan-tbl-clear',function()
    {
        try{
            $table  = @$_GET['target']; # БЕЗ префикса таблицы
            dump($table);

            DB::table($table)->delete(); # Только удалит записи.
            #Schema::drop($table->Tables_in_DbName);

        }catch(\Exception $e){ dd('Вылет', $e->getMessage(), $e); }

        dd('Успех', 'Таблица ' . $table . ' Просто очищена');
    });
    Route::get('/artisan-alifer',function()
    {
        $host  = $_GET['host'];
        $port  = $_GET['port'];

        function tryConnect($host,$port)
        {
            $waitTimeoutInSeconds = 1;

            try
            {
                if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds))
                {
                    if($fp) // Только если смогли открыть
                        fclose($fp);
                    return true;
                }
                else
                {
                    $errStr=iconv("windows-1251","utf-8",$errStr); # Иначе месиво
                    dump('Код ошибки: '.$errCode,$errStr);
                    return false;
                }
            }catch(Exception $e){
                return false;
            }

        }

        dump($host.':'.$port);

        if( tryConnect($host,$port) )
            dd('Success');
        else
            dd('Fail');
    });
    Route::get('/artisan-del-sess-files',function()
    {
        try{
            $allSessFiles = File::allFiles(storage_path('framework\sessions'));
            dump('Всего файлов найдено: '.count($allSessFiles));

            if(count($allSessFiles) === 0) dd('Не нашли файлов');

            foreach($allSessFiles as $oneFile)
            {
                if( $oneFile->isFile() )
                    if($oneFile->getExtension() === '')
                    {
                        $fullPath = $oneFile->getRealPath();
                        File::delete($fullPath);
                        dump('Удален файл сессии: '.$fullPath);
                    }
            }

        }catch(\Exception $e){ dd('Вылет', $e->getMessage(), $e); }

        dd($allSessFiles,'End');
    });
    Route::get('/artisan-telegram',function()
    {
        try{
            $token = $_GET['token'];
            $chatId = $_GET['chat'];
            $message = $_GET['msg'];

            $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatId;
            $url = $url . "&text=" . urlencode($message);
            $url = $url . "&parse_mode=html"; # Что бы работало форматирование через html-теги

            $ch = curl_init();

            $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
            );
            curl_setopt_array($ch, $optArray);

            $result = curl_exec($ch);
            curl_close($ch);

            dump($url);
            dump(json_decode($result, true));

        }catch(\Exception $e){ dd('Вылет', $e->getMessage(), $e); }

        dd('End');
    });

    Route::get('/artisan-download-one-log-file/{filename}',function($filename)
    {
        try{
            $allLogFiles = File::allFiles(storage_path('logs'));
            if(count($allLogFiles) === 0) dd('Не нашли файлов');

            foreach($allLogFiles as $oneFile)
            {
                if( $oneFile->isFile() )
                    if($oneFile->getFilename() === $filename)
                        return response()->download($oneFile,$filename);
            }

        }catch(\Exception $e){ dd('Вылет', $e->getMessage(), $e); }

        dd($allLogFiles,'End');
    });
    Route::get('/artisan-delete-one-log-file/{filename}',function($filename)
    {
        try{
            $allLogFiles = File::allFiles(storage_path('logs'));
            if(count($allLogFiles) === 0) dd('Не нашли файлов');

            foreach($allLogFiles as $oneFile)
            {
                if( $oneFile->isFile() )
                    if($oneFile->getFilename() === $filename)
                    {
                        $path = $oneFile->getRealPath();
                        File::delete($path);
                        dump('Удален файл: '.$path );
                        break;
                    }
            }

        }catch(\Exception $e){ dd('Вылет', $e->getMessage(), $e); }

        dd($allLogFiles,'End');
    });

    # - ###
