<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>日志查看器</title>
    <link type="text/css" href="index.css" rel="stylesheet"/>
    <script src="jquery-3.0.0.min.js"></script>
    <script src="layer/layer.js"></script>
    <script src="pi.js"></script>
    <script src="config.js"></script>
</head>
<body>
<form id="form1">
    <table cellpadding="0" cellspacing="0" border="1">
        <caption>日志列表 <input type="reset" value="重新设置"/></caption>
        <tr>
            <th width="60%">日志</th>
            <th width="10%">查看</th>
            <th>起始部分</th>
            <th>起始索引</th>
        </tr>
        <?php
        $logs = [
            './aa/a.log',
            './b.log',
            './c.log',
            './d.log',
            './e.log'
        ];
        $count=1;
        foreach($logs as $log){ ?>
            <tr>
                <td><?=$log?></td>
                <td>
                    <input id='che_<?=$count?>' type='checkbox' name='show[<?=$log?>]'/>
                </td>
                <td>
                    <input id='txt_<?=$count?>' type='text' name='from[<?=$log?>]'/>
                </td>
                <td>
                    <input id='num_<?=$count?>' type='number' name='index[<?=$log?>]'/>
                </td>
            </tr>
        <?php
        $count++;
        } ?>
    </table>
</form>
<p>
    <button id="reset_history">重置读取历史(Alt+D)</button>
    <button id="clear">清空显示内容(Alt+C)</button>
    <button id="submit">读取内容(Alt+F)</button>
    <button id="save_form">保存表单内容</button>
</p>

<fieldset>
    <legend>日志内容</legend>
    <!--<div class="box">
        <p>
            11
        </p>
        <p>
            22
        </p>
        <p>
            33
        </p>
        <p>
            44
        </p>
        <p>
            55
        </p>
    </div>-->
</fieldset>
</body>
<script>
    var dir_path = location.pathname;
    dir_path = dir_path.substring(0, dir_path.lastIndexOf('/') + 1);
    var server_path = dir_path + 'server.php';

    //按钮：获取日志内容
    $('#submit').on('click', function () {
        $.ajax({
            url: server_path + '?op=get_logs_content',
            type: 'post',
            async: true,
            data: new FormData($('#form1')[0]),
            dataType: 'json',
            success: function (result) {
                if (result.result == 'success') {
                    var $box = $('<div class="box"></div>');
                    for (var log in result.data) {
                        var content = result.data[log];
                        var $p = $('<p></p>');
                        $p.html(content);
                        $box.append($p);
                    }
                    $('fieldset').append($box);
                } else {
                    layer.msg(result.message);
                }
            },
            error: function (xhr, status, message) {
                console.log('ajax error : ' + status + ' --> ' + message);
            },
            // cache:true,
            contentType: false,
            processData: false
        });
    });

    //绑定热键
    $("body").delegate("", "keydown", function () {
        if (event.key == 'f' && event.altKey) {//获取日志内容
            $('#submit').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
        if (event.key == 'd' && event.altKey) {//重置读取历史
            $('#reset_history').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
        if (event.key == 'c' && event.altKey) {//清空显示内容
            $('#clear').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
    });

    //按钮：重置读取历史
    $('#reset_history').on('click', function () {
        $.get(server_path, {
            op: 'reset_history'
        }, function (result) {
            if (result.result == 'success') {
                layer.msg(result.message);
            }
        }, 'json');
    });

    //按钮：清空显示内容
    $('#clear').on('click', function () {
        $('.box').remove();
    });

    //还原表单内容
    var num = $('tr').length - 1;
    var ids = [];
    for (var i = 1; i <= num; i++) {
        ids.push('che_' + i);
        ids.push('txt_' + i);
        ids.push('num_' + i);
    }
    config = createConfig("myform", ids);

    //保存表单内容
    $('#save_form').on('click', function () {
        config.saveCtrls();
        layer.msg('表单内容已保存');
    });
</script>
</html>