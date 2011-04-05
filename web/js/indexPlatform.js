$(document).ready(function() {


    $("._link img[title]").tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $("#gotonew").click(function() {
        $("#platform_new").submit();
    });

    $("._actions img[title]").tooltip({
        position: "top left",
        opacity: 0.9
    });
});

