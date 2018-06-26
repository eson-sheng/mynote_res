//node.js 默认后缀为 .js

var funcs=require('./module.exports.function');
funcs.hello();
funcs.hello2();

var Person=require('./module.exports.person');
var person1=new Person('harry');
person1.eat();
