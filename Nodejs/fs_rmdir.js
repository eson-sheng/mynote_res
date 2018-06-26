var fs = require("fs");

fs.rmdir("./new_dir",function(err){
    if (err) {
        return console.error(err);
    }
    console.log('目录已删除');
});