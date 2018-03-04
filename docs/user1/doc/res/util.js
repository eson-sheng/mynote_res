var __log = false;
var touchTarget;
var config;
var load_count = 0;
var load_arr = [
    "/doc/res/jquery-1.10.2.js",
    "/tools/config.js",
    "/tools/pi.js"
];

function log(s, force) {
    console.log(s);
    if (__log || force) {
        $.ajax({
            async: true,//使用同步的Ajax请求
            type: "GET",
            url: "/tools/debug.php",
            data: "content=" + encodeURIComponent(s),
        });
    }
}

function gestureWork() {
    var touchStart;
    var lastPt;
    var startTime;
    var gestArr = [];
    var d_angle = Math.PI / 16; // 偏离角度
    var halfPI = Math.PI / 2;
    var vertical = Math.tan(halfPI - d_angle);
    var oblique1 = Math.tan(halfPI / 2 - d_angle);
    var oblique2 = Math.tan(halfPI / 2 + d_angle);
    var horizontal = Math.tan(d_angle);

    function getOneGest(dx, dy) {
        if (Math.abs(dx) < 3 && Math.abs(dy) < 3)
            return "none";
        if (dx === 0 && dy === 0)
            return "none";
        else if (dx === 0) {
            return dy > 0 ? "down" : "up";
        }
        else {
            var ratio = dy / dx;
            if (dx > 0) {
                if (ratio < -vertical)
                    return "up";
                else if (ratio > -oblique2 && ratio < -oblique1)
                    return "right-up";
                else if (ratio > -horizontal && ratio < horizontal)
                    return "right";
                else if (ratio > oblique1 && ratio < oblique2)
                    return "right-down";
                else if (ratio > vertical)
                    return "down";
                else
                    return "none";
            }
            else {
                // dx < 0
                if (ratio < -vertical)
                    return "down";
                else if (ratio > -oblique2 && ratio < -oblique1)
                    return "left-down";
                else if (ratio > -horizontal && ratio < horizontal)
                    return "left";
                else if (ratio > oblique1 && ratio < oblique2)
                    return "left-up";
                else if (ratio > vertical)
                    return "up";
                else
                    return "none";
            }
            return "none";
        }
    }

    function sumGust(target) {
        // log(gestArr.join(", "));
        var count = gestArr.reduce(function (count, item) {
            if (item === "right") {
                return count + 1;
            }
            return count;
        }, 0);
        var time = Date.now() - startTime;
        log("right count: " + count + ", time=" + time + "ms");
        // 300ms以内，并且70%都是right手势
        if (count > 3 && count / gestArr.length > 0.7 && time < 300) {
            touchTarget = target;
            show_menu(touchStart.pageY);
        }
    }

    (function init() {
        window.addEventListener("touchstart", function (e) {
            // log("window:" + e.touches[0].clientX + " ," + e.touches[0].clientY);
        });
        var body = document.body;
        body.addEventListener("touchstart", function (e) {
            log("touchstart");
            lastPt = {"x": e.touches[0].clientX, "y": e.touches[0].clientY};
            startTime = Date.now();
            gestArr = [];
        });
        body.addEventListener("touchmove", function (e) {
            touchStart = e.touches[0];
            var thisPt = {"x": touchStart.clientX, "y": touchStart.clientY};
            var dx = thisPt.x - lastPt.x;
            var dy = thisPt.y - lastPt.y;
            var gest = getOneGest(dx, dy);
            if (gest !== "none")
                gestArr.push(gest);
            lastPt = thisPt;
        })
        body.addEventListener("touchend", function (e) {
            log("end");
            sumGust(e.target);
        })
        body.addEventListener("touchcancel", function (e) {
            log("cancel");
            sumGust(e.target);
        })
    })();
}

