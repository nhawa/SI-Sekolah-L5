<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', ['as' => 'home', 'uses' => 'FrontController@index']);
Route::get('/lihatpoll', 'FrontController@polling');
Route::post('/tambahpoll', 'FrontController@tambahpoll');
Route::get('/berita', 'FrontController@beritalist');
Route::get('/baca/berita/{slug}', 'FrontController@berita');
Route::get('/pengumuman', 'FrontController@pengumumanlist');
Route::get('/baca/pengumuman/{slug}', 'FrontController@pengumuman');
Route::get('/agenda', 'FrontController@agendalist');
Route::get('/baca/agenda/{slug}', 'FrontController@agenda');
Route::get('/galeri', 'FrontController@album');
Route::get('/download', 'FrontController@download');
Route::get('/galeri/{id}', 'FrontController@foto');
Route::get('/page/{slug}', 'FrontController@halaman');
Route::get('/datasiswa', 'FrontController@datasiswa');
Route::get('/dataguru', 'FrontController@dataguru');
Route::get('/datapegawai', 'FrontController@datapegawai');
Route::get('/absensi', 'FrontController@absensi');

Route::group(array('middleware' => 'auth'), function(){
    Route::controller('filemanager', 'FilemanagerLaravelController');
});


Route::get('/login', ['middleware' => 'guest', function() {
return view('backend.login');
}]);
Route::post('/login', 'LoginController@auth');
Route::get('/logout', 'LoginController@logout');
Route::get('home', 'HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('/', function() {
        $data['title'] = 'Home';
        return view('backend.dashboard',$data);
    });
    Route::get('/upload/didownload/{id}', 'Admin\UploadController@update_didownload');
    Route::get('/datadinamis', ['as' => 'admin.dashboard.datadinamis', function() {
        $data['title'] = 'Data Dinamis';
        return view('backend.datadinamis',$data);
}]);

    Route::get('/sekolah', ['as' => 'admin.dashboard.sekolah', function() {
    return view('backend.sekolah');
}]);
    Route::resource('datastatis', 'Admin\DataStatisController');
    Route::resource('setting', 'Admin\SettingController');
    Route::resource('datamenu','Admin\MenuController');
    Route::resource('berita', 'Admin\BeritaController');
    Route::resource('pengumuman', 'Admin\PengumumanController');
    Route::resource('agenda', 'Admin\AgendaController');
    Route::resource('kelas', 'Admin\KelasController');
    Route::resource('kelas/{id}/siswa', 'Admin\SiswaController');
    Route::resource('pegawai', 'Admin\PegawaiController');
    Route::resource('polling', 'Admin\PollingController');
    Route::resource('polling/{id}/jawaban', 'Admin\JawabanController');
    Route::resource('galeri', 'Admin\GaleriController');
    Route::resource('galeri/{id}/foto', 'Admin\FotoController');
    Route::resource('absensi', 'Admin\AbsensiController');
    Route::resource('upload', 'Admin\UploadController');
    Route::post('upload/update', 'Admin\UploadController@updateFile');
    Route::post('absensi/create', ['as' => 'admin.absensi.create', 'uses' => 'Admin\AbsensiController@create']);
    Route::post('absensi/show', ['as' => 'admin.absensi.show', 'uses' => 'Admin\AbsensiController@show']);
    Route::post('setting/save', 'Admin\SettingController@update');
});

Route::group(['prefix' => 'guru','middleware' => 'auth'], function() {
    Route::get('/', function() {
        $data['title'] = 'Home';
        return view('guru.dashboard',$data);
    });
    Route::resource('pengumuman', 'Admin\PengumumanController');
    Route::resource('upload', 'Admin\UploadController');
    Route::resource('absensi', 'Admin\AbsensiController');
    Route::get('pegawai/{id}', ['as' => 'guru.pegawai.edit', 'uses' => 'Admin\PegawaiController@edit']);
    Route::put('pegawai/{id}', ['as' => 'guru.pegawai.update', 'uses' => 'Admin\PegawaiController@update']);
    Route::post('absensi/create', ['as' => 'guru.absensi.create', 'uses' => 'Admin\AbsensiController@create']);
    Route::post('absensi/show', ['as' => 'guru.absensi.show', 'uses' => 'Admin\AbsensiController@show']);
});

Route::group(['prefix' => 'api'], function() {
    Route::get('datastatis', 'Admin\DataStatisController@apiDataStatis');
    Route::get('datastatis/{id}', 'Admin\DataStatisController@show');
    Route::get('menu', 'Admin\DataStatisController@apiCreateMenu');

    Route::get('datamenu','Admin\MenuController@apiDataMenu');
    Route::get('datamenu/{id}', 'Admin\MenuController@show');

    Route::get('berita', 'Admin\BeritaController@apiBerita');
    Route::get('berita/{id}', 'Admin\BeritaController@show');

    Route::get('pengumuman', 'Admin\PengumumanController@apiPengumuman');
    Route::get('pengumuman/{id}', 'Admin\PengumumanController@show');

    Route::get('agenda', 'Admin\AgendaController@apiAgenda');
    Route::get('agenda/{id}', 'Admin\AgendaController@show');

    Route::get('kelas', 'Admin\KelasController@apiKelas');
    Route::get('kelas/{id}', 'Admin\KelasController@show');

    Route::get('setting', 'Admin\SettingController@apiSetting');
    Route::get('setting/{id}', 'Admin\SettingController@show');


    Route::get('kelas/{id}/siswa', 'Admin\SiswaController@apiSiswa');
    Route::get('siswa/{id}', 'Admin\SiswaController@show');
    Route::get('kelasdropdown', 'Admin\KelasController@apiCreateKelas');

    Route::get('pegawai', 'Admin\PegawaiController@apiPegawai');
    Route::get('pegawai/{id}', 'Admin\PegawaiController@show');

    Route::get('polling', 'Admin\PollingController@apiPolling');
    Route::get('polling/{id}', 'Admin\PollingController@show');
    Route::get('pollingdropdown', 'Admin\PollingController@apiCreatePolling');

    Route::get('polling/{id}/jawaban', 'Admin\JawabanController@apiJawaban');
    Route::get('jawaban/{id}', 'Admin\JawabanController@show');

    Route::get('galeri', 'Admin\GaleriController@apiGaleri');
    Route::get('galeri/{id}', 'Admin\GaleriController@show');
    Route::get('galeridropdown', 'Admin\GaleriController@apiCreateGaleri');

    Route::get('galeri/{id}/foto', 'Admin\FotoController@apiFoto');
    Route::get('foto/{id}', 'Admin\FotoController@show');

    Route::get('absensi', 'Admin\AbsensiController@apiAbsensi');
    Route::get('absensi/{id}', 'Admin\AbsensiController@apiAbsensi');

    Route::get('upload', 'Admin\UploadController@apiUpload');
    Route::get('upload/{id}', 'Admin\UploadController@apiUpload');
    Route::get('upload/didownload/{id}', 'Admin\UploadController@update_didownload');

    Route::get('ambilsiswa/{id}', 'FrontController@ambilsiswa');
    Route::post('showabsensi', 'FrontController@showabsensi');
});
