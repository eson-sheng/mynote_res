var os = require("os");

console.log(__filename);// D:\nodejs_test\global.js
console.log(__dirname);// D:\nodejs_test

//console.log('CPU字节序列：' + os.endianness());//LE
//console.log('操作系统类型：' + os.type());//Windows_NT
//console.log('操作系统名称：' + os.platform());//win32
//console.log('系统内存总量：' + os.totalmem() + " bytes");//12575404032 bytes
//console.log('系统空闲内存：' + os.freemem() + " bytes");//7604371456 bytes