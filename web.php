<?php

    /* composer dump-autoload
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */

    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Schema;


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
            $modelsInfo[$modelName]['DB_COUNT'] = $inst->count();
            $modelsInfo[$modelName]['DB_PK']     = $inst->getKeyName();
            $modelsInfo[$modelName]['DB_PK_TYPE'] = $inst->getKeyType();
        }

        return $modelsInfo;
    }

    Route::get('/artisan', function ()
	{

		echo '
			<title>Easy Artisan</title>
			<link rel="icon" type="image/png" sizes="32x32" href="https://laravel.com/img/favicon/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="16x16" href="https://laravel.com/img/favicon/favicon-16x16.png">
			<link rel="shortcut icon" href="https://laravel.com/img/favicon/favicon.ico">

			<style>.box form { display:inline-block; }</style>
			<style>button { font-size: 16px; padding: 12px; border-radius: 12px; border: 2px solid #4CAF50; /* Green */ }</style>
			';

		echo '
			<br>
			<hr><h1>~ EasyArtisan ~</h1><hr>
            <h2>Общая часть</h2>

            <div class="box">
				<form method="get" action="/artisan-migrate-fresh" target="_blank">  <button type="submit">migrate:fresh --seed</button></form>
				<form method="get" action="/artisan-migrate" target="_blank">  <button type="submit">migrate</button></form>
				<form method="get" action="/artisan-migrate-status" target="_blank">  <button type="submit">migrate:status</button></form>
			</div>

            <div class="box">
				<form method="get" action="/artisan-optimize-clear" target="_blank"> <button type="submit">optimize:clear</button></form>
				<form method="get" action="/artisan-keygen" target="_blank">         <button type="submit">key:generate</button></form>
			</div>

            <div class="box">
				<form method="get" action="/artisan-route-list" target="_blank">     <button type="submit">route:list</button></form>
				<form method="get" action="/artisan-route-list-2" target="_blank">   <button type="submit">route:list --compact</button></form>
			</div>
		';

		echo '<hr><h2>Работа с БД</h2>';

		try { DB::connection()->getPdo(); DB::connection()->getDatabaseName();
        } catch (\Exception $e) { dump('Нет подключения к СУБД или БД',$e, DB::connection()->getConfig()); return; }

		$dbConfig = DB::connection()->getConfig();
		dump("Конфиг БД: ".$dbConfig['host'].':'.$dbConfig['port'].' -> '.
                $dbConfig['database'].'@'.$dbConfig['username'].' -> '.'Префикс: '.$dbConfig['prefix'] );


		//dd($dbConfig);
		//dd(123);


		$modelsInfo = getModelsInfo();

        echo '<hr><h3>Слив всей БД в JSON</h3>
            <div class="box">
                <form method="GET" action="/artisan-sliv" target="_blank">
                    <input type="text"   name="pass" placeholder="Пароль"  value="">
                    <button type="submit">Скачать</button>
                </form>
             </div>';




		dd($modelsInfo);

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


    # */

    #######
    # End
