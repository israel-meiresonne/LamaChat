(function () {
    var addErr = function (x, err) {
        $(x).text(err);
        $(x).slideDown(TS);
    }

    var cleanErr = function (x) {
            $(x).text("");
    }

    popAlert = function (msg) {
        window.alert(msg);
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
        if (r.isSuccess) {
            console.log("rsp success: ", r);
            window.location.assign(r.results[ACTION_SIGN_UP]);
        } else {
            console.log("rsp fail: ", r);
            var ks = Object.keys(r.errors);
            ks.forEach(k => {
                var x = $("#sign_up_form input[name='" + k + "'] + .comment");
                var err = r.errors[k].message;
                addErr(x, err);
                (k == FATAL_ERROR) ? popAlert(r.errors[k].message) : null;
            });
        }
    }

    const signInRSP = function (r) {
        if (r.isSuccess) {
            console.log("rsp success: ", r);
            window.location.assign(r.results[ACTION_SIGN_IN]);
        } else {
            console.log("rsp fail: ", r);
            var ks = Object.keys(r.errors);
            ks.forEach(k => {
                var x = $("#sign_in_form input[name='" + k + "'] + .comment");
                var err = r.errors[k].message;
                addErr(x, err);
                (k == FATAL_ERROR) ? popAlert(r.errors[k].message) : null;
            });
        }
    }

    $(document).ready(function () {
        $("#sign_up_button").click(function () {
            var formId = $(this).attr("for");
            var err = $("#" + formId + " input + .comment");
            cleanErr(err);
            var param = $("#" + formId + " input").serialize();
            var datasSND = {
                "action": ACTION_SIGN_UP,
                "jxd": param,
                "rspf": signUpRSP,
                "lds": "#isLoading",
            };
            SND(datasSND);
            // console.log(formId);
            // console.log(param);
        });

        $("#sign_in_button").click(function () {
            var formId = $(this).attr("for");
            var err = $("#" + formId + " input + .comment");
            cleanErr(err);
            var param = $("#" + formId + " input").serialize();
            var datasSND = {
                "action": ACTION_SIGN_IN,
                "jxd": param,
                "rspf": signInRSP,
                "lds": "#isLoading",
            };
            SND(datasSND);
            // console.log(formId);
            // console.log(param);
        });
    });
}).call(this);