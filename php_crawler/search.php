<?php
$search = false;
$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = true;
    file_put_contents('./records.txt', '');#清空文件内容
    include_once 'phpQuery-onefile.php';
    $keywords = $_POST['keywords'];
    $target_str = $_POST['target_str'];
    $page_num = $_POST['page_num'];
    if (file_exists("logs") === false) {
        mkdir("logs");
    }
    for ($i = 0; $i < $page_num; $i++) {#从第一页开始找，逐页向后找
        if ($result) break;
        $url = "http://www.baidu.com/s?wd=$keywords&pn={$i}0";
        $html = file_get_contents($url);
        file_put_contents("logs/" . ($i + 1) . '.html', $html);
        $doc = phpQuery::newDocument($html);
        phpQuery::selectDocument($doc);
        $this_url = $url;
        $targets = pq('.c-showurl');
        file_put_contents('./records.txt', '【第' . ($i + 1) . '页】' . $this_url . "\n", FILE_APPEND);
        foreach ($targets as $each) {//本页每个搜索结果
            $text = $each->textContent;
            file_put_contents('./records.txt', $text . PHP_EOL, FILE_APPEND);
            if (strstr($text, $target_str)) {
                $result = $i + 1;//页数
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>爬虫</title>
</head>
<body>
<?php if (!$search) { ?>
    <form method="post" action="">
        <dl>
            <dt>要百度的关键字</dt>
            <dd>
                <input name="keywords" type="text" value="哈利波特"/>
            </dd>
            <dt>查找搜索结果链接中包含的字符串</dt>
            <dd>
                <input name="target_str" type="text"/>
            </dd>
            <dt>搜查前多少页</dt>
            <dd>
                <input name="page_num" type="number" min="1" max="50" value="20"/>
            </dd>
        </dl>
        <input type="submit"/>
    </form>
<?php } else { ?>
    <h3>搜查结果</h3>
    <?php if ($result) { ?>
        目标字符串出现在第 <?= $result ?> 页。
    <?php } else { ?>
        在指定页数范围内没有找到目标字符串。
    <?php } ?>
    <a href="">返回</a>
<?php } ?>
</body>
</html>