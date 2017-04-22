<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

require_once "../vendor/autoload.php";

use MicrosoftAzure\Storage\Common\ServicesBuilder;



class filecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function handleUpload(Request $request){
            $file=$request->file('file');
            $filetypes=config('app.fileallowtypes');
            $maxfileupload=config('app.maxfileupload');
            $rules=[
                // the file key is the name of the tag in HTML
                'file'=>'required|mimes:'.$filetypes.'|max:'.$maxfileupload
            ];
            //this is to show any error is accours in the page view
            //if not show any messages in the page that means no errors is accured
            $this->validate($request,$rules);
            $filename=$file->getClientOriginalName();
            $dist=config('app.fileDestinationPath').'/'.$filename;
            $uploaded=Storage::put($dist,file_get_contents($file->getRealPath()));

            if ($uploaded){

            }


        return redirect()->to('/upload');
    }
    public function upload(){
        $directory=config('app.fileDestinationPath');
        //the files are setting in the Storage section that is way we take it from that place
        $files=Storage::files($directory);

        //the files consider it as in the array and it then show it to the upload page
        return view('UploadFiles.upload')->with(['files'=>$files]);
    }



}
