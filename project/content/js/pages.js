(function () {
    displayOn = function (x) {
        if (!($(x).css("display") == "block")) {
            $(x).removeClass("display_none");
        }
    }
    displayOff = function (x) {
        if (($(x).css("display") == "block")) {
            $(x).addClass("display_none");
        }
    }
    fadeOn = function (x, t = TS) {
        if (!($(x).css("display") == "block")) {
            $(x).addClass("zoom_in");
            $(x).fadeIn(t, function () {
                $(this).removeClass("zoom_in");
            });
        }
    }
    fadeOff = function (x, t = TS) {
        if (($(x).css("display") == "block")) {
            $(x).addClass("zoom_out");
            $(x).fadeOut(t, function () {
                $(this).removeClass("zoom_out");
            });
        }
    }
    $(document).ready(function () {
        /*————————————————————— SIGN PAGE DOWN ——————————————————————————————*/
        $("#sign_up_switcher, #sign_in_switcher").click(function () {
            var windId = this.getAttribute("data-window_id");
            var button = $(".switcher-button");
            var wind = $("#" + windId);
            var isDisplayed = $(wind).css("display") == "block";
            var sib = $(wind).siblings();
            console.log(wind);
            console.log(sib);
            if (!isDisplayed) {
                $(button).toggleClass("blue-button-focus");
                $(button).toggleClass("blue-button-unfocus");
                $(sib).fadeOut(TS / 2, function () {
                    $(wind).fadeIn(TS / 2, function () {
                        $(wind).removeClass("display_none");
                    });
                });

            }
        });
        /*————————————————————— SIGN PAGE UP ————————————————————————————————*/
        /*————————————————————— DISCUSSION PAGE DOWN ————————————————————————*/
        $('.msg_sender-input').keyup(function () {
            var p = $(this).prev();
            displayOff(p);
            if (($(this).text() == "")) {
                displayOn(p);
            } else {
                displayOff(p);
            }
        });
        $("#setting_button").click(function () {
            var x = $("#id01");
            fadeOn(x);
        });
        $("#setting_close_button").click(function () {
            var x = $("#id01");
            fadeOff(x);
        });
        /*————————————————————— DISCUSSION PAGE UP ——————————————————————————*/
    });
}).call(this);