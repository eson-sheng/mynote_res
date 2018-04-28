为本目录配置虚拟域名www.crawler.com

本程序利用fiddler替换百度搜查页面的jquery文件，替换为本目录下的replace.js

jsonp通过下面url访问服务器的脚本，并将其作为js文件执行：
https://www.crawler.com/crawler/server.php

首次调用jsonp时，页面会弹框提示证书不对，需点击继续。