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
<?php
$paths = [];
$path = './logs.php';
if (is_file($path)) {
    require_once $path;
} else {
    die("<h3>没有找到配置文件 “$path ”。请参考文件 “./logs_tmpl.php”。</h3>");
}
?>
<div id="control">
  <form id="form1">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <caption>日志列表 &nbsp;<span id="input_reset">重新设置</span><input type="reset" value="重新设置"/></caption>
      <tr>
        <td width="500">日志</td>
        <td width="80">查看<input id="select_all" type="checkbox"/></td>
        <td width="180">起始部分</td>
        <td width="100">起始索引</td>
        <td width="100">末尾开始</td>
        <td width="100">提交设置</td>
        <td>已读</td>
      </tr>
        <?php
        $logs=[];
        foreach ($paths as $path) {
          if(is_dir($path)){
              $logs[] = $path . '/' . date('Ymd') . '.log';
          }else{
              $logs[] = $path;
          }
        }
        $count = 1;
        foreach ($logs as $log) { ?>
          <tr>
            <td class="path"><?= $log ?></td>
            <td class="show">
              <input id='che_<?= $count ?>' type='checkbox' name='show[<?= $log ?>]'/>
            </td>
            <td class="from">
              <input id='txt_<?= $count ?>' type='text' name='from[<?= $log ?>]'/>
            </td>
            <td class="index">
              <input min="0" id='num_<?= $count ?>' type='number' name='index[<?= $log ?>]'/>
            </td>
            <td>
              <button class="fromtail" onclick="fromTail('<?= $log ?>')">末尾开始</button>
            </td>
            <td>
              <button class="do_config">提交设置</button>
            </td>
            <td class="percent">
              <div class="percentage" path="<?= $log ?>">0%</div>
            </td>
          </tr>
            <?php
            $count++;
        } ?>
    </table>
  </form>
  <div id="panel_box">
    <p id="panel">
    <span>
      <input id="colors" type="color" title="获取颜色代码"/>
      <input type="text" id="color_code" value="#000000"/>
    </span>
      <label>
        <input type="checkbox" id="toggle1" checked="checked"/>
        自动换行(Alt+W)
      </label>
      <button id="clear">清空显示(Alt+C)</button>
      <button id="fromtail_all">选中项从末尾开始(Alt+T)</button>
      <button id="do_config">选中项提交设置(Alt+D)</button>
      <button id="submit">读取内容(Alt+F)</button>
    </p>
    <textarea id="keywords" placeholder="#80ff00,username
#408080,/mynote/"></textarea>
  </div>
</div>

<h2>日志内容</h2>
<fieldset>
    <!--<div class="box1">
      <div class="btn1"></div>

      <div>
        <div class="box2">
          <div class="btn2"></div>
          <div class="content">11</div>
        </div>

        <div class="box2">
          <div class="btn2"></div>
          <div class="content">22</div>
        </div>
      </div>
    </div>-->
