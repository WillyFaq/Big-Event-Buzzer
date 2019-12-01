var createTblpeserta = 'CREATE TABLE IF NOT EXISTS tblpeserta (id_peserta int NOT NULL, nama_band varchar(200), nama_sekolah varchar(200), sts int, PRIMARY KEY (id_peserta) )';
var db = openDatabase('dbbigevent', '1.0', 'data base distribusi', 200000);
var dataset;
function initDatabase(){
    try {
    	if (!window.openDatabase){
        	alert('Databases are not supported in this browser.');
        }else {
        	createPeserta(); 
            
        }
    }catch (e) {
    	if (e == 2) {
        	console.log("Invalid database version.");
        } else {
        	console.log("Unknown error " + e + ".");
        }
        return;
    }


}


function destroy_database() {
    drop_peserta();
}

function init_table () {
    show_peserta();
}

/*--------------------------------------------------------*/
/*  DDL  */
/*--------------------------------------------------------*/

function createPeserta(){
    db.transaction(function (tx) { tx.executeSql(createTblpeserta, [], null, onError); });
    console.log("TABLE peserta CREATED");
}

function drop_peserta(){
    db.transaction(function (tx) {  
        tx.executeSql("DROP TABLE tblpeserta", [], null, onError);
    });
}

/*--------------------------------------------------------*/
/*  DML  */
/*--------------------------------------------------------*/

function delete_peserta(){
    db.transaction(function (tx) {  
        tx.executeSql("DELETE FROM tblpeserta", [], null, onError);
    });
}

function delete_peserta_where(id){
    db.transaction(function (tx) {  
        tx.executeSql("DELETE FROM tblpeserta WHERE id_peserta = ?", [id], null, onError);
    });
}

function update_peserta_json(da){
    db.transaction(function (tx) {  
        tx.executeSql("UPDATE tblpeserta SET nama_band =?, nama_sekolah =?, sts=? WHERE id_peserta =?", 
            [da[0], da[1], da[2], da[3]]);
    }, console.log("OKE"),   onError );   
}


function update_peserta_sts(id){

    db.transaction(function (tx) {
        tx.executeSql('SELECT * FROM tblpeserta WHERE sts = 1', [], function (tx, results) {
            var len = results.rows.length, i;
            msg = "Job Found rows: " + len ;
            
            console.log(msg);
            dataset = results.rows;
            for (var i = 0, item = null; i < dataset.length; i++) {
                item = dataset.item(i);
                console.log("id curent "+item.id_peserta);
                db.transaction(function (tx) {  
                    tx.executeSql("UPDATE tblpeserta SET sts = 2 WHERE id_peserta = ?", [item.id_peserta], null, null);
                }, console.log("OKE"),   onError );  
            }
        }, update_peserta_sts_ad(id), console.log('erorr select update all'));
    });   
/*
        db.transaction(function (tx) {  
            tx.executeSql("UPDATE tblpeserta SET sts = 1 WHERE id_peserta = ?", [id], null, onError);
        }, console.log("OKE"),   onError );  */ 
 /*   setTimeout(function(){

    },500);*/
}

function update_peserta_sts_ad (id) {
    
        db.transaction(function (tx) {  
            tx.executeSql("UPDATE tblpeserta SET sts = 1 WHERE id_peserta = ?", [id], null, onError);
        }, console.log("OKE"),   console.log('erorr update curr') );  
}

function insert_job_json(da){
    console.log(da);
    db.transaction(function (tx) {  
        tx.executeSql("INSERT INTO tblpeserta (id_peserta, nama_band, nama_sekolah, sts) VALUES(?, ?, ?, ?);", 
            [da[0], da[1], da[2], da[3]]);
    }, onError);   
}

function show_peserta(){
    var item;
    $('#data_box').html('');
    db.transaction(function (tx) {
        tx.executeSql('SELECT * FROM tblpeserta', [], function (tx, results) {
            var len = results.rows.length, i;
            msg = "Job Found rows: " + len ;
            
            console.log(msg);
            dataset = results.rows;
            for (var i = 0, item = null; i < dataset.length; i++) {
                item = dataset.item(i);
                get_pesrta(dataset.item(i));
            }
        }, null);
    });
}

