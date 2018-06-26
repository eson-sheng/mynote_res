var fs = require("fs");

fs.open('./texts/hello.txt', 'r+', function(err, fd) {// 异步打开文件
    if (err) {
        return console.error(err);
    }
    console.log("打开成功！");
});

fs.stat('./texts/hello.txt', function (err, stats) {//异步模式获取文件信息
    //console.log(stats.isFile());//true
    //console.log(stats.isDirectory());//false
    console.log(stats);//true
});

