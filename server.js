var socket  = require( 'socket.io' );
var express = require('express');
var app     = express();
var server  = require('http').createServer(app);
var io      = socket.listen( server );
var port    = process.env.PORT || 3800;

server.listen(port, function () {
  console.log('Server listening at port %d', port);
});

io.on('connection', function (socket) {


socket.on('init', function( data ) {
	//console.log(data);
    //var modul = "modul"+data.id.substr(2,1);
    /*console.log("id : "+data.id_peserta);
    console.log("band : "+data.band);
    console.log("sekolah : "+data.sekolah);*/
    io.sockets.emit( 'tampil', {
      id_peserta: data.id_peserta,
      band: data.band,
      sekolah: data.sekolah
    });
});


socket.on('play', function( data ) {
	console.log("play");
	io.sockets.emit( 'play');
});

socket.on('pause', function( data ) {
	console.log("pause");
	io.sockets.emit( 'pause');
});

socket.on('reset', function( data ) {
	console.log("reset");
	io.sockets.emit( 'reset');
});

});
