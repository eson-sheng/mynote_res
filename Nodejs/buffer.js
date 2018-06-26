//const buf = Buffer.from('runoob');
var buf = Buffer.from('runoob', 'ascii');
/*
Node.js 目前支持的字符编码包括：
ascii - 仅支持 7 位 ASCII 数据。如果设置去掉高位的话，这种编码是非常快的。
utf8 - 多字节编码的 Unicode 字符。许多网页和其他文档格式都使用 UTF-8 。
utf16le - 2 或 4 个字节，小字节序编码的 Unicode 字符。支持代理对（U+10000 至 U+10FFFF）。
ucs2 - utf16le 的别名。
base64 - Base64 编码。
latin1 - 一种把 Buffer 编码成一字节编码的字符串的方式。
binary - latin1 的别名。
hex - 将每个字节编码为两个十六进制字符。*/

//console.log(buf.toString());// 输出 runoob
//console.log(buf.toString('hex'));// 输出 72756e6f6f62
//console.log(buf.toString('base64'));// 输出 cnVub29i


//写入缓冲区
buf = Buffer.alloc(256);//返回一个指定大小的 Buffer 实例
len = buf.write("www.runoob.com");
console.log("写入字节数 : "+  len);
console.log(buf.toString());//读取

//从缓冲区读取数据
buf = Buffer.alloc(26);
for (var i = 0 ; i < 26 ; i++) {
    buf[i] = i + 97;
}
console.log(buf.toString('ascii'));//abcdefghijklmnopqrstuvwxyz
console.log(buf.toString('ascii',0,5));//abcde
console.log(buf.toString('utf8',0,5));//abcde
console.log(buf.toString(undefined,0,5));//使用 'utf8' 编码, 并输出: abcde
