<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mapredcontroller extends Controller
{
    public function submitJobToCluster(Request $request)
    {
        $formatChosen = $_POST['formatname'];
        // $request->session()->put('name',time());
        $newDirectory = $request->session()->get('name');
        $arg1 = '/' . $newDirectory;
        $arg2 = '/' . $newDirectory . 'out1';
        //invoke the submitting
        $this->executeCurl($formatChosen, $arg1, $arg2);
    }

    public function executeCurl($format, $arg1, $arg2)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://convertimage.azurehdinsight.net/templeton/v1/mapreduce/jar");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user.name=sshuser&jar=/ams/imageconverter.jar&class=experiments.ConvertImage&define=format=" . $format . "&arg=" . $arg1 . "&arg=" . $arg2);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "admin" . ":" . "ibrahimTALEB123#");

        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";//JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $jsonData=json_decode($result, true);
        $job_id=$jsonData['id'];
        $this->getProgress($job_id);

    }

    public function getProgress($job_id='job_1490776304759_0151')
    {
        $ch = curl_init();
        $url="https://convertimage.azurehdinsight.net/templeton/v1/jobs/".$job_id."?user.name=sshuser";
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "admin" . ":" . "ibrahimTALEB123#");

        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";//JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result=curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
             exit();
            }
        curl_close($ch);
        $jsonData=json_decode($result, true);
        $pr=$jsonData['percentComplete'];
        $pr=(int)substr($pr,3,6);  //progress by 100%
        return view('azure_interface.showprogress')->with(['pr'=>$pr]);


    }


}
