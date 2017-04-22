<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('layout.wal');
});*/
Route::get('/', function () {
    return view('UploadFiles.upload');
});

//Route::get('test','mapredcontroller@getProgress');
//

Route::post('uploadazure','azurecontroller@uploadFromWebToHDFS'); //1
Route::get('uploadazure/imagetypeform','azurecontroller@chooseImagesTypeForm');//2
//Route::post('uploadazure/imagetypeform/convert','mapredcontroller@submitJobToCluster');//3
Route::get('uploadazure/imagetypeform/convert','mapredcontroller@getProgress');
Route::post('uploadazure/imagetypeform/convert','mapredcontroller@getProgress');

Route::get('/files/download','azurecontroller@forcedownload');
Route::get('downloadazure','azurecontroller@downlodFromHDFS');//4

  //training
Route::get('connect','azurecontroller@connectToHadoopBySSH');
Route::get('list', 'azurecontroller@getListBlobsOfSubdirectory');
Route::post('handleupload','filecontroller@handleUpload');