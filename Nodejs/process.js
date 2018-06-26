//全局变量 process
process.on('exit', function(code) {
    console.log('退出码：', code);
});

process.stdout.write("Hello World!" + "\n");

process.argv.forEach(function(val, index, array) {// 通过参数读取
    console.log(index + ': ' + val);
    /*0: D:\nodejs\node.exe
    * 1: D:\nodejs_test\process
    * */
});

console.log('执行路径：'+process.execPath);//D:\nodejs\node.exe
console.log('平台信息：'+process.platform);//win32

console.log('当前目录：' + process.cwd());//D:\nodejs_test
console.log('当前版本：' + process.version);//v10.4.1

console.log('输出内存使用情况：');
console.log(process.memoryUsage());
/*{ rss: 19681280,
  heapTotal: 6062080,
  heapUsed: 3746224,
  external: 8672 }*/