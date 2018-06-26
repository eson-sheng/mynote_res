var events = require('events');
var emitter = new events.EventEmitter();

var listener1 = function listener1() {// 监听器 #1
    console.log('listener1 works');
};
var listener2 = function listener2() {// 监听器 #2
    console.log('listener2 works');
};

emitter.addListener('connection1', listener1);//添加一个监听器到监听器数组的尾部
emitter.on('connection1', listener2);
var count = events.EventEmitter.listenerCount(emitter,'connection1');
console.log(count + " 个监听器监听连接事件");
emitter.emit('connection1');

emitter.removeListener('connection1', listener1);// 移除监绑定的 listener1 函数
console.log("listener1 is out");
count = events.EventEmitter.listenerCount(emitter,'connection1');
console.log(count + " 个监听器监听连接事件");
emitter.emit('connection1');

/*EventEmitter 定义了一个特殊的事件 error，它包含了错误的语义，我们在遇到 异常的时候通常会触发 error 事件。当 error 被触发时，EventEmitter 规定如果没有响 应的监听器，Node.js 会把它当作异常，退出程序并输出错误信息。我们一般要为会触发 error 事件的对象设置监听器，避免遇到错误后整个程序崩溃。*/

/*emitter.on('error', function(){// 绑定 error 事件
    console.log('error!');
});*/
//emitter.emit('error');
emitter.emit('error1');

console.log("程序执行完毕");