load = function (doc, head, url, charset, isCss, callback) {
    var node = doc.createElement(isCss ? 'link' : 'script');
    node.charset = charset;
    node.readyState = undefined;
    node.onerror = function () {
        node.onload = node.onerror = node.onreadystatechange = undefined;
        head.removeChild(node);
        callback(false);
    };
    node.onload = node.onreadystatechange = function () {
        // Ensure only run once and handle memory leak in IE
        node.onload = node.onerror = node.onreadystatechange = undefined;
        // Remove the script to reduce memory leak
        if (!isCss) {
            head.removeChild(node);
        }
        callback(true);
    };
    if (isCss) {
        node.rel = 'stylesheet';
        node.href = url;
    } else {
        node.async = true;
        node.src = url;
    }
    head.appendChild(node);
};

for (var i in load_arr) {
    load(document, document.head, load_arr[i], "utf-8", false, load_callback);
}

function load_callback() {
    load_count++;
    if (load_count < load_arr.length) {
        return;
    }
    log("all js loaded.");
    $(window).resize(function () {
        on_resized();
    });

    var menu = document.createElement("div");
    document.body.appendChild(menu);
    menu.outerHTML =
        '	<div id="fm_menu_content" style="display: none; font-size: 2em; margin-top: 1em">' +
        '	    <div onclick="close_menu(event)" style="padding: 1em 0em">close</div>' +
        '	    <div onclick="switch_wrap(event)" class="checked">auto wrap</div>' +
        '	    <div onclick="set_font(event)" style="border: dotted; margin: 0.2em 0em;"><input id="ipt_font" placeholder="input a number for font" style="width: 100%"/><br><br>press to enter</div>' +
        '	    <div onclick="set_body_width(event)" style="border: dotted; margin: 0.2em 0em;"><input id="ipt_body" placeholder="input a number for body width" style="width: 100%"/><br><br>press to enter</div>' +
        '	    <div onclick="out_info(event)">out info</div>' +
        '	    <div onclick="set_zoom(event)">set zoom</div>' +
        '	</div>';

    // 需要在菜单创建之后
    config = createConfig("config_save_path", ["ipt_font", "ipt_body"]);

    // do some init works..
    set_font();
    set_body_width();
    $("input").css("font-size", "1em");
    //$("body").css("width", screen.width * 2 + "px");
    on_resized();
    gestureWork();
}

function on_resized(event) {
    $("#fm_menu_content").css("width", $("body").outerWidth(true) + "px");
}

function show_menu(paageY) {
    $("#fm_menu_content").css("display", "block");
    $("#fm_menu_content").css("top", paageY + "px");
}
function close_menu(event) {
    $("#fm_menu_content").css("display", "none");
}

function switch_wrap(event) {
    var div = $(event.target);
    div.toggleClass("checked");
    if (div.hasClass("checked")) {
        $("pre").removeClass("nowrap");
    }
    else {
        $("pre").addClass("nowrap");
    }
    close_menu();

    // from common.js
    function getOffsetY(ele) {
        var offset = 0;
        while(ele) {
            offset += ele.offsetTop;
            ele = ele.offsetParent;
        }
        return offset;
    }

    // switch后的显示位置未知，因此scroll到接收手势的target元素
    window.scrollTo(0, getOffsetY(touchTarget));
}

function set_font(event) {
    if (event && event.target.tagName !== "DIV")
        return;
    config.saveCtrls();
    var size = $("#ipt_font").val() || "2";
    document.body.style.fontSize = size + "em";
    close_menu();
}

function set_body_width(event) {
    if (event && event.target.tagName !== "DIV")
        return;
    config.saveCtrls();
    var size = $("#ipt_body").val();
    if (size) {
        document.body.style.width = size + "px";
    }
    close_menu();
}

function out_info(event) {
    var s = "screen: " + window.screen.width + ", " + screen.height + "\n";
    s += "body: " + document.body.clientWidth + ", " + document.body.clientHeight + "\n";
    s += "zoom: " + document.getElementsByTagName('body')[0].style.zoom + "\n";
    s += "body font size: " + document.body.style.fontSize + "\n";
    log(s, true);
}

function set_zoom(event) {
    document.getElementsByTagName('body')[0].style.zoom = 2;
    close_menu();
}
