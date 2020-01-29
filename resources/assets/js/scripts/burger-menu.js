//$(".burger-menu").click(function () {
	//$(this).toggleClass("menu-on");
	//$(".burger-menu-items").toggleClass("show");
//});
$(".burger-menu").click(function () {
	$(this).toggleClass("menu-on");
	if ($(this).hasClass("menu-on")) {
		$(".main-burger-menu-items").css({"display" : "flex", "flex-direction" : "column"}).slideDown();
	} else {
		$(".main-burger-menu-items").css({"display" : "", "flex-direction" : ""}).slideUp();
	};
});


