//将任意对象转换为字符串
//util.inspect(object,[showHidden],[depth],[colors])
var util = require('util');
/**************************************************/
function Person() {
    this.name = 'harry';
    this.gender='male';
    this.toString = function() {
        return this.name;
    };
}
/**************************************************/
var person1 = new Person();

console.log(util.inspect(person1));

console.log(util.inspect(person1, true));