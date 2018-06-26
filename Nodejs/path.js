var _path = require("path");

var path='/test/test1//2slashes/1slash/tab/..';

//.normalize(str) 格式化
var result=_path.normalize(path);

console.log(path);// /test/test1//2slashes/1slash/tab/..
console.log(result);// \test\test1\2slashes\1slash

result=_path.join('/test', 'test1', '2slashes/1slash', 'tab', '..');
console.log(result);// \test\test1\2slashes\1slash

result=_path.resolve('path.js');//转换为绝对路径
console.log(result);// D:\nodejs_test\path.js

result=_path.extname('path.js');//路径中文件的后缀名
console.log(result);// .js