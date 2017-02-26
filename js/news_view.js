/*$.colorbox({
						top:" 0%",
						opacity: 0.5,
						transition: "fade",
						speed:100,
						overlayClose: false,
						buttonClose: true,
						html:$("#id_view").html(),
                        onOpen:
                            function(){
								$("#cboxOverlay").css("overflow-y","scroll");
                                $("body").css("padding-right","15px");
                            },
						onComplete:
							function(){
                                $("#colorbox").appendTo("#cboxOverlay");
                                styles = {
                                    position: "absolute",
                                    width: "100%",
                                    height: "200px",
                                    top: "210%",
                                    display: "block"
                                };
                                var clear = "<div style=\"clear:both;\"></div>";
                                
                                $(".popup_news").css("min-height",$(window).height()-200);
                                window.onresize = function () {
                                    width = document.documentElement.clientWidth;
                                    height = document.documentElement.clientHeight;
                                    $(".popup_news").css("min-height",height-200);
                                }

                                $(clear).appendTo("#cboxWrapper > div").eq(1);
                                $(clear).appendTo("#colorbox");
                                $("#cboxContent,#cboxLoadedContent,#cboxWrapper").css("height","auto");
                                $("#cboxOverlay").css("background","rgba(0, 0, 0, 0.7)");
								mouse_in_bool = false;
								$("body").css("overflow","hidden");
                                var pop_height = $("#cboxWrapper").height() + 100;
								$("#colorbox").css({"top":"0px","height":pop_height});
								$("#cboxOverlay").css("position","fixed");
                                
    							$("#cboxOverlay").css("opacity","1");
								$("#mww").show();
								$("#cboxOverlay").on("mouseover",function(){
									$("#cboxOverlay").css("cursor","pointer");
								});
								$("#cboxOverlay").on("mouseout",function(){
									$("#cboxOverlay").css("cursor","default");									
								});
								ht = $(".popup_news:last").outerHeight();
								ht /= 6.6;
								$("#remove_me").css("top",ht+"%");
									
								$("#cboxOverlay").on("click",function(){
									if (!mouse_in_bool)
										$.colorbox.close();
								});
						   	},
						onClosed: 
							function(){
     							$("#remove_me").remove();
								$("#cboxOverlay").css("overflow-y","hidden");
								$("#mww").hide();
								$("#content").css("left","").fadeIn("100");
								$("#main_head").css("left","").fadeIn("100");
								$("#colorbox").appendTo("body");
								$("#cboxOverlay").css("position","");
								$("#cboxOverlay").css("background","#fff");
								$("#cboxOverlay").css("overflow-y","");
								$("body").css("overflow","auto");
                                $("body").css("padding-right","0");
								$("#cboxOverlay").css("opacity","0.5");
							}
					});*/