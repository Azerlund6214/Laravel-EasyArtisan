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
	
    Route::get('/artisan', function () { echo ' <br><hr><h1>EasyArtisan<h1>
            <form method="get" action="/artisan-migrate-fresh">  <button type="submit">migrate:fresh --seed</button></form>
            <form method="get" action="/artisan-optimize-clear"> <button type="submit">optimize:clear</button></form>  <hr>
            <form method="get" action="/artisan-route-list">     <button type="submit">route:list</button></form>
            <form method="get" action="/artisan-route-list-2">   <button type="submit">route:list --compact</button></form>
            <form method="get" action="/artisan-keygen">         <button type="submit">key:generate</button></form>
        <hr>';  }  );
		
    Route::get('/artisan-migrate-fresh',  function () { Artisan::call('migrate:fresh', ['--seed' => true]); echo "Исполнено => migrate:fresh --seed"; dd(Artisan::output());  } );
    Route::get('/artisan-optimize-clear', function () { Artisan::call('optimize:clear');                    echo "Исполнено => optimize:clear";       dd(Artisan::output());  } );
    Route::get('/artisan-route-list',     function () { Artisan::call('route:list');                        echo "Исполнено => route:list";           dd(Artisan::output());  } );
    Route::get('/artisan-route-list-2',   function () { Artisan::call('route:list', ['--compact' => true]); echo "Исполнено => route:list --compact"; dd(Artisan::output());  } );
    Route::get('/artisan-keygen',         function () { Artisan::call('key:generate');                      echo "Исполнено => key:generate";         dd(Artisan::output());  } );
    
	# */

    #######
    # End
