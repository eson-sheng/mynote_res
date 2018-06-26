var fs = require("fs");
var buf = Buffer.alloc(1024);

fs.open('./texts/hello.txt', 'r+', function(err, fd) {
    if (err) {
        return console.error(err);
    }
    console.log("截取后的文件内容");
    fs.ftruncate(fd, 9, function(err){// 截取文件，会改变文件内容
        if (err){
            console.log(err);
        }
        fs.read(fd, buf, 0, buf.length, 0, function(err, bytes){
            if (err){
                console.log(err);
            }
            if(bytes > 0){// 仅输出读取的字节
                console.log(buf.slice(0, bytes).toString());
            }

            fs.close(fd, function(err){// 关闭文件
                if (err){
                    console.log(err);
                }
                console.log("文件关闭成功！");
            });
        });
    });
});