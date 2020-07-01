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

    const mapToParam = function (map) {
        return jQuery.param(map);
    }

    const removeTag = function (x) {
        $(x).fadeOut(TS, function () {
            $(this).remove();
        });
    }

    const animReplace = function (x, y) {
        $(x).fadeOut(TS, function () {
            $(this).parent().replaceWith(y);
            $(y).fadeIn(TS);
        })
    }


    const jx = function (action, jxd, rspf, lds, x = null, cbkSND = function () { }, cbkRSP = function () { }) {
        $(lds).fadeIn(TS, cbkSND());
        $.ajax({
            type: 'POST',
            url: webRoot + action,
            data: jxd,
            dataType: 'json',
            success: function (r) {
                $(lds).fadeOut(TS, cbkRSP());
                rspf(r, x);
            }
        });
    }

    const SND = function (datas) {
        var action = datas.action;
        var jxd = datas.jxd;
        var rspf = datas.rspf;
        var lds = datas.lds;
        var x = datas.x;
        var cbkSND = datas.cbkSND;
        var cbkRSP = datas.cbkRSP;
        console.log("action", webRoot + action);
        console.log("send:", jxd);
        jx(action, jxd, rspf, lds, x, cbkSND, cbkRSP);
    }

    addContact = function (k, d) { }

    removeContact = function (k, d) {
        var remove = window.confirm("Voulez-vous vraiment supprimer ce contact?");
        if (remove) {
            var map = { [k]: d };
            var param = mapToParam(map);
            var x = $("#contact_window button[onclick=\"removeContact('" + k + "', '" + d + "')\"]")[0];
            var datasSND = {
                "action": ACTION_REMOVE_CONTACT,
                "jxd": param,
                "rspf": removeContactRSP,
                "lds": "#isLoading",
                "x": x
            };
            SND(datasSND);
            // console.log(k, d);
        }
    }

    blockContact = function (k, d) {
        var remove = window.confirm("Voulez-vous vraiment bloquer ce contact?");
        if (remove) {
            var map = { [k]: d };
            var param = mapToParam(map);
            var x = $("#contact_window button[onclick=\"blockContact('" + k + "', '" + d + "')\"]")[0];
            var datasSND = {
                "action": ACTION_BLOCK_CONTACT,
                "jxd": param,
                "rspf": blockContactRSP,
                "lds": "#isLoading",
                "x": x
            };
            SND(datasSND);
        }
    }

    unlockContact = function (k, d) {
        var map = { [k]: d };
        var param = mapToParam(map);
        var x = $("#contact_window button[onclick=\"unlockContact('" + k + "', '" + d + "')\"]")[0];
        var datasSND = {
            "action": ACTION_UNLOCK_CONTACT,
            "jxd": param,
            "rspf": unlockContactRSP,
            "lds": "#isLoading",
            "x": x
        };
        SND(datasSND);
    }

    writeContact = function (k, d) {
        var map = { [k]: d };
        var param = mapToParam(map);
        var x = $("#contact_window button[onclick=\"writeContact('" + k + "', '" + d + "')\"]")[0];
        var datasSND = {
            "action": ACTION_WRITE_CONTACT,
            "jxd": param,
            "rspf": writeRSP,
            "lds": "#isLoading",
            "x": x
        };
        SND(datasSND);
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

    const removeContactRSP = function (r, x) {
        if (r.isSuccess) {
            console.log("rsp success: ", r);
            var p = $(x).parent().parent()[0];
            removeTag(p);
        } else {
            console.log("rsp fail: ", r);
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const blockContactRSP = function (r, x) {
        if (r.isSuccess) {
            console.log("rsp success: ", r);
            var y = r.results[ACTION_BLOCK_CONTACT];
            animReplace(x, y);
        } else {
            console.log("rsp fail: ", r);
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const unlockContactRSP = function (r, x) {
        if (r.isSuccess) {
            console.log("rsp success: ", r);
            var y = r.results[ACTION_UNLOCK_CONTACT];
            animReplace(x, y);
        } else {
            console.log("rsp fail: ", r);
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const writeRSP = function (r, x) {
        if (r.isSuccess) {
            console.log("rsp success: ", r);
            console.log(x);
            var chat = $("#" + r.results[DISCU_ID]);
            var wId = $(x).attr("data-windCloseBtn");
            var closeBtn = $("#" + wId + " .w3-button")[0];
            console.log("wId", wId);
            console.log("closeBtn", closeBtn);
            if (chat.length == 0) {
                $(closeBtn).click();
                $("#Demo1").prepend(r.results[RSP_WRITE_MENU]);
                $("#discussion_feed .content").prepend(r.results[RSP_WRITE_DISCU_FEED]);
            } else {
                $(closeBtn).click();
            }
            var m = $("nav a[data-menuDiscuId='"+ r.results[DISCU_ID] +"']")[0];
            $(m).click();
        } else {
            console.log("rsp fail: ", r);
            console.log(x);
            popAlert(r.errors[FATAL_ERROR].message);
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
        });
    });
}).call(this);