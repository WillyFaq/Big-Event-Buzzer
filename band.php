<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" href="assets/img/logo.png">
	<title>STIKOMUSIC BIG EVENT</title>
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
		.tr_strong{
		    font-weight:bold;   
		}
    </style>

  <script type="text/javascript" src="assets/js/socket.io.js"></script>
	<script type="text/javascript" src="assets/js/config.js"></script>
	<script type="text/javascript">
    //var socket = io.connect( 'http://127.0.0.1:3800' );
    var socket = io.connect( _server );
	</script>
</head>
<body>
	
	<div class="container">
		<div class="frm_ini">
		<div class="page-header">
		  	<h1>Form Peserta</h1>
		</div>
		<form class="form-horizontal" id="frmpeserta">
  			<div class="form-group">
			    <label for="nama_band" class="col-sm-2 control-label">Nama Band</label>
			    <div class="col-sm-10">
			      	<input type="text" class="form-control" id="nama_band" name="nama_band" placeholder="Nama Band" required>
			    </div>
			</div>
  			<div class="form-group">
			    <label for="asal_sekolah" class="col-sm-2 control-label">Asal Sekolah</label>
			    <div class="col-sm-10">
			      	<input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" placeholder="Asal Sekolah"  required>
			    </div>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-success">Tambah</button>
			    </div>
			</div>
		</form>
		</div>
		<div class="page-header">
		  	<button class="btn btn-xs btn-success pull-right btn_tambah"><i class="fa fa-plus"></i></button>
		  	<h1>Data Peserta</h1>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Band</th>
					<th>Asal Sekolah</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody id="data_box">
			</tbody>
		</table>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/data_storage.js"></script>

    <script type="text/javascript">


    	//update_peserta_sts(1);
    	/*
    	var dd = new Array("4 Teens", "SMAN 14 Surabaya", 1, 1);
    	update_peserta_json(dd);
    	/*var dd = new Array("D'Groot", "SMA Muhammadyah 2 Sidoarjo", 19);
    	update_peserta_json(dd);*/
    	//update_peserta_sts();
      //destroy_database();
    	var data = [];
    	$(document).ready(function(){
    		get_current();

    		$('.frm_ini').hide();
    		$('[data-toggle="tooltip"]').tooltip();

    		show_peserta();

    		$("#frmpeserta").submit(function(){
    			var a = $("#data_box>tr").length;
    			a++;
    			console.log(a);
    			var band = $("#nama_band").val();
    			var sekolah = $("#asal_sekolah").val();
    			var dd = new Array(a, band, sekolah);
    			console.log(dd);
    			insert_job_json(dd);
    			setTimeout(function(){
	    			$("#nama_band").val("");
	    			$("#asal_sekolah").val("");
    				show_peserta();
    			},500);
    			//localStorage.setItem("data_peserta", JSON.setItem(data));
    			return false;
    		});


    		$(".btn_tambah").click(function(){
    			$('.frm_ini').show();
    		});
    	});

    	function hapus_peserta(id) {
    		console.log("HAPUS");
    		delete_peserta_where(id);
       	}

       	function tampil (id) {
       		update_peserta_sts(id);
       		setTimeout(function(){
       			location.reload();
       		},500);
       	}

       	function play () {
       		localStorage.sts_play=1;
       		show_peserta();
       		socket.emit('play');
       	}

       	function pause () {
       		localStorage.sts_play=0;
       		show_peserta();
       		socket.emit('pause');
       	}

       	function reset () {
       		localStorage.sts_play=0;
       		show_peserta();
       		socket.emit('reset');	
       	} 
    </script>

</body>
</html>


<!-- 

<?php
$file = fopen("data.csv","r");
while(!feof($file)){
  $csv = fgetcsv($file);
  //print_r($csv);
?>
var id = <?= $csv[0]; ?>;
var band = "<?= $csv[1]; ?>";
var sekolah = "<?= $csv[2]; ?>";
var sts = 0;
var dd = new Array(id, band, sekolah, sts);
console.log(dd);
insert_job_json(dd);
<?php
}
?>
 -->