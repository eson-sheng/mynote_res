var fs = require("fs");

fs.unlink('./texts/del.txt', function(err) {
    if (err) {
        return console.error(err);
    }
    console.log("文件删除成功！");
});