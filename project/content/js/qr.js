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

    const replaceBtn = function (x, y) {
        $(x).parent().replaceWith(y);
        // $(x).fadeOut(TS, function () {
        //     $(y).fadeIn(TS);
        // })
    }

    var isTyping;
    endKeyup = function () {
        var a = arguments;
        window.addEventListener('keyup', function (event) {
            window.clearTimeout(isTyping);
            isTyping = setTimeout(function () {
                a[0](a[1]);
            }, TS * 1.5);
        }, false);
    }


    const jx = function (action, jxd, rspf, lds, x = null, cbkSND = function () { }, cbkRSP = function () { }) {
        $(lds).fadeIn(TS, cbkSND());
        $.ajax({
            type: 'POST',
            url: webRoot + action,
            data: jxd,
            dataType: 'json',
            success: function (r) {
                console.log("response: ", r);
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
        console.log("action", webRoot + action, "send: ", jxd);
        // console.log();
        jx(action, jxd, rspf, lds, x, cbkSND, cbkRSP);
    }

    searchContact = function (d) {
        var map = { [RSP_SEARCH_KEY]: d };
        var param = mapToParam(map);
        var datasSND = {
            "action": ACTION_SEARCH_CONTACT,
            "jxd": param,
            "rspf": searchRSP,
            "lds": "#isLoading",
        };
        SND(datasSND);
    }

    addContact = function (id, k, d) {
        var map = { [k]: d };
        var param = mapToParam(map);
        // var x = $("#search_window button[onclick=\"addContact('" + k + "', '" + d + "')\"]")[0];
        var x = $("#" + id)[0];
        var datasSND = {
            "action": ACTION_ADD_CONTACT,
            "jxd": param,
            "rspf": addContactRSP,
            "lds": "#isLoading",
            "x": x
        };
        SND(datasSND);
    }

    removeContact = function (id, k, d) {
        var remove = window.confirm("Voulez-vous vraiment supprimer ce contact?");
        if (remove) {
            var map = { [k]: d };
            var param = mapToParam(map);
            // var x = $("#contact_window button[onclick=\"removeContact('" + k + "', '" + d + "')\"]")[0];
            var x = $("#" + id)[0];
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

    blockContact = function (id, k, d) {
        var remove = window.confirm("Voulez-vous vraiment bloquer ce contact?");
        if (remove) {
            var map = { [k]: d };
            var param = mapToParam(map);
            // var x = $("#contact_window button[onclick=\"blockContact('" + k + "', '" + d + "')\"]")[0];
            var x = $("#" + id)[0];
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

    unlockContact = function (id, k, d) {
        var map = { [k]: d };
        var param = mapToParam(map);
        // var x = $("#contact_window button[onclick=\"unlockContact('" + k + "', '" + d + "')\"]")[0];
        var x = $("#" + id)[0];
        var datasSND = {
            "action": ACTION_UNLOCK_CONTACT,
            "jxd": param,
            "rspf": unlockContactRSP,
            "lds": "#isLoading",
            "x": x
        };
        SND(datasSND);
    }

    writeContact = function (id, k, d) {
        var map = { [k]: d };
        var param = mapToParam(map);
        // var x = $("#contact_window button[onclick=\"writeContact('" + k + "', '" + d + "')\"]")[0];
        var x = $("#" + id)[0];
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
            window.location.assign(r.results[ACTION_SIGN_UP]);
        } else {
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
            window.location.assign(r.results[ACTION_SIGN_IN]);
        } else {
            var ks = Object.keys(r.errors);
            ks.forEach(k => {
                var x = $("#sign_in_form input[name='" + k + "'] + .comment");
                var err = r.errors[k].message;
                addErr(x, err);
                (k == FATAL_ERROR) ? popAlert(r.errors[k].message) : null;
            });
        }
    }

    const searchRSP = function (r) {
        if (r.isSuccess) {
            $("#search_window .contact-table").html(r.results[RSP_SEARCH_KEY]);
        } else {
            if (r.errors[FATAL_ERROR] != null) {
                popAlert(r.errors[FATAL_ERROR].message);
            }
        }
    }

    const addContactRSP = function (r, x) {
        if (r.isSuccess) {
            var y = r.results[ACTION_ADD_CONTACT];
            replaceBtn(x, y);
        } else {
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const removeContactRSP = function (r, x) {
        if (r.isSuccess) {
            var wId = $(x).attr("data-window");
            console.log(x);
            console.log(wId);
            if (wId == "contact_window") {
                var p = $(x).parent().parent()[0];
                removeTag(p);
            } else if (wId == "search_window") {
                addContactRSP(r, x);
            }
        } else {
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const blockContactRSP = function (r, x) {
        if (r.isSuccess) {
            var y = r.results[ACTION_BLOCK_CONTACT];
            replaceBtn(x, y);
        } else {
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const unlockContactRSP = function (r, x) {
        if (r.isSuccess) {
            var y = r.results[ACTION_UNLOCK_CONTACT];
            replaceBtn(x, y);
        } else {
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const writeRSP = function (r, x) {
        if (r.isSuccess) {
            var chat = $("#" + r.results[DISCU_ID]);
            var wId = $(x).attr("data-windCloseBtn");
            var closeBtn = $("#" + wId + " .w3-button")[0];
            if (chat.length == 0) {
                $(closeBtn).click();
                $("#Demo1").prepend(r.results[RSP_WRITE_MENU]);
                $("#discussion_feed .content").prepend(r.results[RSP_WRITE_DISCU_FEED]);
            } else {
                $(closeBtn).click();
            }
            var m = $("nav a[data-menuDiscuId='" + r.results[DISCU_ID] + "']")[0];
            $(m).click();
        } else {
            popAlert(r.errors[FATAL_ERROR].message);
        }
    }

    const getContactTableRSP = function (r, d) {
        if (r.isSuccess) {
            $(d.y).html(r.results[ACTION_GET_CONTACT_TABLE]);
            fadeOn(d.x);
        } else {
            if (r.errors[FATAL_ERROR] != null) {
                popAlert(r.errors[FATAL_ERROR].message);
            }
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
        // var c = function (m) {
        //     console.log(m);
        // }
        $("#search_contact_input").keyup(function () {
            var d = $(this).text();
            // ((m != "") && (m != null)) ? endKeyup(searchContact, m) : null;
            endKeyup(searchContact, d);
        });

        $("#contact_button").click(function () {
            var x = $("#contact_window")[0];
            var y = $("#contact_window .setting-content")[0];
            var datasSND = {
                "action": ACTION_GET_CONTACT_TABLE,
                "jxd": "",
                "rspf": getContactTableRSP,
                "lds": "#isLoading",
                "x": { "x": x, "y": y }
            };
            SND(datasSND);
        });
    });
}).call(this);