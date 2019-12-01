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
	<script type="text/javascript">
        //var socket = io.connect( 'http://127.0.0.1:3800' );
		var socket = io.connect( 'http://192.168.43.195:3800' );
	</script>
</head>
<body>
	
	<div class="container">
		<div class="frm_ini">
        	<!-- <div class="page-header">
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
                    <div class="col-sm-offset-2 col-sm-10">
                          <button type="button" class="btn btn-success btn-add">Tampilkan</button>
                    </div>
                </div>
            </form> -->
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
    <!-- 
    <script src="assets/js/data_storage.js"></script>
-->

    <script type="text/javascript">
        var dd = new Array(
                            {id_peserta : 1, nama_band : "New Option", sts : 0},
                            {id_peserta : 2, nama_band : "New Face", sts : 0},
                            {id_peserta : 3, nama_band : "EBM KIDSKU", sts : 0},
                            {id_peserta : 4, nama_band : "The Fucker", sts : 0},
                            {id_peserta : 5, nama_band : "LOKUSTIK", sts : 0},
                        );

        $(document).ready(function(){
            $(".btn-add").click(function(){
                var v = $("#nama_band").val(); 
                console.log(v);
                $("#nama_band").val(" ");
            });
        });

        for (var i = 0; i < dd.length; i++) {
            /*var a = dd[i];
            console.log(a[0]);*/
            //get_pesrta(dd[i]);
        };


        function get_pesrta(itm){
            var ret = '<tr ';
            if(itm['sts']==1 || itm['sts']==2){
                ret += 'class="tr_strong"';
            }
            ret += '>';
            
            ret += '<td>';
            ret += itm['id_peserta'];
            ret += '</td>';
            
            ret += '<td>';
            ret += itm['nama_band'];
            ret += '</td>';
            
            ret += '<td>';

            if(itm['sts']==1){
                if(localStorage.sts_play==0){
                        /*console.log("OKE");
                        $(".btn-play").removeClass("btn-primary");
                        $(".btn-play").addClass("btn-danger");
                        $(".btn-play").html('<i class="fa fa-pause"></i>');*/
                    ret += '<button onclick="play('+itm['id_peserta']+')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Mulai"><i class="fa fa-play"></i></button>';
                }else{
                    ret += '<button onclick="pause('+itm['id_peserta']+')" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Pause"><i class="fa fa-pause"></i></button>';

                }
                ret += '&nbsp;';
                ret += '<button onclick="reset('+itm['id_peserta']+')" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-refresh"></i></button>';
                
            }else{
                ret += '<button onclick="tampil('+itm['id_peserta']+')" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tampilkan"><i class="fa fa-eye"></i></button>';
                
            }
            ret += '&nbsp;';
           // ret += '<button onclick="hapus_peserta('+itm['id_peserta']+')" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>';
            ret += '</td>';

            ret += '</tr>';
            $('#data_box').append(ret);
        }


        if (typeof(localStorage.cur_band) === "undefined") {
            localStorage.cur_band = "";
        }else{
            for (var i = 0; i < dd.length; i++) {
                var a = dd[i];
                if(dd[i]['nama_band']==localStorage.cur_band){
                    console.log(dd[i]);
                    dd[i]['sts'] = 1;  

                }else{
                    dd[i]['sts'] = 0;  
                }
                get_pesrta(dd[i]);
            }
            console.log(dd);
        }

        function tampil (id) {
            for (var i = 0; i < dd.length; i++) {
                var a = dd[i];
                if(a['id_peserta']==id){
                    console.log(a);
                    socket.emit('init',{
                        id_peserta: a['id_peserta'],
                        band: a['nama_band'],
                        sekolah: ''
                    });

                }
            }
            setTimeout(function(){
                location.reload();
            },500);
        }

        function play (id) {
            localStorage.sts_play=1;
            socket.emit('play');
            setTimeout(function(){
                location.reload();
            },500);
        }

        function pause (id) {
            localStorage.sts_play=0;
            socket.emit('pause');
            setTimeout(function(){
                location.reload();
            },500);
        }

        function reset (id) {
            localStorage.sts_play=0;
            socket.emit('reset');  
            setTimeout(function(){
                location.reload();
            },500); 
        } 
    </script>
   

</body>
</html>
