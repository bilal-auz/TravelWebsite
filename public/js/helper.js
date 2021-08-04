$(function ($) {
    $(".item p.name").each(function () {
        var charCount = $(this).text().length;
        // $(this).css("font-size", "2.2em");
        if (charCount > 82) {
            $(this).css("font-size", parseInt($(this).css("font-size")) * 0.9);
        }
    });
});

window.onload = function () {
    loadPage();
};

function loadPage() {
    console.log("ready");
    $(".loadDiv").css("display", "none");
    $("#section-landing").css("display", "block");
    $(".footer").css("display", "block");
}

function loading() {
    $(".loadDiv").css("display", "block");
}
