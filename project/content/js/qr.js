(function () {
    json_encode = function (value) {
        return JSON.stringify(value)
    }

    json_decode = function (value) {
        return JSON.parse(value)
    }

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

    const mapTagInput = function (xs) {
        var d = {};
        for (x of xs) {
            var n = $(x).attr("name");
            var v = $(x).text();
            d[n] = v;
        }
        return d;
    }

    const removeFade = function (x) {
        $(x).fadeOut(TS, function () {
            $(this).remove();
        });
    }
    const removeUp = function (x) {
        $(x).slideUp(); (TS, function () {
            $(this).remove();
        });
    }

    const replaceBtn = function (x, y) {
        $(x).parent().replaceWith(y);
        // $(x).fadeOut(TS, function () {
        //     $(y).fadeIn(TS);
        // })
    }

    const replaceFade = function (x, y, t = TS) {
        $(y).css("display", "none");
        $(x).fadeOut(t / 2, function () {
            $(this).replaceWith(y);
            $(y).fadeIn(t);
        });
    }

    const createNone = function (x) {
        var y = $.parseHTML(x);
        $(y).css("display", "none");
        return y;
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

    var isCtrEtr = function (e) {
        return ((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)); //{
        //     f(dts);
        // }
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

    const jx_fd = function (action, jxd, rspf, lds, x = null, cbkSND = function () { }, cbkRSP = function () { }) {
        $(lds).fadeIn(TS, cbkSND());
        $.ajax({
            type: 'POST',
            url: webRoot + action,
            data: jxd,
            dataType: 'json',
            contentType: false,
            processData: false,
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

    const SND_fd = function (datas) {
        var action = datas.action;
        var jxd = datas.jxd;
        var rspf = datas.rspf;
        var lds = datas.lds;
        var x = datas.x;
        var cbkSND = datas.cbkSND;
        var cbkRSP = datas.cbkRSP;
        console.log("action", webRoot + action, "send: ", jxd);
        // console.log();
        jx_fd(action, jxd, rspf, lds, x, cbkSND, cbkRSP);
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

    removeDiscu = function (id, k, d) {
        var remove = window.confirm("Voulez-vous vraiment supprimer cette discussion?");
        if (remove) {
            var x = $("#" + id)[0];
            var map = { [k]: d };
            var param = mapToParam(map);
            var datasSND = {
                "action": ACTION_REMOVE_DISCU,
                "jxd": param,
                "rspf": removeDiscuRSP,
                "lds": "#isLoading",
                "x": x
            };
            SND(datasSND);
        }
    }

    openProfile = function (k, d) {
        var map = { [k]: d };
        var param = mapToParam(map);
        var datasSND = {
            "action": ACTION_OPEN_PROFILE,
            "jxd": param,
            "rspf": openProfileRSP,
            "lds": "#isLoading",
            "x": ""
        };
        SND(datasSND);
    }

    sendMessage = function (id) {
        var x = $("#" + id);
        var y = $(x).find(".msg_sender-container .msg_sender-input");
        var m = $(y).text();
        // $(y).text("");
        // var z = $(y).prev();
        // displayOn(z);
        if (m.length > 0) {
            var map = {
                [DISCU_ID]: id,
                [KEY_MESSAGE]: m
            };
            var param = mapToParam(map);
            var datasSND = {
                "action": ACTION_SEND_MSG,
                "jxd": param,
                "rspf": sendMessageRSP,
                "lds": "#isLoading",
                "x": { "x": x, "y": y }
            };
            SND(datasSND);
        }
    }

    readMessage = function (id) {
        var w = $("#" + id)[0];
        if ($(w).css("display") == "block") {
            var fd = new FormData();
            fd.append(DISCU_ID, id);
            var datasSND = {
                "action": ACTION_READ_MSG,
                "jxd": fd,
                "rspf": readMessageRSP,
                "lds": "#isLoading",
                "x": ""
            };
            SND_fd(datasSND);
        }
    }

    updateFeed = function (id) {
        var w = $("#" + id);
        var xs = $(w).find(".msg-wrap[data-msgstatus='" + MSG_STATUS_SEND + "'][data-sender='" + SENDER + "']");
        var d = {};
        d[DISCU_ID] = id;
        var l = $(w).find(".msg-wrap").last();
        var lm = {}
        var msgId = $(l).attr("data-msgid");
        lm[KEY_MSG_ID] = (msgId != null) ? msgId : null;
        // var lm = {
        //     [KEY_MSG_ID]: $(l).attr("data-msgid")//,
        //     // [KEY_STATUS]: $(l).attr("data-msgstatus"),
        // };
        d[KEY_LAST_MSG] = lm;
        d[KEY_MESSAGE] = [];
        var nb = xs.length;
        for (var i = 0; i < nb; i++) {
            var x = xs[i];
            var msgId = $(x).attr("data-msgid");
            var status = $(x).attr("data-msgstatus");
            var m = {
                [KEY_MSG_ID]: msgId,
                [KEY_STATUS]: status,
            };
            d[KEY_MESSAGE].push(m);
        }
        var fd = new FormData();
        fd.append(ACTION_UPDATE_FEED, json_encode(d));
        var datasSND = {
            "action": ACTION_UPDATE_FEED,
            "jxd": fd,
            "rspf": updateFeedRSP,
            "lds": "#isLoading",
            "x": ""
        };
        // console.log("d", d);
        SND_fd(datasSND);
    }

    lunchUpdate = function () {
        var ws = $(".msg-window");
        var nb = ws.length;
        for (var i = 0; i < nb; i++) {
            var id = $(ws[i]).attr("id");
            updateFeed(id);
        }
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

    const signOutRSP = function (r) {
        window.location.assign(r.results[ACTION_SIGN_OUT]);
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
                removeFade(p);
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
                var e = $.parseHTML(r.results[RSP_WRITE_MENU]);
                $(e).css("display", "none");
                $("#Demo1").prepend(e);
                $(e).slideDown(TS);
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

    const removeDiscuRSP = function (r) {
        if (r.isSuccess) {
            var discuID = r.results[ACTION_REMOVE_DISCU];
            var x = $("#Demo1 a[data-menudiscuid='" + discuID + "']");
            var y = $("#" + discuID);
            removeUp(x);
            removeFade(y);
        } else {
            if (r.errors[FATAL_ERROR] != null) {
                popAlert(r.errors[FATAL_ERROR].message);
            }
        }
    }

    const openProfileRSP = function (r) {
        if (r.isSuccess) {
            var w = $("#user_profile");
            $(w).find(".w3-panel").html(r.results[ACTION_OPEN_PROFILE]);
            fadeOn(w);
        } else {
            if (r.errors[FATAL_ERROR] != null) {
                popAlert(r.errors[FATAL_ERROR].message);
            }
        }
    }

    const updateProfileRSP = function (r) {
        if (r.isSuccess) {
            for (var k in r.results) {
                $("#id01 .data-key_value-value[name='" + k + "']").removeAttr("contenteditable");
            }
            if (r.results[KEY_PICTURE] != null) {
                $("#user_menu_profile").fadeOut(TS / 2, function () {
                    $(this).attr("src", r.results[KEY_PICTURE]);
                    $(this).fadeIn(TS);
                });
            }
        } else {
            for (var k in r.errors) {
                var x = $("#id01 .data-key_value-value[name='" + k + "']+");
                addErr(x, r.errors[k].message);
            }
            if (r.errors[FATAL_ERROR] != null) {
                popAlert(r.errors[FATAL_ERROR].message);
            }
        }
    }

    const sendMessageRSP = function (r, x) {
        if (r.isSuccess) {
            // var txt = $(x.y).text();
            $(x.y).text("");
            var z = $(x.y).prev();
            displayOn(z);

            var m = createNone(r.results[ACTION_SEND_MSG]);
            $(x.x).find(".msg-window-feed").append(m);
            $(m).fadeIn(TS);

            var id = r.results[DISCU_ID];
            var rx = $(".w3-bar-item[data-menudiscuid='" + id + "'] .w3-container p");
            var ry = createNone(r.results[KEY_LAST_MSG]);
            replaceFade(rx, ry);

            scrollBottom(x.x);
        } else {
            if (r.errors[FATAL_ERROR] != null) {
                popAlert(r.errors[FATAL_ERROR].message);
            }
        }
    }

    const readMessageRSP = function (r) {
        if (!r.isSuccess) {
            if (r.errors[FATAL_ERROR] != null) {
                popAlert(r.errors[FATAL_ERROR].message);
            }
        }
    }

    const updateFeedRSP = function (r) {
        if (r.isSuccess) {
            var id = r.results[DISCU_ID];
            var w = $("#" + id);
            if ((r.results[KEY_MSG_ID] != null) && (r.results[KEY_MSG_ID].length > 0)) {
                var s = r.results[MSG_STATUS_READ];
                for (var msgID of r.results[KEY_MSG_ID]) {
                    var ns = createNone(s);
                    var os = $(w).find(".msg-wrap[data-msgid='" + msgID + "'] .msg-status .o_symbol-wrap")[0];
                    replaceFade(os, ns);
                }
            }
            if ((r.results[KEY_MESSAGE] != null) && (r.results[KEY_MESSAGE].length > 0)) {
                var feed = $(w).find(".msg-window-feed");
                for (var m of r.results[KEY_MESSAGE]) {
                    var me = createNone(m);
                    $(feed).append(me);
                    $(me).fadeIn(TS);
                }
                scrollBottom(w);
            }
            if ((r.results[KEY_LAST_MSG] != null) && (r.results[KEY_LAST_MSG].length > 0)) {
                var rx = $(".w3-bar-item[data-menudiscuid='" + id + "'] .w3-container p");
                var ry = createNone(r.results[KEY_LAST_MSG]);
                replaceFade(rx, ry);
            }
            // setTimeout(() => {
            //     updateFeed(id);
            // }, TIME_UPDATE_FEED * 1000);
            readMessage(id);
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

        $("#log_out_btn").click(function () {
            var lo = window.confirm("Voulez-vous vraiment vous déconnecter?");
            if (lo) {
                var datasSND = {
                    "action": ACTION_SIGN_OUT,
                    "jxd": "",
                    "rspf": signOutRSP,
                    "lds": "#isLoading",
                    "x": ""
                };
                SND(datasSND);
            }
        });

        $("#setting_save_btn").click(function () {
            var e = $("#id01 .data-key_value-wrap .comment");
            cleanErr(e);
            var xs = $("#id01 span[contenteditable='true']");
            var map = mapTagInput(xs);
            var fd = new FormData();
            $("#edit_img_input")[0].files[0];
            var f = $("#edit_img_input")[0].files[0];
            (f != null) ? fd.append(KEY_PICTURE, f) : null;
            for (var n in map) {
                fd.append(n, map[n]);
            }
            var param = fd;
            var datasSND = {
                "action": ACTION_UPDATE_PROFILE,
                "jxd": param,
                "rspf": updateProfileRSP,
                "lds": "#isLoading",
                "x": ""
            };
            SND_fd(datasSND);
        });

        $(".msg-window .msg_sender-input").keydown(function (e) {
            if (isCtrEtr(e)) {
                var id = $(this).attr("data-btnId");
                $("#" + id).click();
            }
        });

    });
}).call(this);