var events = require('events');// 引入 events 模块
var emitter = new events.EventEmitter();// 创建 eventEmitter 对象

emitter.on('data_received', function(){// 绑定 data_received 事件
    console.log('数据接收成功');
});

emitter.on('connection', function connected() {// 绑定 connection 事件
    console.log('连接成功');
    emitter.emit('data_received');// 触发 data_received 事件
});

emitter.emit('connection');// 触发 connection 事件

console.log("程序执行完毕");