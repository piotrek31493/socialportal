$(document).ready(function() {
    $("#signup").click(function() {
        $("#first").slideUp("slow", function() {
            $("#second").slideDown("slow");
        }); //slideUp, slideDown ukrywanie i pokazywanie elementow zjawiskiem wślizgu
    });

    $("#signin").click(function() {
        $("#second").slideUp("slow", function() {
            $("#first").slideDown("slow");
        }); //slideUp, slideDown ukrywanie i pokazywanie elementow zjawiskiem wślizgu
    });
});
