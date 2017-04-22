<h1>Welcome to convert Page</h1>

{{  Form::open(array('url' =>'uploadazure/imagetypeform/convert','files'=>false,'method'=>'post')) }}
{{  Form::select('formatname',array('png'=>'png','jpg'=>'jpg','bmp'=>'bmp','gif'=>'gif','jpeg'=>'jpeg'))  }}
{{  Form::token()  }}
{{  Form::submit('Convert!')  }}
{{  Form::close() }}
