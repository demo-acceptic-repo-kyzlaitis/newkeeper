$(document).ready(function() {

    $(".blogger_blocks li[id^=tab_menu]").click(function() {
        var curMenu=$(this);
        $(".blogger_blocks li[id^=tab_menu]").removeClass("selected");
        curMenu.addClass("selected");

        var index=curMenu.attr("id").split("tab_menu_")[1];
        $(".curvedContainer .tabcontent").css("display","none");
        $(".curvedContainer #tab_content_"+index).css("display","block");
    });
});