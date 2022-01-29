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
	
    Route::get('/artisan', function () { echo ' <br>
			<hr>
			<h1>EasyArtisan</h1>
			<style>.box form { display:inline-block; }</style>
			<style>button { font-size: 16px; padding: 12px; border-radius: 12px; border: 2px solid #4CAF50; /* Green */ }</style>
            <div class="box">
				<form method="get" action="/artisan-migrate-fresh">  <button type="submit">migrate:fresh --seed</button></form>
				<form method="get" action="/artisan-migrate">  <button type="submit">migrate</button></form>
			</div>
			
            <div class="box">
				<form method="get" action="/artisan-optimize-clear"> <button type="submit">optimize:clear</button></form>
				<form method="get" action="/artisan-keygen">         <button type="submit">key:generate</button></form>
			</div>
			<hr>
            <div class="box">
				<form method="get" action="/artisan-route-list">     <button type="submit">route:list</button></form>
				<form method="get" action="/artisan-route-list-2">   <button type="submit">route:list --compact</button></form>
			</div>
			<hr>
			
            <span>Миграции</span>
			<hr>
		';  }  );
		
    Route::get('/artisan-migrate',        function () { Artisan::call('migrate');                           echo "Исполнено => migrate"; dd(Artisan::output());  } );
    Route::get('/artisan-migrate-fresh',  function () { Artisan::call('migrate:fresh', ['--seed' => true]); echo "Исполнено => migrate:fresh --seed"; dd(Artisan::output());  } );
    Route::get('/artisan-optimize-clear', function () { Artisan::call('optimize:clear');                    echo "Исполнено => optimize:clear";       dd(Artisan::output());  } );
    Route::get('/artisan-route-list',     function () { Artisan::call('route:list');                        echo "Исполнено => route:list";           dd(Artisan::output());  } );
    Route::get('/artisan-route-list-2',   function () { Artisan::call('route:list', ['--compact' => true]); echo "Исполнено => route:list --compact"; dd(Artisan::output());  } );
    Route::get('/artisan-keygen',         function () { Artisan::call('key:generate');                      echo "Исполнено => key:generate";         dd(Artisan::output());  } );
    
	# */

    #######
    # End
