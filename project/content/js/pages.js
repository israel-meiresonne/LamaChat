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
        /*————————————————————— DISCUSSION PAGE UP ——————————————————————————*/
    });
}).call(this);