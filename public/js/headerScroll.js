$(window).bind("mousewheel DOMMouseScroll", function (event) {
    if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
        if (document.body.scrollTop == 0) {
            $(".header").removeClass("shrink");
            $("html").css("overflow-y", "hidden");
            $("body").css("overflow-y", "hidden");
        }
    } else {
        $(".header").addClass("shrink");
        $("html").css("overflow-y", "auto");
        $("body").css("overflow-y", "auto");
    }
});

$(function ($) {
    $(".item p.name").each(function () {
        var charCount = $(this).text().length;
        // $(this).css("font-size", "2.2em");
        if (charCount > 82) {
            $(this).css("font-size", parseInt($(this).css("font-size")) * 0.9);
        }
    });
});
