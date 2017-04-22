<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

require_once "../vendor/autoload.php";
use Illuminate\Support\Facades\Input;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use phpDocumentor\Reflection\Types\Static_;
use phpseclib\NET\SSH2;
use \FilesystemIterator as FilesystemIterator;
use \SplFileInfo as SplFileInfo;


class azurecontroller extends Controller
{
public static $ssh;
public static $format_name;
public static $directory_name;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
  // The connection to the azure blob
    public function getTheConnection()
    {
        $key = 'l2ntz4d/az5O2+mYv9R50rDNvCRKvUi9dw5yh2IczD2iPap91VFpN734OCAWTe2ZfPjvibUN2mZg3n7NpuuJRA==';
        if (base64_encode(base64_decode($key, true)) === $key) {
            $connectionString = 'DefaultEndpointsProtocol=https;AccountName=convertimage;
                      AccountKey=l2ntz4d/az5O2+mYv9R50rDNvCRKvUi9dw5yh2IczD2iPap91VFpN734OCAWTe2ZfPjvibUN2mZg3n7NpuuJRA==';
        }
        return $connectionString;
    }

    //list files from container and then choose to download
    public function getFilesFromazure()
    {
        $connectionString = $this->getTheConnection();
        // Create blob REST proxy.
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
        // List blobs of conversion
        $blob_list = $blobRestProxy->listBlobs("userfiles");
        $container="convertimage-2017-03-29t08-13-29-590z";
        $blobs = $blob_list->getBlobs();
        return view('UploadFiles.listblob')->with(['blobs' => $blobs]);

    }

     public function getListBlobsOfSubdirectory(){
         $connectionString = $this->getTheConnection();
         $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
         //set the / to subdirectory in container
         $listBlobsOptions=new ListBlobsOptions();
        // $listBlobsOptions->setDelimiter('/');
         $listBlobsOptions->setMaxResults(10);//pagination
         $listBlobsOptions->setIncludeMetadata(true);
        // $listBlobsOptions->setDelimiter('userfiles');
        //always the second option parameter to aware of it you get the options in the Models
         $blobs=$blobRestProxy->listBlobs("convertimage-2017-03-29t08-13-29-590z",$listBlobsOptions);
         $return = [
             'blobs' => [],
             'delimiter' => $blobs->getDelimiter(),
             'blobPrefixes' => [],
             'prefixes' => $blobs->getPrefix(),
             'nextMarker' => $blobs->getNextMarker(),
         ];
         foreach ($blobs->getBlobPrefixes() as $k => $b) {
             //an instance of MicrosoftAzure\Storage\Blob\Models\BlobPrefix
             array_push($return['blobPrefixes'], $b->getName());
         }
        foreach ($blobs->getBlobs() as $k => $b) {
            //an instance of MicrosoftAzure\Storage\Blob\Models\Blob
            $tmp = [];
            $tmp['name'] = $b->getName();
            $tmp['url'] = $b->getUrl();

            array_push($return['blobs'], $tmp);
        }
         return view('UploadFiles.listblob')->with(['return'=>$return]);
     }


    public function uploadFromWebToHDFS(Request $request){

        //set the session for first user
        $request->session()->flush();
        $this->setSession($request);
        //connect to azure
        $connectionString = $this->getTheConnection();
        $blobClient = ServicesBuilder::getInstance()->createBlobService($connectionString);
        //set the user directory
        azurecontroller::$directory_name = $request->session()->get('name');
        //here start process of uploading files
        $files = $request->file('images');







        //process and pull all files from the stack
        foreach ($files as $file){
            $blob_name = azurecontroller::$directory_name.'/'.$file->getClientOriginalName();
            $content=file_get_contents($file);
            try {
                //Upload blob
                $blobClient->createBlockBlob("convertimage-2017-03-29t08-13-29-590z", $blob_name, $content);
            } catch(ServiceException $e){
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code.": ".$error_message.PHP_EOL;
            }
        }
        //redirect to form convert page to choose format
    return redirect('/uploadazure/imagetypeform');
    }

    public function chooseImagesTypeForm(){
        //view the type of images to choose here
        return view('UploadFiles.chooseFormat');
    }
    //process to convert the images by taking the format from user
    public function convertFunction(Request $request){

        $format_name=azurecontroller::$format_name=$_POST['formatname'];

        $directoryInString=(string)$request->session()->get('name');
        $comm_convert='yarn jar imageconverter.jar experiments.ConvertImage -D format='.$format_name."   ".'/'.$directoryInString."  ".'/'.$directoryInString.'out';


        return "<h1>the files are uploaded</h1>";
    }

  public function setSession($re){
        $time=time();
        $re->session()->put('name',$time);
  }



    public function downlodFromHDFS($directName)
    {   //set the connection string from the function below
        $connectionString = $this->getTheConnection();
        // Create blob REST proxy.
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);
        //get the directory name.out
        $fi = new FilesystemIterator(__DIR__, FilesystemIterator::SKIP_DOTS);
        printf("There were %d Files", iterator_count($fi));
        //give the blob that is will be downloaded
        $blobfile = $directName.'/'.'*.*';
        //take the name of the file
        $filename = basename($blobfile);

        try {
            // Get blob.
            $blob = $blobRestProxy->getBlob("convertimage-2017-03-29t08-13-29-590z", $blobfile);


            header('Content-type: image/*');
            header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
            //here to download as stream to local
            fpassthru($blob->getContentStream());
        } catch (ServiceException $e) {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ": " . $error_message . "<br />";
        }
        //return "<h1>the files are uploaded</h1>";
    }


    public function uploadMultipleFiles(){
        $files=Input::file('images');
        $fileCount=count($files);
        $uploadacount=0;
        foreach ($files as $file){
            $rules=array('file'=>'required');
            $uploadacount++;
        }
    }

    public function deleteTheUploadedDirectory(){

    }
}