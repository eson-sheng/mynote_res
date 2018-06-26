var fs = require("fs");

var data = '';

var read_stream = fs.createReadStream('./texts/hello.txt');// 创建可读流

read_stream.setEncoding('UTF8');// 设置编码为 utf8

read_stream.on('data', function(chunk) {
    //console.log('读取到：\n'+chunk);
    data += chunk;
});

read_stream.on('end',function(){
    console.log('读取结果：\n'+data);
});

read_stream.on('error', function(err){
    console.log('错误：\n'+err.stack);
});
