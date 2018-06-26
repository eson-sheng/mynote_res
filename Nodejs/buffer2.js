//将 Buffer 转换为 JSON 对象
//当字符串化一个 Buffer 实例时，JSON.stringify() 会隐式地调用该 toJSON()
const buf = Buffer.from([0x1, 0x2, 0x3, 0x4, 0x5]);

const json = JSON.stringify(buf);

console.log(json);// {"type":"Buffer","data":[1,2,3,4,5]}

const copy = JSON.parse(json, (key, value) => {
    return value && value.type === 'Buffer' ? Buffer.from(value.data) : value;
});
console.log(copy);//<Buffer 01 02 03 04 05>

//缓冲区合并
var buffer1 = Buffer.from(('菜鸟教程 '));
var buffer2 = Buffer.from(('www.runoob.com'));
var buffer3 = Buffer.concat([buffer1,buffer2]);
console.log("buffer3 : " + buffer3.toString());

//缓冲区比较
buffer1 = Buffer.from('ABC');
buffer2 = Buffer.from('ABCD');
var result = buffer1.compare(buffer2);

if(result < 0) {
    console.log(buffer1 + " 在 " + buffer2 + " 之前");
}else if(result == 0){
    console.log(buffer1 + " 与 " + buffer2 + " 相同");
}else {
    console.log(buffer1 + " 在 " + buffer2 + " 之后");
}

//拷贝缓冲区
var buf1 = Buffer.from('abcdefghijkl');
var buf2 = Buffer.from('RUNOOB');
buf2.copy(buf1, 2);//将 buf2 插入到 buf1 指定位置上
console.log(buf1.toString());

//缓冲区裁剪
buffer1 = Buffer.from('runoob');
buffer2 = buffer1.slice(0,2);// 剪切缓冲区
console.log("buffer2 content: " + buffer2.toString());

//缓冲区长度
var buffer = Buffer.from('www.runoob.com');
console.log("buffer length: " + buffer.length);//  缓冲区长度
