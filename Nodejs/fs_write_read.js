var fs = require("fs");

fs.writeFile('./texts/hello2.txt', 'hello ufo',  function(err) {
    if (err) {
        return console.error(err);
    }
    console.log("数据写入成功！");

    fs.readFile('./texts/hello2.txt', function (err, data) {
        if (err) {
            return console.error(err);
        }
        console.log("异步读取文件数据: " + data.toString());
    });
});