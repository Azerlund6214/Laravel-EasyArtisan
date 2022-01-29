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
	
    Route::get('/artisan', function ()
	{
		
		
		
		
		
		
		echo ' <br>
			<hr>
			<h1>~ EasyArtisan ~</h1>
			<hr>
            <h2>Общая часть</h2>
			<style>.box form { display:inline-block; }</style>
			<style>button { font-size: 16px; padding: 12px; border-radius: 12px; border: 2px solid #4CAF50; /* Green */ }</style>
            <div class="box">
				<form method="get" action="/artisan-migrate-fresh" target="_blank">  <button type="submit">migrate:fresh --seed</button></form>
				<form method="get" action="/artisan-migrate" target="_blank">  <button type="submit">migrate</button></form>
			</div>
			
            <div class="box">
				<form method="get" action="/artisan-optimize-clear" target="_blank"> <button type="submit">optimize:clear</button></form>
				<form method="get" action="/artisan-keygen" target="_blank">         <button type="submit">key:generate</button></form>
			</div>
			
            <div class="box"><br>
				<form method="get" action="/artisan-route-list" target="_blank">     <button type="submit">route:list</button></form>
				<form method="get" action="/artisan-route-list-2" target="_blank">   <button type="submit">route:list --compact</button></form>
			</div>
			<hr>
			
			<hr>
		';
		
		function getModels(): Array
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

			return $models->values()->toArray();
		}
		
		
		$modelsInfo = [];
		foreach(getModels() as $path)
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
		
		dd($modelsInfo);
		
		}  );
		
    Route::get('/artisan-migrate',        function () { Artisan::call('migrate');                           echo "Исполнено => migrate"; dd(Artisan::output());  } );
    Route::get('/artisan-migrate-fresh',  function () { Artisan::call('migrate:fresh', ['--seed' => true]); echo "Исполнено => migrate:fresh --seed"; dd(Artisan::output());  } );
    Route::get('/artisan-optimize-clear', function () { Artisan::call('optimize:clear');                    echo "Исполнено => optimize:clear";       dd(Artisan::output());  } );
    Route::get('/artisan-route-list',     function () { Artisan::call('route:list');                        echo "Исполнено => route:list";           dd(Artisan::output());  } );
    Route::get('/artisan-route-list-2',   function () { Artisan::call('route:list', ['--compact' => true]); echo "Исполнено => route:list --compact"; dd(Artisan::output());  } );
    Route::get('/artisan-keygen',         function () { Artisan::call('key:generate');                      echo "Исполнено => key:generate";         dd(Artisan::output());  } );
    
	# */

    #######
    # End
