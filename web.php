<?php

    /* composer dump-autoload
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */

    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Schema;

    use Illuminate\Container\Container;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\File;

	# ####
    # /*

    function getModelsInfo(): Array
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $class = sprintf('\%s%s',
                    Container::getInstance()->getNamespace(),
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));

                return $class;
            })
            ->filter(function ($class) {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }

                return $valid;
            });

        $result = $models->values()->toArray();

        $modelsInfo = [];
        foreach($result as $path)
        {
            $modelName = explode('\\',$path)[2];
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

    Route::get('/artisan', function ()
    {
        $version = '2022-05-06';

		try{ $allSessFilesCount = count( File::allFiles(storage_path('framework\sessions')) );
			}catch(\Exception $e){ $allSessFilesCount = 'Вылет'.$e->getMessage(); }
		
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

        echo '
			<title>Easy Artisan</title>
			<link rel="icon" type="image/png" sizes="32x32" href="https://laravel.com/img/favicon/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="16x16" href="https://laravel.com/img/favicon/favicon-16x16.png">
			<link rel="shortcut icon" href="https://laravel.com/img/favicon/favicon.ico">

			<style> html { '.$bg[ random_int(0,count($bg)-1) ].' }</style>
			<style>.box form { display:inline-block; }</style>
			<style> button { font-size: 16px; padding: 12px; border-radius: 12px; border: 2px solid #4D3E96; }</style>
			';
			
        echo '
			<hr><h1>~ EasyArtisan ~ v'.$version.' ~</h1><hr>
            <h2>Общая часть</h2>

            <div class="box">
				<form method="get" action="/artisan-migrate-fresh"  target="_blank">  <button type="submit">migrate:fresh --seed</button></form>
				<form method="get" action="/artisan-migrate"        target="_blank">  <button type="submit">migrate</button></form>
				<form method="get" action="/artisan-migrate-status" target="_blank">  <button type="submit">migrate:status</button></form>
			</div>

            <div class="box">
				<form method="get" action="/artisan-optimize-clear" target="_blank"> <button type="submit">optimize:clear</button></form>
				<form method="get" action="/artisan-keygen"         target="_blank"> <button type="submit">key:generate</button></form>
				<form method="get" action="/artisan-del-sess-files" target="_blank"> <button type="submit">Удалить файлы сессий ('.$allSessFilesCount.'шт)</button></form>
			</div>

            <div class="box">
				<form method="get" action="/artisan-route-list"   target="_blank">   <button type="submit">route:list</button></form>
				<form method="get" action="/artisan-route-list-2" target="_blank">   <button type="submit">route:list --compact</button></form>
			</div>
		';

        echo '<hr><h2>Работа с БД</h2>';

        try { DB::connection()->getPdo(); DB::connection()->getDatabaseName();
        } catch (\Exception $e) { dump('Нет подключения к СУБД или БД',$e, DB::connection()->getConfig()); return; }

        $dbConfig = DB::connection()->getConfig();
        dump("Конфиг БД:  ".$dbConfig['host'].':'.$dbConfig['port'].'  ->  '.
            $dbConfig['database'].'@'.$dbConfig['username'].'  ->  '.'Префикс: '.$dbConfig['prefix'] );

        echo '<h3>Чистка таблиц</h3>';
        echo '<div class="box">';
        echo '
                <form method="GET" action="/artisan-tbl-clear" target="_blank">
                    <input type="text"   name="target" placeholder="Имя без префикса" value="">
                    <button type="submit">Очистить</button>
                </form> | <===> | ';
        foreach(getModelsInfo() as $key=>$val)
        {
            echo '
                <form method="GET" action="/artisan-tbl-clear" target="_blank">
                    <input type="hidden"   name="target"  value="'.$val['DB_TABLE'].'">
                    <button type="submit">'.$val['DB_TABLE'].' ('.$val['DB_COUNT'].')'.'</button>
                </form> ||| ';
        }
        echo '</div>';

        echo '<hr><h3>Слив всей БД в JSON</h3>
            <div class="box">
                <form method="GET" action="/artisan-sliv" target="_blank">
                    <input type="text"   name="pass" placeholder="Пароль"  value="">
                    <button type="submit">Скачать</button>
                </form>
             </div>';

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

        $allLogFiles = File::allFiles(storage_path('logs'));
        echo '<h3>Файлы логов ошибок и вылетов</h3>';

        echo '<div class="box"> Скачать: ==> ';
        foreach($allLogFiles as $oneFile)
        {
            if( $oneFile->isFile() )
            {
                $size = floor($oneFile->getSize() / 1024);
				$name = $oneFile->getFilename();
				$nameFull = $name . ' (~' . $size . 'Кб)';
                echo '<form method="GET" action="/artisan-download-one-log-file/'.$name.'" target="_blank">
                            <button type="submit">'.$nameFull.'</button>
                        </form> <===> ';
            }
        }
        echo '</div>';
        echo '<div class="box"> Удалить: ==> ';
        foreach($allLogFiles as $oneFile)
        {
            if( $oneFile->isFile() )
            {
				$size = floor($oneFile->getSize() / 1024);
				$name = $oneFile->getFilename();
				$nameFull = $name . ' (~' . $size . 'Кб)';
                echo '<form method="GET" action="/artisan-delete-one-log-file/'.$name.'" target="_blank">
                            <button type="submit">'.$nameFull.'</button>
                        </form> <===> ';
            }
        }
        echo '</div>';
    
        echo '<hr><h3>Быстрый Telegram</h3>
            <div class="box">
                <form method="GET" action="/artisan-telegram" target="_blank">
                    <input type="text"   name="token" placeholder="Токен"  value="">
                    <input type="text"   name="chat" placeholder="Чат"  value="">
                    <input type="text"   name="msg" placeholder="Сообщение"  value="">
                    <button type="submit">Отправить</button>
                </form>
             </div>';
        
        
    }  );

    Route::get('/artisan-migrate',        function () { Artisan::call('migrate');                           echo "Исполнено => migrate";              dd(Artisan::output());  } );
    Route::get('/artisan-migrate-fresh',  function () { Artisan::call('migrate:fresh', ['--seed' => true]); echo "Исполнено => migrate:fresh --seed"; dd(Artisan::output());  } );
    Route::get('/artisan-migrate-status', function () { Artisan::call('migrate:status');                    echo "Исполнено => migrate:status";       dd(Artisan::output());  } );
    Route::get('/artisan-optimize-clear', function () { Artisan::call('optimize:clear');                    echo "Исполнено => optimize:clear";       dd(Artisan::output());  } );
    Route::get('/artisan-keygen',         function () { Artisan::call('key:generate');                      echo "Исполнено => key:generate";         dd(Artisan::output());  } );
    Route::get('/artisan-route-list',     function () { Artisan::call('route:list');                        echo "Исполнено => route:list";           dd(Artisan::output());  } );
    Route::get('/artisan-route-list-2',   function () { Artisan::call('route:list', ['--compact' => true]); echo "Исполнено => route:list --compact"; dd(Artisan::output());  } );

    Route::get('/artisan-sliv',function()
    {
        $pass = @$_GET['pass'];
        if($pass !== '123')
            dd('Неверный пароль',@$_GET['pass']);

        $contents = '';
        $contents .= PHP_EOL;

        foreach(getModelsInfo() as $key=>$val)
        {
            $contents .= 'Модель: '.$val['NAME'].PHP_EOL;
            $contents .= 'Таблица: '.$val['DB_TABLE'].PHP_EOL;
            $contents .= 'Строк: '.$val['DB_COUNT'].PHP_EOL;

            $inst = new $val['NAMESPACE'];
            $json = json_encode($inst::all()->toArray());
            $contents .= 'Длина JSON: '.$val['DB_COUNT'].PHP_EOL;
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

    # */
	# ####

    #######
    # End
