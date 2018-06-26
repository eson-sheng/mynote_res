var fs = require("fs");

//阻塞代码
var data = fs.readFileSync('./texts/hello.txt');

console.log(data.toString());

console.log('执行完毕');