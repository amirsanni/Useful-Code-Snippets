<!DOCTYPE HTML>
<html>
	<head>
		<title>File Merger</title>
		<link rel="stylesheet" href='assets/bootstrap/css/bootstrap.min.css'>
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome-animation.min.css">
		<!--<link rel="stylesheet" href='assets/css/main.css'>-->
		<script src='assets/js/jquery.min.js'></script>
		<!--<script src='assets/bootstrap/js/bootstrap.min.js'>-->
		<script src='assets/js/main.js'></script>
	</head>
	
	<body>
	<br>
		<div class="container-fluid">
			<div class='row'>
				<div class='col-md-1'></div>
				
				<div class='col-md-11'>
					<div class='row'>
						<input type='file' id='ftm' class='hidden' multiple>
						<button class='btn btn-default btn-sm' id='selFilesBtn'>Select Files</button>
					</div>
					<br>
					<div class='row'>
						<div class='col-sm-12' id='displaySelectedFilesHere'></div>
					</div>
					<br>
					<div class='row'>
						<button class="btn btn-primary btn-sm" id="mergeBtn">Merge</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
