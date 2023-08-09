<?php

    # - ### ### ### ###
    #   **/ EasySSL \**

    Route::get('/.well-known/acme-challenge/{token}', function (string $token) { return \Illuminate\Support\Facades\Storage::get('public/.well-known/acme-challenge/' . $token); });
    #Route::get('/easy-ssl/1/clearTbl', function (){   foreach(\Daanra\LaravelLetsEncrypt\Models\LetsEncryptCertificate::all() as $row){ dump($row); $row->delete(); $row->save(); }  dump('Все строки удалены');  });
    Route::get('/easy-ssl/1/clearTbl', function (){   DB::table('lets_encrypt_certificates')->truncate();  dump('Все строки удалены');  });
    Route::get('/easy-ssl/2/makeSslKey', function (){  $d=request()->getHost();  dump(\Daanra\LaravelLetsEncrypt\Facades\LetsEncrypt::create($d) ); dump($d,'done'); });
    Route::get('/easy-ssl/3/moveFiles', function ()
    {
        # 4 файла
        $patchesArr = glob(storage_path('app\\letsencrypt\\certificates\\'.request()->getHost().'\\*.pem'));

        foreach( $patchesArr as $one )
        {
            File::copy($one ,base_path('SSL_LE\\').last(explode('\\',$one)));
	        dump('Скопирован файл - '.$one);
        }
    });
    Route::get('/easy-ssl/4/delStorageLeFolder', function (){  File::deleteDirectory(storage_path('app\\letsencrypt')); dump('done'); });
    Route::get('/easy-ssl/5/copyVhostToRoot', function (){  File::copy(base_path('SSL_LE\\Apache_2.4-PHP_8.0-8.1_vhost.conf') ,base_path('Apache_2.4-PHP_8.0-8.1_vhost.conf') ); dump('done','Теперь надо просто перезапуск серва. (В трее)'); });
    Route::get('/easy-ssl/6/delVhostFromRoot', function (){  File::delete(base_path('Apache_2.4-PHP_8.0-8.1_vhost.conf') ); dump('done'); });
    Route::get('/easy-ssl/7/delSSL', function (){  File::delete(glob(base_path('SSL_LE\\*.pem'))); dump('done'); });
    #   https://github.com/Daanra/laravel-lets-encrypt
	#   composer - добавить в require => "daanra/laravel-lets-encrypt": "^0.5.2",
    #   !!! В конфиге убирать staging = https://acme- staging -v02.api.letsencrypt.org/directory   это тестовые SSL.  2 часа убил
    #   Все проверено и работает в продакшене.

    # - ###
