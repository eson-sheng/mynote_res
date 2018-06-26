var http = require('http');
//使用 Node 创建 Web 客户端
//当web.js正在运行时，新打开一个命令窗口运行此脚本，可模拟浏览器向服务端发送请求

var req = http.request({// 向服务端发送请求
    host: 'localhost',
    port: '8080',
    path: '/index.html'
}, function(response){
    var html = '';// 不断更新数据
    response.on('data', function(data) {
        html += data;
    });
    response.on('end', function() {
        console.log(html);// 数据接收完成
    });
});
req.end();
