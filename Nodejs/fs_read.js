var fs = require("fs");
//回调函数
//非阻塞代码
fs.readFile('./texts/hello.txt', function (err, data) {
    if (err) return console.error(err);
    console.log(data.toString());
});

console.log('执行完毕');