</fieldset>
</body>
<script>
    var dir_path = location.pathname;
    dir_path = dir_path.substring(0, dir_path.lastIndexOf('/') + 1);
    var server_path = dir_path + 'server.php';

    //按钮：获取日志内容
    var id = 1;
    $('#submit').on('click', function () {
        $.ajax({
            url: server_path + '?op=get_logs_content',
            type: 'post',
            async: true,
            data: new FormData($('#form1')[0]),
            dataType: 'json',
            success: function (result) {
                if (result.result === 'success') {
                    $('#btn1_' + (id-1)).trigger('click');//折叠上一次的读取结果
                    var $box1 = $('<div class="box1"></div>');
                    var $btn1 = $('<div class="btn1" id="btn1_'+id+'"></div>');
                    id++;
                    var $div = $('<div></div>');
                    $box1.append($btn1);
                    $btn1.on('click',function () {
                        $(this).next().toggle();
                        if($(this).css('background-image').indexOf('close')!=-1){
                            $(this).css('background-image',"url('img/open.png')");
                        }else{
                            $(this).css('background-image',"url('img/close.png')");
                        }
                    });

                    for (var log in result.data) {
                        var data = result.data[log];
                        var $box2 = $('<div class="box2"></div>');
                        var $btn2 = $('<div class="btn2"></div>');
                        $box2.append($btn2);
                        $btn2.on('click',function () {
                            $(this).next().toggle();
                            if($(this).css('background-image').indexOf('close')!=-1){
                                $(this).css('background-image',"url('img/open2.png')");
                            }else{
                                $(this).css('background-image',"url('img/close2.png')");
                            }
                        });
                        var $content=$('<div class="content"></div>');
                        if(isPreWrap){
                            $content.css('white-space','pre-wrap');
                        }else{
                            $content.css('white-space','pre-wrap');
                        }
                        $content.html(data);
                        $box2.append($content);
                        $div.append($box2);
                    }
                    $box1.append($div);
                    $('fieldset').append($box1);
                    highlight();
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

        //保存表单内容
        config.saveCtrls();
    });

    //绑定热键
    $("body").delegate("", "keydown", function () {
        var modifier = (event.altKey && navigator.platform.indexOf("Win") === 0) ||
            (event.ctrlKey && navigator.platform.indexOf("Mac") === 0);
        if (event.key == 'd' && modifier) {//提交设置
            $('#do_config').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
        if (event.key == 'f' && modifier) {//获取日志内容
            $('#submit').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
        if (event.key == 'c' && modifier) {//清空显示
            $('#clear').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
        if (event.key == 'w' && modifier) {//切换换行样式
            $('#toggle1').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
        if (event.key == 't' && modifier) {//全部从末尾开始
            $('#fromtail_all').trigger('click');
            event.preventDefault();//防止触发默认的热键
        }
    });

    //按钮：提交设置（选中项设置）
    $('#do_config').on('click', function () {
        $.ajax({
            url: server_path + '?op=do_config',
            type: 'post',
            async: true,
            data: new FormData($('#form1')[0]),
            dataType: 'json',
            success: function (result) {
                layer.msg(result.message);
            },
            error: function (xhr, status, message) {
                console.log('ajax error : ' + status + ' --> ' + message);
            },
            // cache:true,
            contentType: false,
            processData: false
        });

        //保存表单内容
        config.saveCtrls();
    });

    //提交设置（单个）
    $('.do_config').each(function () {
        $(this).on('click',function (e) {
            e.preventDefault();
            var $tr=$(this).parent().parent();
            var path=$tr.children('.path').text();
            var from_text=$tr.children('.from').children().val();
            var from_index=$tr.children('.index').children().val();
            var data={
                show:{},
                from:{},
                index:{}
            };
            data.show[path]='on';
            data.from[path]=from_text;
            data.index[path]=from_index;
            $.ajax({
                url: server_path + '?op=do_config',
                type: 'post',
                async: true,
                data: data,
                dataType: 'json',
                success: function (result) {
                    layer.msg(result.message);
                },
                error: function (xhr, status, message) {
                    console.log('ajax error : ' + status + ' --> ' + message);
                }
            });

            //保存表单内容
            config.saveCtrls();
        });
    });

    //按钮：清空显示内容
    $('#clear').on('click', function () {
        $('.box1').remove();
    });

    //还原表单内容
    var num = $('tr').length - 1;
    var ids = [];
    for (var i = 1; i <= num; i++) {
        ids.push('che_' + i);
        ids.push('txt_' + i);
        ids.push('num_' + i);
    }
    ids.push("keywords");
    config = createConfig("myform", ids);

    var isPreWrap=true;//是否为自动换行
    //按钮：切换换行样式
    $('#toggle1').on('click', function () {
        var $paragraphs = $('.content');
        if ($paragraphs.length === 0) {
            layer.msg('日志内容不存在');
            $('#toggle1').prop('checked', true);
            return;
        }
        if (isPreWrap) {
            isPreWrap=false;
            $paragraphs.css('white-space', 'pre');//保留行缩进，单行不允许自动折行
        } else {
            isPreWrap=true;
            $paragraphs.css('white-space', 'pre-wrap');//消除行缩进，单行自动折行
        }
    });

    //获取颜色代码
    $('#colors').on('change', function () {
        $('#color_code').val($(this).val());
    });

    //高亮关键字
    function highlight() {
        var text = $('#keywords').val();
        var index = text.indexOf(',');
        var lines = text.split('\n');
        var class_id = 1;
        lines.forEach(function (line) {
            if (line !== '') {
                var split_index = line.indexOf(',');
                var color_code = line.substring(0, split_index);
                var keyword = line.substring(split_index + 1, line.length);
                var replaced;
                $(".content").each(function () {
                    if (keyword.match(/^\/{1}.*\/{1}$/)) {//是正则表达式，取掉首尾的/
                        keyword = keyword.substr(1, keyword.length);
                        keyword = keyword.substr(0, keyword.length - 1);
                    }
                    var pattern = new RegExp(keyword, 'gmi');
                    replaced = this.innerHTML.replace(pattern, function (target) {
                        return "<span class='match" + class_id + "'>" + target + "</span>";
                    });
                    this.innerHTML = replaced;
                })
            }
            $('.match' + class_id).css('background-color', color_code);
            class_id++;
        });
    }

    //全选或全不选
    $('#select_all').on('change', function () {
        if($(this).prop('checked')){
            $('td:nth-child(2) [type=checkbox]').prop('checked', true);
        }else{
            $('td:nth-child(2) [type=checkbox]').prop('checked', false);
        }
    });

    //使点击单元格也能触发点击复选框
    $('th,td').each(function () {
        $(this).on('click', function () {
            $(this).children('[type=checkbox]').trigger('click');
        })
    });
    //阻止复选框的默认事件（与上面一段代码关联，否则点击复选框自身会响应两次）
    $('table [type=checkbox]').each(function () {
        $(this).on('click',function (e) {
            e.stopPropagation();
        })
    });

    //阻止按钮默认的提交事件
    $('.fromtail,.submit').each(function () {
        $(this).on('click',function (e) {
            e.preventDefault();
        })
    });

    //设置从末尾开始读（单个设置）
    function fromTail(path) {
        $.post(server_path+'?op=do_config', {
            fromtail:[path]
        }, function (result) {
            layer.msg(result.message);
        }, 'json');
    }

    //设置全部从末尾开始读（选中项设置）
    $('#fromtail_all').on('click',function () {
        var paths=[];
        $('.path').each(function () {
            if($(this).next().children().prop('checked')){//本行日志已选中
                paths.push($(this).text());
            }
        });
        $.post(server_path+'?op=do_config', {
            fromtail:paths
        }, function (result) {
            layer.msg(result.message);
        }, 'json');
    });

    setInterval(updatePercentages,1000);
    //更新已读进度
    function updatePercentages() {
        $.get(server_path+'?op=getPercentages', {}, function (result) {
            var data=result.data;
            if (result.result == 'success') {
                for(var path in data){
                    var percentage=data[path].toString();
                    if(percentage=='1'){
                        percentage='100%';
                    }else{
                        percentage=percentage.substr(2,2)+'%';
                        if(percentage=='%')percentage='0%';
                        if(percentage=='00%')percentage='0%';
                    }
                    $percent=$('.percentage[path="'+path+'"]');
                    $percent.css('width',percentage);
                    $percent.text(percentage);
                }
            }
        }, 'json');
    }

    //触发表单重置
    $("#input_reset").on('click',function () {
      $('[type=reset]').trigger('click');
    });
</script>
</html>