function get_current() {
    var item;
    db.transaction(function (tx) {
        tx.executeSql('SELECT * FROM tblpeserta WHERE sts = 1', [], function (tx, results) {
            var len = results.rows.length, i;
            msg = "Job Found rows: " + len ;
            
            console.log(msg);
            dataset = results.rows;
            for (var i = 0, item = null; i < dataset.length; i++) {
                item = dataset.item(i);
                //console.log("id curent "+item.id_peserta);
                socket.emit('init',{
                    id_peserta: item.id_peserta,
                    band: item.nama_band,
                    sekolah: item.nama_sekolah
                });
            }
        }, null);
    });   
}

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
    ret += itm['nama_sekolah'];
    ret += '</td>';
    
    ret += '<td>';

    if(itm['sts']==1){
        if(localStorage.sts_play==0){
                /*console.log("OKE");
                $(".btn-play").removeClass("btn-primary");
                $(".btn-play").addClass("btn-danger");
                $(".btn-play").html('<i class="fa fa-pause"></i>');*/
            ret += '<button onclick="play()" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Mulai"><i class="fa fa-play"></i></button>';
        }else{
            ret += '<button onclick="pause()" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Pause"><i class="fa fa-pause"></i></button>';

        }
        ret += '&nbsp;';
        ret += '<button onclick="reset()" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-refresh"></i></button>';
        
    }else{
        ret += '<button onclick="tampil('+itm['id_peserta']+')" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Tampilkan"><i class="fa fa-eye"></i></button>';
        
    }
    ret += '&nbsp;';
   // ret += '<button onclick="hapus_peserta('+itm['id_peserta']+')" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>';
    ret += '</td>';

    ret += '</tr>';
    $('#data_box').append(ret);
}

function onError(tx, error){
	//myApp.alert(error.message);
    console.log(error);
    //console.log("error.message");
}

initDatabase();
//insert_init();

/*
db.transaction(function (tx) {  
    tx.executeSql("UPDATE tblpeserta SET sts = 1 WHERE id_peserta = 20 ");
});


db.transaction(function (tx) {  
    tx.executeSql("UPDATE tblpeserta SET sts = 2 WHERE id_peserta = 18 ");
});


db.transaction(function (tx) {  
    tx.executeSql("UPDATE tblpeserta SET sts = 2 WHERE id_peserta = 19 ");
});*/

/*db.transaction(function (tx) {  
    tx.executeSql("UPDATE tblpeserta SET sts = 2 ");
    console.log("OKE");
});*/





/*
function insert_init(){
    delete_user();
    db.transaction(function (tx) {  
        tx.executeSql("INSERT INTO tblsupir (id_supir, nama_supir, alamat, username, password, status, api_key) VALUES ('S-1707-006', 'Gilang Bhaskara', 'Sidoarjo', 'gilang', 'gilang', '1', 'Uy0xNzA3LTAwNg')");
    });
}

function insert_init2(){
    delete_job();
    /*db.transaction(function (tx) {  
        tx.executeSql("INSERT INTO tbljob (id_job, nama_supir, nama_helper, lokasi, kendaraan, tgl_job, jam_berangkat, jam_sampai) VALUES('JB-170721-00002', 'Gilang Bhaskara', 'Paul Gilbert', 'Malang - Sidoarjo', 'W 9910 PM - Scania', '2017-07-21', '2017-07-21 06:00:00', '2017-07-21 10:00:00');", [],showJob, onError);
    });
    db.transaction(function (tx) {  
        tx.executeSql("INSERT INTO tbljob (id_job, nama_supir, nama_helper, lokasi, kendaraan, tgl_job, jam_berangkat, jam_sampai, status) VALUES('JB-170721-00003', 'Gilang Bhaskara', 'John Petrucci', 'Sidoarjo - Surabaya', 'W 9910 PM - Scania', '2017-07-29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');");
    });
}
*/