//实现对象间原型继承
//util.inherits(constructor, superConstructor)
var util = require('util');
/**************************************************/
function Base() {
    this.name = 'base';
    this.id = 1991;
    this.sayHello = function() {
        console.log('hello.');
    };
}
Base.prototype.showName = function() {
    console.log('i am %s.',this.name);
};
/**************************************************/
function Sub() {
    this.name = 'sub';
}
util.inherits(Sub, Base);
//Sub.prototype=new Base();
/**************************************************/
var base1 = new Base();
var sub1 = new Sub();

base1.showName();
sub1.showName();

console.log(base1);
console.log(sub1);