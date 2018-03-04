// ta: TextArea
function getCurrentLine(ta) {
	var start = ta.selectionStart;
	var value = ta.value;
	if (value[start] === "\n") {
		// current char is "\n"
		start--;
	}

	while (start >= 0) {
		if (value[start--] === "\n") {
			start++;
			break;
		}
	}
	start++;

	var totalLen = value.length;
	var end = ta.selectionStart;
	while (end < totalLen) {
		if (value[end++] === "\n") {
			end--;
			break;
		}
	}

	// get the line from [start, end)
	if (end > start) {
		return value.substr(start, end - start);
	}
	return "";
}

// get selection if not empty; or else get current line text.
function getSelectionOrCurrentLine(ta) {
	var len = ta.selectionEnd - ta.selectionStart;
	var txt;
	if(len > 0) {
		txt = ta.value.substr(ta.selectionStart, len);
	}
	else {
		txt = getCurrentLine(ta);
	}

	return txt;
}

function getSelection (ta) {
	var len = ta.selectionEnd - ta.selectionStart;
	var txt;
	if(len > 0) {
		return ta.value.substr(ta.selectionStart, len);
	}
	return "";
}

// temp placed here. they will be moved to pi soon.
function commonTempInit() {

	// see pi.wrap.vfs.saveStr
	// TODO: support TYPE_ANSI_STRING...
	pi.wrap.vfs.writeFile = function (path, str, append){
		var flag = pi.native.vfs.FILE_OPEN_WRITE;
		if (!append) {
			flag |= pi.native.vfs.FILE_OPEN_WRITE_CLEAR;
		}
		var file = pi.native.vfs.openFile(path, flag);
		var result = false;
		if (file) {
			var r, len, cstr;
			cstr = pi.native.str.wstrToUtf8(str);
			len = pi.native.str.strlen(cstr);
			suc = pi.native.vfs.writeFile(file, 0, true, cstr, len);
			pi.native.mem.free(cstr);
			pi.native.vfs.closeFile(file);
			result = suc;
		}

		return result;
	}
}

// Start tortoise log UI.
// |path| can be root of git or sub directory or one specified file.
// |range| is the log range. 
//   eg: "commitA ^ commitB", "commitB..commitA".
//   See git-log.html for more help.
function showTortoiseLog(path, range) {
	path = path || cfgManager.config.src_path;
	var cmd = pi.native.str.format('TortoiseGitProc /command:log /path:"%s" /range:"%s"', path, range);
	pi.log("---cmd=" + cmd);
	pi.os.util.start(cmd);
}

// Simple format helper.
// eg: "abc{0}def{1}" with ["-x-", "-y-"] will result:
// "abc-x-def-y-"
function group_replace(str, replace_arr) {
    for (var i = replace_arr.length - 1; i >= 0; i--) {
        var replace = replace_arr[i];
        var reg = new RegExp("\\{" + i + "\\}", "g");
        str = str.replace(reg, replace);
    };
    return str;
}

function getToday() {
	var nd = new Date();
	var y = nd.getFullYear();
	var m = nd.getMonth() + 1;
	var d = nd.getDate();
	if (m <= 9) m = "0" + m;
	if (d <= 9) d = "0" + d;
	var cdate = y + "-" + m + "-" + d;
	return cdate;
}

/**
 * 获取指定的URL参数值
 * URL:http://www.quwan.com/index?name=tyler
 * 参数：paramName URL参数
 * 调用方法:getParam("name")
 * 返回值:tyler
 */
function getParam(paramName) {
	paramValue = "", isFound = !1;
	if (this.location.search.indexOf("?") == 0 && this.location.search.indexOf("=") > 1) {
		arrSource = unescape(this.location.search).substring(1, this.location.search.length).split("&"), i = 0;
		while (i < arrSource.length && !isFound) arrSource[i].indexOf("=") > 0 && arrSource[i].split("=")[0].toLowerCase() == paramName.toLowerCase() && (paramValue = arrSource[i].split("=")[1], isFound = !0), i++
	}
	return paramValue == "" && (paramValue = null), paramValue
}

// 从指定的id获取一个int值，失败返回指定的def值
function get_int(id, def) {
    var val = $("#" + id).val();
    val = parseInt(val);
    if (isNaN(val)) {
        return def;
    }
    return val;
}

// 保留point_len位小数，返回值仍然是Number
function float_point(src, point_len) {
    var tmp = Math.pow(10, point_len);
    return Math.round(src * tmp) / tmp;
}

