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
	<link href="assets/css/custom.css" rel="stylesheet">	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/js/d3.js"></script>
    <script src="assets/js/d3.hexbin.v0.min.js?5c6e4f0"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/mousetrap.js"></script>
    <script src="assets/js/id3-minimized.js"></script>
	<script src="assets/js/main.js"></script>	
    <script type="text/javascript" src="assets/js/socket.io.js"></script>
    <script type="text/javascript" src="assets/js/config.js"></script>
	<script type="text/javascript">
        //var socket = io.connect( 'http://127.0.0.1:3800' );
    var socket = io.connect( _server );
	</script>
</head>
<body>

    <div class='wrapper'>
        <div id="mp3_player" class='fade'>
            <div id="audio_box"></div> <i id='fullscreen' class="icon-resize-full-alt"></i>
        </div>
    </div>
	<div class="container text-center">
		<!-- <div class="page-header">
			<h1>STIKOMUSIC BIG EVENT 2017</h1>
			<h2>Harmony Budaya Nusantara</h2>
		</div> -->
		<img src="assets/img/logo.png" alt="logo" class="img-logo" style="height:200px;width:170px;">
		<div class="main">
			<h1 class="timer">15:00</h1>
			<div class="hr"></div>
			<h2 class="nama_band">STIKOMUSIC</h2>
			<h2 class="nama_sekolah">STIKOMUSIC</h2>
		</div>
		<div class="footer">
			<!-- <h3>#Stifest2018</h3> -->
			<h3>#StikomusicBigEvent2019</h3>
		</div>
	</div>
	<div class="container border-box">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 brd" id="brd-top-left"></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 brd" id="brd-top-right"></div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 brd" id="brd-bottom-left"></div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 brd" id="brd-bottom-right"></div>
		</div>
	</div>
	<audio id="buzzer_sound" loop="loop">
	  	<source src="assets/sound/1.mp3" type="audio/mpeg" />
	  	Your browser does not support the audio element.
	</audio>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- 
    <script src="assets/js/data_storage.js"></script>
     -->
    
    <script src="assets/js/custom.js"></script>
    
    <script type="text/javascript">

    socket.on('tampil',function( data ) {
        var id_peserta = data.id_peserta;
        var band = data.band;
        var sekolah = data.sekolah;
        /*console.log(id_peserta);
        console.log(band);
        console.log(sekolah);*/	
        
        $('.nama_band').html(band);
        $('.nama_sekolah').html(sekolah);
        localStorage.cur_band=band;
        localStorage.cur_sekolah=sekolah;
        cur_timer = tot_time;
        //start_timmer(cur_timer);
        sts_time = 0;

        /*localStorage.setItem("cur_time", cur_timer);
        localStorage.setItem("sts_time", sts_time);*/
        $(".timer").html("15:00");
        stop_buzzer();
    });

    socket.on('play',function( data ) {
    	console.log('play');
    	start_timmer(localStorage.cur_time-1);
		localStorage.sts_time=1;
        stop_buzzer();
    });

    socket.on('pause',function( data ) {
    	console.log('stop');
        stop_timmer(localStorage.cur_time);
        clearInterval(sttout);
        localStorage.sts_time=0;
        stop_buzzer();
    });

    socket.on('reset',function( data ) {
    	console.log('stop');
        cur_timer = tot_time;
        //start_timmer(cur_timer);
        sts_time = 0;

        localStorage.setItem("cur_time", cur_timer);
        localStorage.setItem("sts_time", sts_time);
        $(".timer").html("15:00");
        stop_buzzer();
    });

    </script>
</body>
</html>