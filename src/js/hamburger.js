var $hamburger = jQuery(".hamburger");
var $offcanvas = jQuery(".offcanvas");

$hamburger.on("click", function() {
    $hamburger.toggleClass("is-active");
    $offcanvas.toggleClass("open");
});
