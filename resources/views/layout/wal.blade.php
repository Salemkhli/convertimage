<!DOCTYPE html>
<html class="full" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<title> ... </title>
		
		<link rel="stylesheet" href="css/bootstrap.css"/>
		<link rel="stylesheet" href="css/font-awesome.min.css"/>
		<link rel="stylesheet" href="css/fileinput.css" type="text/css"/>
		<link rel="stylesheet" href="css/mine-format.css"/>
		<!--[if lt IE 9]>
		<script src="html5shiv.min.js"></script>
		<script src="respond.min.js"></script>
		<![endif]-->
		<script src="js/jquery-1.12.4.min.js" ></script>
		<script src="js/fileinput.min.js" ></script>
		<script src="js/bootstrap.js" ></script> 


	</head>
	<body>
		<div class="container">
			<input id="input-711" name="kartik-input-711[]" type="file" multiple class="file-loading">
			<hr/>
			<label class="control-label">Upload Files From Folder</label>
			<input id="input-folder-2" name="input-folder-2[]" class="file-loading" type="file" multiple webkitdirectory accept="image/*">
			<div id="errorBlock" class="help-block"></div>
			<!-- URL -->
			<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target=".bs-example-modal-lg">Upload Files From URL</button>
			<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3>Add website or file by URL</h3>
					</div>
					<form class="form-inline">
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon3">
							<span class="glyphicon glyphicon-link" aria-hidden="true"></span>
						</span>
						  <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3 " placeholder="http://...">
						</div>
						<button type="submit" class="btn btn-primary">Convert</button>
					</form>
				</div>
			  </div>
			</div>
		</div>
	</body>
<script>
$("#input-711").fileinput({
    uploadUrl: "http://localhost/file-upload-single/1", // server upload action
    uploadAsync: true,
    showBrowse: false,
    browseOnZoneClick: true

});


$(document).on('ready', function() {
    $("#input-folder-2").fileinput({
        browseLabel: 'Select Folder...',
        previewFileIcon: '<i class="fa fa-file"></i>',
        allowedPreviewTypes: null, // set to empty, null or false to disable preview for all types
        previewFileIconSettings: {
            'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
            'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
            'zip': '<i class="fa fa-file-archive-o text-muted"></i>',

        },
        previewFileExtSettings: {
            'jpg': function(ext) {
                return ext.match(/(jp?g|png|gif|bmp)$/i);
            },
            'zip': function(ext) {
                return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            },
        }
    });
});
</script>
</html>