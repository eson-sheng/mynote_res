var fs = require("fs");

// 管道流，管道提供了一个输出流到输入流的机制。
// 通常我们用于从一个流中获取数据并将数据传递到另外一个流中

var read_stream = fs.createReadStream('./texts/hello.txt');

var write_stream = fs.createWriteStream('./texts/hello_pipe.txt');

read_stream.pipe(write_stream);

