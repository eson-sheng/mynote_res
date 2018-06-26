//判断对象是否是指定类型
//util.isXXX(object)
var util = require('util');
//.isArray()
//.isRegExp()
//.isDate()
//.isError()

// console.log(util.isArray(11));// false
// console.log(util.isArray([]));// true

// console.log(util.isRegExp(/some regexp/));// true
// console.log(util.isRegExp(new RegExp()));// true
// console.log(util.isRegExp({}));// false

// console.log(util.isDate(new Date()));// true
// console.log(util.isDate(Date()));// false (without 'new' returns a String)

// console.log(util.isError(new Error()));// true
// console.log(util.isError(new TypeError()));// true
// console.log(util.isError({ name: 'Error', message: 'an error occurred' }));// false