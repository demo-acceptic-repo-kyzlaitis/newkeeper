$(document).ready(function() {


    //$("form input[type=submit]").click(function() {
    //    var userEmail = $("input[type=text]").val();
    //    $.ajax({
    //        url: "/site/Subscribe",
    //        type: "POST",
    //        data: { email: userEmail },
    //
    //        success: function(data) {
    //            setSuccessMessage();
    //        },
    //        error: function(XMLHttpRequest, textStatus, errorThrown) {
    //            setFailMessage();
    //        },
    //        beforeSend: function(xhr, opts) {
    //            var email = $("input[type=text]").val();
    //            if(!IsEmail(email)) {
    //                wrongEmailFormat();
    //                xhr.abort();
    //            }
    //        }
    //    });
    //});


    $( "form" ).submit(function( event ) {
        event.preventDefault();
        var userEmail = $("input[type=text]").val();
        $.ajax({
            url: "/site/Subscribe",
            type: "POST",
            data: { email: userEmail },

            success: function(data) {
                setSuccessMessage();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                setFailMessage();
            },
            beforeSend: function(xhr, opts) {
                var email = $("input[type=text]").val();
                if(!IsEmail(email)) {
                    wrongEmailFormat();
                    xhr.abort();
                }
            }
        });
    });

    //$(document).keypress(function(e) {
    //    if(e.which == 13) {
    //        var userEmail = $("input[type=text]").val();
    //        $.ajax({
    //            url: "/site/Subscribe",
    //            type: "POST",
    //            data: { email: userEmail },
    //
    //            success: function(data) {
    //                setSuccessMessage();
    //            },
    //            error: function(XMLHttpRequest, textStatus, errorThrown) {
    //                setFailMessage();
    //            },
    //            beforeSend: function(xhr, opts) {
    //                var email = $("input[type=text]").val();
    //                if(!IsEmail(email)) {
    //                    wrongEmailFormat();
    //                    xhr.abort();
    //                }
    //            }
    //        });
    //    }
    //});

    //$(document).keypress(function(event) {
    //    if (event.which == 13) {
    //        console.log("shit");
    //
    //        event.preventDefault;
    //        $.ajax({
    //            url: "/site/Subscribe",
    //            type: "POST",
    //            data: { email: userEmail },
    //
    //            success: function(data) {
    //                setSuccessMessage();
    //            },
    //            error: function(XMLHttpRequest, textStatus, errorThrown) {
    //                setFailMessage();
    //            },
    //            beforeSend: function(xhr, opts) {
    //                var email = $("input[type=text]").val();
    //                if(!IsEmail(email)) {
    //                    wrongEmailForma();
    //                    xhr.abort();
    //                }
    //            }
    //        });
    //    }
    //});
});


function sendEmail() {
    if(e.which == 13) {
        var userEmail = $("input[type=text]").val();
        $.ajax({
            url: "/site/Subscribe",
            type: "POST",
            data: { email: userEmail },

            success: function(data) {
                setSuccessMessage();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                setFailMessage();
                return false;
            },
            beforeSend: function(xhr, opts) {
                var email = $("input[type=text]").val();
                if(!IsEmail(email)) {
                    wrongEmailFormat();
                    xhr.abort();
                }
            }
        });
        return false;
    }
}
//TODO  refactor to one method line 29 to 49

function setSuccessMessage() {
    $("p.p-subscribe").text("Спасибо");
    $("p.p-for").text("Ждите");
    $("p.p-when").text("Новостей!");
    $("input[type=text]").css("border-color", "white");
    $("input[type=text]").val("");
}

function setFailMessage() {
    $("p.p-subscribe").text("Ошибка");
    $("p.p-for").text("Вы уже внесены");
    $("p.p-when").text("в нашу рассылку");
    $("input[type=text]").css("border-color", "red");
}

function wrongEmailFormat() {
    $("p.p-subscribe").text("Ошибка");
    $("p.p-for").text("Неверный формат");
    $("p.p-when").text("e-mail");
    $("input[type=text]").css("border-color", "red");
}


function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}


    //$('.tooltip').tooltipster({
    //    theme: "my-custom-theme"
    //});

$(function() {
    $( document ).tooltip({
        position: {
            my: "center bottom-20",
            at: "center top",
            using: function(position, feedback) {
                $(this).css(position);
                $("<div>")
                    .addClass("arrow")
                    .addClass(feedback.vertical)
                    .addClass(feedback.horizontal)
                    .appendTo(this);
            }
        }
    });
});



