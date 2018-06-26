//npm install ... --save 中的 --save 是将安装的包信息存入 package.json。
//如果有package.json且当中已包含下面四个包，则可以直接执行cnpm install。
var express = require('express');//cnpm install express --save
var bodyParser = require('body-parser');//cnpm install body-parser --save
var multer  = require('multer');//cnpm install multer --save
var cookieParser = require('cookie-parser');//cnpm install cookie-parser --save
var fs  = require('fs');
var util = require('util');

var app = express();

app.use(express.static('public'));//???使用此句后仍无法访问目录内的图片http://127.0.0.1:8081/public/cat.jpg

var urlencodedParser = bodyParser.urlencoded({ extended: false });// 创建 application/x-www-form-urlencoded 编码解析
app.use(multer({ dest: '/tmp/'}).array('uploadfile1'));
app.use(cookieParser());

app.get('/', function (req, res) {//  主页输出 "Hello World"
    console.log("主页 GET 请求");
    req.cookies={aa:11,bb:22};
    console.log("Cookies: " + util.inspect(req.cookies));
    res.send('Hello GET');
});
app.post('/', function (req, res) {//  POST 请求
    console.log("主页 POST 请求");
    res.send('Hello POST');
});
app.get('/del_user', function (req, res) {//  /del_user 页面响应
    console.log("/del_user 响应 DELETE 请求");
    res.send('删除页面');
});
//  /list_user 页面 GET 请求
app.get('/list_user', function (req, res) {
    console.log("/list_user GET 请求");
    res.send('用户列表页面');
});
// 对页面 abcd, abxcd, ab123cd, 等响应 GET 请求
app.get('/ab*cd', function(req, res) {
    console.log("/ab*cd GET 请求");
    res.send('正则匹配');
});

app.get('/index.html', function (req, res) {
    res.sendFile( __dirname + "/" + "index.html" );
});
app.get('/process_get', function (req, res) {//get表单
    var response = {// 输出 JSON 格式
        "first_name":req.query.first_name,
        "last_name":req.query.last_name
    };
    console.log(response);
    res.end(JSON.stringify(response));
});
app.post('/process_post', function (req, res) {//post表单
    var response = {// 输出 JSON 格式
        "first_name":req.query.first_name,
        "last_name":req.query.last_name
    };
    console.log(response);
    res.end(JSON.stringify(response));
});
app.post('/file_upload', function (req, res) {//文件上传表单
    console.log(req.files[0]);  // 上传的文件信息
    var des_file = __dirname + "/" + req.files[0].originalname;
    fs.readFile( req.files[0].path, function (err, data) {
        fs.writeFile(des_file, data, function (err) {
            if( err ){
                console.log( err );
            }else{
                response = {
                    message:'File uploaded successfully',
                    filename:req.files[0].originalname
                };
            }
            console.log( response );
            res.end( JSON.stringify( response ) );
        });
    });
});

app.get('/listUsers', function (req, res) {
    fs.readFile( __dirname + "/" + "users.json", 'utf8', function (err, data) {
        console.log( data );
        res.end( data );
    });
});


var user = {
    "user4" : {
        "name" : "mohit",
        "password" : "password4",
        "profession" : "teacher",
        "id": 4
    }
};
app.get('/addUser', function (req, res) {
    // 读取已存在的数据
    fs.readFile( __dirname + "/" + "users.json", 'utf8', function (err, data) {
        data = JSON.parse( data );
        data["user4"] = user["user4"];
        console.log( data );
        res.end( JSON.stringify(data));
    });
});

app.get('/deleteUser', function (req, res) {
    fs.readFile( __dirname + "/" + "users.json", 'utf8', function (err, data) {
        data = JSON.parse( data );
        delete data["user" + 2];

        console.log( data );
        res.end( JSON.stringify(data));
    });
});

app.get('/:id', function (req, res) {
    // 首先我们读取已存在的用户
    fs.readFile( __dirname + "/" + "users.json", 'utf8', function (err, data) {
        data = JSON.parse( data );
        var user = data["user" + req.params.id];
        console.log( user );
        res.end( JSON.stringify(user));
    });
});



var server = app.listen(8080, function () {
    var host = server.address().address;
    var port = server.address().port;
    console.log("应用实例，访问地址为 http://%s:%s", host, port);
});