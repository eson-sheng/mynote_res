var fs = require("fs");

var buf = Buffer.alloc(1024);

//读取文件，关闭文件
fs.open('./texts/hello.txt', 'r+', function(err, fd) {
    if (err) {
        return console.error(err);
    }
    fs.read(fd, buf, 0, buf.length, 0, function(err, bytes){
        if (err){
            console.log(err);
        }
        console.log(bytes + "  字节被读取");
        if(bytes > 0){// 仅输出读取的字节
            console.log(buf.slice(0, bytes).toString());
        }

        fs.close(fd, function(err){// 关闭文件
            if (err){
                console.log(err);
            }
            console.log("文件关闭成功");
        });
    });
});
