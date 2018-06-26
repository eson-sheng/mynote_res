var http = require('http');
var url = require('url');
var util = require('util');
var fs = require('fs');
var querystring = require('querystring');//解析请求参数用

var form_html="<!DOCTYPE html>\n" +
    "<html lang=\"en\">\n" +
    "<head>\n" +
    "    <meta charset=\"UTF-8\">\n" +
    "    <title>你好世界</title>\n" +
    "</head>\n" +
    "<body>\n" +
    "<h1>Form</h1>" +
    "<form method=\"post\">\n" +
    "    <input name=\"name\" placeholder=\"name\"/><br/>\n" +
    "    <input name=\"age\" placeholder=\"age\"/><br/>\n" +
    "    <input type=\"submit\">\n" +
    "</form>" +
    "</body>\n" +
    "</html>";

http.createServer(function (request, response) {
    //发送 HTTP 头部 (HTTP状态值，内容类型)
    //response.writeHead(200, {'Content-Type': 'text/plain'});
    //response.end('Hello World!!!\n');//发送响应数据

    var params = '';

    var url_info=url.parse(request.url, true);
    //console.log(url_info);
    var pathname=url_info.pathname;

    request.on('data', function (chunk) {//接收post请求参数
        //console.log(chunk);
        params += chunk;
        //console.log(params);
    });

    request.on('end', function () {//请求完毕，输出结果
        response.writeHead(200, {'Content-Type': 'text/html; charset=utf8'});

        switch (pathname){
            case '/form'://测试 post
                params = querystring.parse(params);
                if(params.name && params.age) {//有 post 参数
                    response.write("<h1>Post Params</h1>");
                    response.write("name: " + params.name);
                    response.write("<br/>");
                    response.write("age: " + params.age);
                } else{  // 输出表单
                    response.write(form_html);
                }
                break;
            case '/index.html':
                var data = fs.readFileSync(pathname.substr(1));
                response.write(data.toString());
                break;
            default:
                if(url_info.search!==null){//有 get 参数
                    response.write("<h1>Get Params</h1>");
                    params = url.parse(request.url, true).query;
                    response.write("name: " + params.name);
                    response.write("<br/>");
                    response.write("age: " + params.age);
                    //response.write(util.inspect(url_info));//Content-Type:text/plain时可显示换行格式
                }else{//无 get 参数
                    response.write('<h1>默认页面</h1>');
                }
                break;
        }
        response.end();
    });
}).listen(8080);

console.log('访问地址为 http://127.0.0.1:8080/');
//测试 get 请求 http://localhost:8080/index.html
//测试 get 请求 http://localhost:8080/sdf?name=34&age=234
//测试 post 请求 http://localhost:8080/form