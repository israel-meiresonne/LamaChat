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
    updateImg = function(img, inp){
        var f = inp.files[0];
        img.src = window.URL.createObjectURL(f);
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
        $(".setting-content .data-key_value-value").click(function(){
            $(this).attr("contenteditable", true);
            $(this).focus();
        });
        $("#edit_img_btn").click(function(){
            $("input[type='file']").click();
        });
        $("#edit_img_input").change(function () {
            var img =  $("#edit_img")[0];
            updateImg(img, this);
        });

        $("#contact_button").click(function () {
            var x = $("#contact_window");
            fadeOn(x);
        });
        $("#contact_close_button").click(function () {
            var x = $("#contact_window");
            fadeOff(x);
        });
        
        $("#search_button").click(function () {
            var x = $("#search_window");
            fadeOn(x);
        });
        $("#search_close_button").click(function () {
            var x = $("#search_window");
            fadeOff(x);
        });
        /*————————————————————— DISCUSSION PAGE UP ——————————————————————————*/
    });
}).call(this);