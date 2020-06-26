(function () {
    var addErr = function (x, err) {
        $(x).text(err);
        $(x).slideDown(TS);
    }


    const jx = function (action, jxd, rspf, lds, cbkSND = function () { }, cbkRSP = function () { }) {
        $(lds).fadeIn(TS, cbkSND());
        $.ajax({
            type: 'POST',
            url: window.location.pathname + "/" + action,
            data: jxd,
            dataType: 'json',
            success: function (r) {
                $(lds).fadeOut(TS, cbkRSP());
                rspf(r);
            }
        });
    }

    const SND = function (datas) {
        var action = datas.action;
        var jxd = datas.jxd;
        var rspf = datas.rspf;
        var lds = datas.lds;
        var cbkSND = datas.cbkSND;
        var cbkRSP = datas.cbkRSP;
        console.log("action", window.location.pathname + "/" + action);
        console.log("send:", jxd);
        jx(action, jxd, rspf, lds, cbkSND, cbkRSP);
    }

    const signUpRSP = function (r) {
        if (!r.isSuccess) {
            console.log("rsp fail: ", r);
            var ks = Object.keys(r.errors);
            ks.forEach(k => {
                var x = $("#sign_up_form input[name='"+ k +"'] + .comment");
                var err = r.errors[k].message;
                addErr(x, err);
            });
        }
    }

    $(document).ready(function () {
        $("#sign_up_button").click(function () {
            var formId = $(this).attr("for");
            var param = $("#" + formId + " input").serialize();
            var datasSND = {
                "action": ACTION_SIGN_UP,
                "jxd": param,
                "rspf": signUpRSP,
                "lds": "#isLoading",
                // "cbkSND": null,
                // "cbkRSP": null
            };
            SND(datasSND)
            // console.log(formId);
            // console.log(param);
        });
    });
}).call(this);