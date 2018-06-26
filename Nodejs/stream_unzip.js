var fs = require("fs");
var zlib = require('zlib');

// 解压 input.txt.gz 文件为 input.txt

fs.createReadStream('./texts/hello.txt.gz')
    .pipe(zlib.createGunzip())
    .pipe(fs.createWriteStream('./texts/hello_unzip.txt'));

