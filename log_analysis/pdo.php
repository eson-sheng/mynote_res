<?php
//$M = new PDOModel();
//$M->Test();

class PDOModel
{
    private $PDO;

    function __construct()
    {
        try {
            $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING];
            global $g_config;
            $host = $g_config['host'];
            $port = $g_config['port'];
            $dbname = $g_config['logana_dbname'];
            $user = $g_config['username'];
            $pwd = $g_config['pwd'];
            $this->PDO = new PDO("mysql:host=$host; port=$port; dbname=$dbname", $user, $pwd, $options);
        } catch (PDOException $e) {
            die( "数据库连接失败。" .$e->getMessage());
        }
    }

    function __destruct()
    {
        $this->PDO = null;
    }

    function index()
    {
        return $this->PDO;
    }

    /*
     * @describe 执行查询
     * @param $sql 要执行的SQL语句
     * @return PDOStatement
     * */
    public function query($sql){
        return $this->PDO->query($sql);
    }
    /*
     * @describe 执行增、删、改
     * @param $sql 要执行的SQL语句
     * @return 返回受影响的行数
     * */
    public function execute($sql){
        return $this->PDO->exec($sql);
    }
    /*
     * @describe 测试与教程
     * */
    public function Test()
    {
        echo '<hr />';

        $pdo_statement = $this->PDO->query('show databases;');
//        $pdo_statement = $this->PDO->query('select * from `profiles`;');

        echo '查询结果的列数：',$pdo_statement->columnCount(),'<br />';
        echo '查询结果的行数：',$pdo_statement->rowCount();

        //取法1：数字与关联的键名和键值
//        foreach ($pdo_statement as $row){
//            var_dump($row);
//        }

        //取法2：数字与关联的键名和键值
//        $fetchAll=$pdo_statement->fetchAll();
//        var_dump($fetchAll);

        //取法3：关联的键名和键值
//        while ($row = $pdo_statement->fetch(PDO::FETCH_ASSOC)) {
//            var_dump($row);
//        }

        //取法4：数字的键名和键值
//        while ($row = $pdo_statement->fetch(PDO::FETCH_NUM)) {
//            var_dump($row);
//        }

        //取法5：数字与关联的键名和键值
//        while ($row = $pdo_statement->fetch(PDO::FETCH_BOTH)) {
//            var_dump($row);
//        }

        //取法6：第一列键值
        while ($row = $pdo_statement->fetch(PDO::FETCH_COLUMN)) {
            var_dump($row);
        }

        //返回受影响的行数，执行失败返回false
//        $pdo_statement=$this->PDO->exec("update `profiles` set `name`='甲2' where `employeeid`=1;");
//        var_dump($pdo_statement);

        echo '<hr />';
    }


}