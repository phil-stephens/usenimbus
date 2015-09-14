<?php

Route::get('/', [
    'as'    => 'homepage',
    'uses'  => 'PagesController@index',
    'middleware'    => 'guest'
]);

Route::get('/terms-and-conditions', [
    'as'    => 'terms_path',
    'uses'  => 'PagesController@terms'
]);

Route::get('/privacy-policy', [
    'as'    => 'privacy_path',
    'uses'  => 'PagesController@privacy'
]);

// Registration
Route::get('register', [
    'as'	        => 'register_path',
    'uses'	        => 'RegistrationController@create',
    'middleware'    => 'guest'
]);

Route::post('register', [
    'as'	        => 'register_path',
    'uses'	        => 'RegistrationController@store',
    'middleware'    => 'guest'
]);

Route::get('/unverified', [
    'as'            => 'unverified_path',
    'uses'          => 'RegistrationController@unverified',
    'middleware'    => 'auth'
]);

Route::post('/verify/send', [
    'as'            => 'send_verification_path',
    'uses'          => 'RegistrationController@sendVerification',
    'middleware'    => 'auth'
]);

Route::get('/verify/{verificationCode}', [
    'as'        => 'verification_path',
    'uses'      => 'RegistrationController@verify'
]);

// Oauth
Route::get('oauth/{provider}/redirect', [
    'as'        => 'oauth_redirect_path',
    'uses'      => 'Oauth\RegistrationAndLoginController@redirectToProvider'
]);

Route::get('oauth/{provider}/callback', [
    'as'        => 'oauth_callback_path',
    'uses'      => 'Oauth\RegistrationAndLoginController@handleProviderCallback'
]);

// Sessions
Route::get('login', [
    'as'	        => 'login_path',
    'uses'	        => 'SessionsController@create',
    'middleware'    => 'guest'
]);

Route::post('login', [
    'as'	        => 'login_path',
    'uses'	        => 'SessionsController@store',
    'middleware'    => 'guest'
]);

Route::get('logout', [
    'as'            => 'logout_path',
    'uses'          => 'SessionsController@destroy'
]);

Route::controller('password', 'PasswordController');

// User
Route::get('account', [
    'as'    => 'edit_user_path',
    'uses'  => 'UsersController@edit',
    'middleware'    => 'auth'
]);

Route::post('account', [
    'as'    => 'edit_user_path',
    'uses'  => 'UsersController@update',
    'middleware'    => 'auth'
]);

Route::delete('account', [
    'as'    => 'destroy_user_path',
    'uses'  => 'UsersController@destroy',
    'middleware'    => 'auth'
]);

// Droplets
Route::get('droplets', [
    'as'    => 'droplets_path',
    'uses'  => 'DropletsController@index',
    'middleware'    => 'auth'
]);

Route::get('droplet/create', [
    'as'    => 'create_droplet_path',
    'uses'  => 'DropletsController@create',
    'middleware'    => 'auth'
]);

Route::get('d/{slug}', [
    'as'    => 'droplet_path',
    'uses'  => 'DropletsController@show'
]);

Route::post('d/{slug}', [
    'as'    => 'droplet_path',
    'uses'  => 'DropletsController@handleAuth'
]);

Route::get('droplet/new/{uploadHash}', [
    'as'    => 'droplet_created_path',
    'uses'  => 'DropletsController@created'
]);

Route::get('droplet/{dropletId}', [
    'as'    => 'droplet_files_path',
    'uses'  => 'DropletsController@files'
]);

Route::delete('droplet/{dropletId}', [
    'as'    => 'destroy_droplet_path',
    'uses'  => 'DropletsController@destroy'
]);

Route::get('droplet/{dropletId}/edit', [
    'as'    => 'edit_droplet_path',
    'uses'  => 'DropletsController@edit'
]);

Route::post('droplet/{dropletId}/edit', [
    'as'    => 'edit_droplet_path',
    'uses'  => 'DropletsController@update'
]);

Route::get('droplet/{dropletId}/security', [
    'as'    => 'droplet_security_path',
    'uses'  => 'DropletsController@security'
]);

Route::post('droplet/{dropletId}/security', [
    'as'    => 'droplet_security_path',
    'uses'  => 'DropletsController@updateSecurity'
]);

Route::get('droplet/{dropletId}/share', [
    'as'    => 'droplet_share_path',
    'uses'  => 'DropletsController@share'
]);

Route::post('droplet/{dropletId}/share', [
    'as'    => 'droplet_share_path',
    'uses'  => 'DropletsController@handleShare'
]);

// Files
Route::post('file', [
    'as'    => 'file_path',
    'uses'  => 'FilesController@store',
    'middleware'    => 'auth'
]);

Route::get('file/download/{crypt}', [
    'as'    => 'download_file_path',
    'uses'  => 'FilesController@download'
]);

Route::delete('file/{dropletId}/{fileId}', [
    'as'    => 'destroy_file_path',
    'uses'  => 'FilesController@destroy'
]);


// Storage
Route::get('storage', [
    'as'    => 'storage_path',
    'uses'  => 'StoragesController@index',
    'middleware'    => 'auth'
]);

Route::get('storage/oauth/dropbox',[
    'as'    => 'dropbox_oauth_path',
    'uses'  => 'Oauth\StorageController@dropbox'
]);

Route::get('storage/oauth/copy',[
    'as'    => 'copy_oauth_path',
    'uses'  => 'Oauth\StorageController@copy'
]);

Route::get('storage/s3',[
    'as'    => 's3_path',
    'uses'  => 'StoragesController@s3'
]);

Route::post('storage/s3',[
    'as'    => 's3_path',
    'uses'  => 'StoragesController@handleS3'
]);

Route::delete('storage/{storageId}', [
    'as'    => 'destroy_storage_path',
    'uses'  => 'StoragesController@destroy',
    'middleware'    => 'auth'
]);



Route::get('img/{path}', function (Nimbus\Glide\Server $server, \Illuminate\Http\Request $request) {
    $server->outputImage($request);
})->where('path', '.*');