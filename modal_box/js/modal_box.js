$(document).ready(function () {
    var span = document.getElementsByClassName("close")[0];

    $("#modal_info").fadeIn();

    if($("#tiempo_modal").val() > 0){
        setTimeout(function() {
            $("#modal_info").fadeOut();
        }, $("#tiempo_modal").val());
    }

    span.onclick = function() {
        $("#modal_info").fadeOut();
    };

    window.onclick = function(event) {
        if (event.target == $("#modal_info")) {
            $("#modal_info").fadeOut();
        }
    };
});