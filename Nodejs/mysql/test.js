//$ cnpm install mysql
var mysql      = require('mysql');
var connection = mysql.createConnection({
    host     : 'localhost',
    user     : 'root',
    password : 'root123.',
    port: '3306',
    database : 'items_manag'
});

connection.connect();

//执行sql命令
connection.query('SELECT 10 + 1 AS solution', function (error, results, fields) {
    if (error) throw error;
    console.log('The solution is: ', results[0].solution);
});

//查询数据
connection.query('select * from `item_types`;', function (error, results, fields) {
    if(error){
        console.log('[SELECT ERROR] - ',error.message);
        return;
    }
    console.log('The solution is: ', results);
});

//插入数据
var  sql = 'insert into `item_types`(`name`,`deleted`) VALUES(?,?)';
var  params = ['菜鸟类',0];
connection.query(sql,params,function (err, result) {
    if(err){
        console.log('[INSERT ERROR] - ',err.message);
        return;
    }
    console.log('插入反馈：',result);
});

//更新数据
var  sql = 'update `item_types` set `name`=?,`deleted`=? where `id`=?;';
var  params = ['飞虫类',1,4];
connection.query(sql,params,function (err, result) {
    if(err){
        console.log('[UPDATE ERROR] - ',err.message);
        return;
    }
    console.log('修改行数：',result.affectedRows);
});

//删除数据
var  sql = 'delete from `item_types` where `id`=?;';
var  params = [4];
connection.query(sql,params,function (err, result) {
    if(err){
        console.log('[DELETE ERROR] - ',err.message);
        return;
    }
    console.log('删除行数：',result.affectedRows);
});

connection.end();