$(document).ready(function(){

    $(function () {

        $("#divUnboundMobile").removeAttr("style");
        $("#divUnboundMobile").attr("style", "display:none");

        setTimeout(function () {
            if ($("#divUnboundMobile").length > 0) {
                $("#divLoading").removeAttr("style");
                $("#divLoading").attr("style", "display:none");

                $("#divUnboundMobile").removeAttr("style");
            } else {
                $("#divUnboundMobile").val("BIND");
                $('#btnGoPayfor').click();
            }
        }, 1000);
    });

    function Payfor() {
        $("#divUnboundMobile").val("NOBIND");
        $('#btnGoPayfor').click();
    }
});