/** JQuery Html Encoding、Decoding
 * 原理是利用JQuery自带的html()和text()函数可以转义Html字符
 * 虚拟一个Div通过赋值和取值来得到想要的Html编码或者解码
 * http://blog.csdn.net/phantomes/article/details/26570113
 */
//Html编码获取Html转义实体
function htmlEncode(value) {
	return $('<div/>').text(value).html();
}
//Html解码获取Html实体
function htmlDecode(value) {
	return $('<div/>').html(value).text();
}

function getName(wstr) {
	var start = wstr.lastIndexOf("/");
	if (start === -1) {
		start = wstr.lastIndexOf("\\");
		if (start === -1) {
			return wstr;
		}
	}
	return wstr.slice(start + 1);
}

function getDir(wstr) {
	var start = wstr.lastIndexOf("/");
	if (start === -1) {
		start = wstr.lastIndexOf("\\");
		if (start === -1) {
			return wstr;
		}
	}
	return wstr.substring(0, start);
}

function toRelPath(src, destRoot, sep) {
	var pattern = /\\|\//g;
	var srcArr = src.split(pattern);
	var destArr = destRoot.split(pattern);

	var index = Math.min(srcArr.length, destArr.length);
	for (var i = 0; i < index; i++) {
		if (srcArr[i].toLowerCase() !== destArr[i].toLowerCase()) {
			index = i;
			break;
		}
	}
	if (index === 0)
		return src;

	var r = "";
	for (i = index; i < destArr.length; i++) {
		r += ".." + sep;
	}
	for (i = index; i < srcArr.length; i++) {
		if (i != index)
			r += sep;
		r += srcArr[i];
	}
	return r;
}

function parseURI(url) {
	var m = String(url).replace(/^\s+|\s+$/g, '').match(/^([^:\/?#]+:)?(\/\/(?:[^:@]*(?::[^:@]*)?@)?(([^:\/?#]*)(?::(\d*))?))?([^?#]*)(\?[^#]*)?(#[\s\S]*)?/);
	// authority = '//' + user + ':' + pass '@' + hostname + ':' port
	return (m ? {
		href: m[0] || '',
		protocol: m[1] || '',
		authority: m[2] || '',
		host: m[3] || '',
		hostname: m[4] || '',
		port: m[5] || '',
		pathname: m[6] || '',
		search: m[7] || '',
		hash: m[8] || ''
	} : null);
}

function absolutizeURI(base, href) {// RFC 3986
	function removeDotSegments(input) {
		var output = [];
		input.replace(/^(\.\.?(\/|$))+/, '')
			.replace(/\/(\.(\/|$))+/g, '/')
			.replace(/\/\.\.$/, '/../')
			.replace(/\/?[^\/]*/g, function (p) {
				if (p === '/..') {
					output.pop();
				} else {
					output.push(p);
				}
			});
		return output.join('').replace(/^\//, input.charAt(0) === '/' ? '/' : '');
	}

	href = parseURI(href || '');
	base = parseURI(base || '');

	return !href || !base ? null : (href.protocol || base.protocol) +
	(href.protocol || href.authority ? href.authority : base.authority) +
	removeDotSegments(href.protocol || href.authority || href.pathname.charAt(0) === '/' ? href.pathname : (href.pathname ? ((base.authority && !base.pathname ? '/' : '') + base.pathname.slice(0, base.pathname.lastIndexOf('/') + 1) + href.pathname) : base.pathname)) +
	(href.protocol || href.authority || href.pathname ? href.search : (href.search || base.search)) +
	href.hash;
}

// 用中文字符替换非法路径字符
function RepalceInvalidateCharInFileName(fileName) {
	//fileName = fileName.replace("\\", "＼");
	//fileName = fileName.replace("/", "／");
	fileName = fileName.replace(/:/g, "：");
	fileName = fileName.replace("*", "＊");
	fileName = fileName.replace("?", "？");
	fileName = fileName.replace("\"", "＂");
	fileName = fileName.replace("<", "＜");
	fileName = fileName.replace(">", "＞");
	fileName = fileName.replace("|", "｜");
	return fileName;
}

// 根据reference equal来赋予每个不同的对象一个唯一的id。注意不要传入primitive value。
var id_array = [];
function getID(obj) {
	var len = id_array.length;
	for (var i = 0; i < len; i++) {
		if (id_array[i] === obj) {
			return i;
		}
	}
	id_array.push(obj);
	return len;
}

// log id helpler
function logID(obj, title) {
	console.log(title + " id: " + getID(obj));
}

function getOffsetY(ele) {
	var offset = 0;
	while(ele) {
		offset += ele.offsetTop;
		ele = ele.offsetParent;
	}
	return offset;
}
