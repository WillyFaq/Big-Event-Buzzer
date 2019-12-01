var sts_time = 0;
var cur_timer, minutes, seconds;
cur_timer = tot_time;
var sttout;

$(document).ready(function(){
    stop_buzzer();
    //$(".timer").html("OKE");
        //localStorage.cur_time = tot_time;
    if (typeof(localStorage.cur_time) === "undefined") {
        localStorage.cur_time = tot_time;
        console.log(localStorage.cur_time);
    }
    if (typeof(localStorage.sts_time) === "undefined") {
        localStorage.sts_time = sts_time;
        console.log(localStorage.sts_time);
    }

    if (typeof(localStorage.cur_band) === "undefined") {
        localStorage.cur_band = "";
        $('.nama_sekolah').html(localStorage.cur_sekolah);
    }else{
        $('.nama_band').html(localStorage.cur_band);
    }
    if (typeof(localStorage.cur_sekolah) === "undefined") {
        localStorage.cur_sekolah = "";
        $('.nama_sekolah').html(localStorage.cur_sekolah);
    }else{
        $('.nama_sekolah').html(localStorage.cur_sekolah);
    }

    if(localStorage.sts_time==1){
        clearInterval(sttout);
        start_timmer(localStorage.cur_time);
    }
    if(localStorage.cur_time<900 || localStorage.cur_time!=0 ){
        stop_timmer(localStorage.cur_time);
    }

    
});

function start_timmer(duration) {
    cur_timer = duration, minutes, seconds;
    sttout = setInterval(function () {
        minutes = parseInt(cur_timer / 60, 10)
        seconds = parseInt(cur_timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        $(".timer").html(minutes + ":" + seconds);
        //display.textContent = minutes + ":" + seconds;

        localStorage.setItem("cur_time", cur_timer);
        if (--cur_timer < 0) {
            ///timer = duration;
            clearInterval(sttout);
            play_buzzer();
            console.log("play buzzer");
        }
    }, 1100);
}

function stop_timmer(duration) {
    var cur_timer = duration, minutes, seconds;
    minutes = parseInt(cur_timer / 60, 10)
    seconds = parseInt(cur_timer % 60, 10);
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;
    $(".timer").html(minutes + ":" + seconds);
}

function play_buzzer() {
    var ss=document.getElementById("buzzer_sound"); 
    ss.play();
}

function stop_buzzer() {
    var ss=document.getElementById("buzzer_sound"); 
    ss.pause();
    console.log("BUZZER STOP!!!!!!!");
}
