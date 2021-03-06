/*	jQuery.flexMenu
	Author: Ryan DeBeasi (352 Media Group) - http://www.352media.com/
	Description: If a list is too long for all items to fit on one line, display a popup menu instead. 
	Dependencies: jQuery, Modernizr (optional). Without Modernizr, the menu can only be shown on click (not hover). */
(function ($) {
    var $flexParents = $(""),
        resizeTimeout;

    function adjustFlexMenu() {
        $flexParents.flexMenu({
            "undo": true
        }).flexMenu()
    }
    $(window).resize(function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(adjustFlexMenu, 200)
    });
    $.fn.flexMenu = function (options) {
        var s = $.extend({
            "threshold": 2,
            "cutoff": 2,
            "linkText": "",
            "linkTitle": "View More",
            "linkTextAll": "",
            "linkTitleAll": "Open/Close Menu",
            "showOnHover": true,
            "popupAbsolute": true,
            "undo": false
        }, options);
        return this.each(function () {
            var $this = $(this),
                $firstItem = $this.find("li:first-child"),
                $lastItem = $this.find("li:last-child"),
                numItems = $this.find("li").length,
                firstItemTop = Math.floor($firstItem.offset().top),
                firstItemHeight = Math.floor($firstItem.height()),
                $lastChild, keepLooking, $moreItem, $moreLink, numToRemove, allInPopup = false,
                $menu, i;

            function needsMenu($itemOfInterest) {
                var result = Math.ceil($itemOfInterest.offset().top) >= firstItemTop + firstItemHeight ? true : false;
                return result
            }
            $flexParents = $flexParents.add($this);
            if (needsMenu($lastItem) && numItems >
                s.threshold && !s.undo && $this.is(":visible")) {
                var $popup = $('<ul class="flexMenu-popup"></ul>'),
                    firstItemOffset = $firstItem.offset().top;
                for (i = numItems; i > 1; i--) {
                    $lastChild = $this.find("li:last-child");
                    keepLooking = needsMenu($lastChild);
                    $lastChild.appendTo($popup);
                    if ((i - 1 <= s.cutoff) || ($( window ).width() <= 600)) {
                        $($this.children().get().reverse()).appendTo($popup);
                        allInPopup = true;
                        break
                    }
                    if (!keepLooking) break
                }
                //mainNavbar
                //if (allInPopup)
                //alert($( window ).width());
               // if ($( window ).width() <= 600) alert('exit');
               if (allInPopup) $this.append('<li class="flexMenu-viewMore flexMenu-allInPopup"><a href="#" title="' +
                    s.linkTitleAll + '">' + s.linkTextAll + "</a></li>");
                else $this.append('<li class="flexMenu-viewMore"><a href="#" class="flexMenu-add" title="' + s.linkTitle + '">' + s.linkText + "</a></li>");
                $moreItem = $this.find("li.flexMenu-viewMore");
                if (needsMenu($moreItem)) $this.find("li:nth-last-child(2)").appendTo($popup);
                $popup.children().each(function (i, li) {
                    $popup.prepend(li)
                });
                $moreItem.append($popup);
                $moreLink = $this.find("li.flexMenu-viewMore > a");
                $moreItem.hover(function (e) {
                    //$popup.toggle();
                    //$(this).toggleClass("active");
                    e.preventDefault()
                });
                if (s.showOnHover && typeof Modernizr !== "undefined" && !Modernizr.touch) $moreItem.hover(function () {
                    //$popup.show();
                    //$(this).addClass("active")
                }, function () {
                    //$popup.hide();
                    //$(this).removeClass("active")
                })
            } else if (s.undo && $this.find("ul.flexMenu-popup")) {
                $menu = $this.find("ul.flexMenu-popup");
                numToRemove = $menu.find("li").length;
                for (i = 1; i <= numToRemove; i++) $menu.find("li:first-child").appendTo($this);
                $menu.remove();
                $this.find("li.flexMenu-viewMore").remove()
            }
            //alert($("#mainNavbar").outerWidth());
        })
    }

})(jQuery);