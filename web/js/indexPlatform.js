$(document).ready(function() {

    $("#gotonew").click(function() {
        $("#platform_new").submit();
    });

    $("._link img[title]").tooltip({
        position: "bottom left",
        opacity: 0.9
    });

    $("._actions img[title]").tooltip({
        position: "top left",
        opacity: 0.9
    });
});

