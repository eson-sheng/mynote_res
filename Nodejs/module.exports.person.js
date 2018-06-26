function Person(name) {
    this.name=name;
    console.log(name+' 出生了。');
}

Person.prototype.eat=function () {
    console.log(this.name+' is eating.');
};

module.exports=Person;