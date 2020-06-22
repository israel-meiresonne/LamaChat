(function () {
    TS = 450;
    BNR = 1000000;

    randomInt = function (number) {
        return parseInt(Math.random() * number);
    }

    animateInput = function (selector) {
        selector.classList.remove("input-error");
        var wrapper = selector.parentNode;

        $(wrapper).find(".comment").slideUp(TS, function () {
            $.text("");
        });

        var container = wrapper.parentNode;

        var containerId = "input_" + randomInt(BNR);
        container.setAttribute("id", containerId);

        var inputTag = container.getElementsByTagName("input")[0];
        if (inputTag.value == '') {
            $("#" + containerId + ' label').slideUp(TS);
            $("#" + containerId + ' input').animate({ padding: '15px 5px 0' }, TS);
            $("#" + containerId + ' span').animate({ top: '11px' }, TS);
        } else {
            $("#" + containerId + ' label').slideDown(TS);
            $("#" + containerId + ' input').animate({ padding: '1.3em 5px 0' }, TS);
            $("#" + containerId + ' span').animate({ top: '22px' }, TS);
        }
        container.removeAttribute("id");
    }
    $(document).ready(function () {
        /*—————————————————— INPUT DOWN —————————————————————————————————————*/
        $('.input-tag').keyup(function () {
            animateInput(this);
        });
        $('.input-tag').change(function () {
            animateInput(this);
        });
        /*———————————————————— INPUT UP —————————————————————————————————————*/


    });
}).call(this);