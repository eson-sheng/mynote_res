var fs = require("fs");

var data = 'data.earth';

var write_stream = fs.createWriteStream('./texts/earth.txt');

write_stream.write(data,'UTF8');

write_stream.end();//标记文件末尾

write_stream.on('finish', function() {
    console.log("写入完成");
});

write_stream.on('error', function(err){
    console.log(err.stack);
});
