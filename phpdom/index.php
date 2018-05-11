<?php
$dom = new DOMDocument();

$dom->loadHTMLFile('a.html');

$result = $dom->getElementById('target');

show_children($result);
#get_parent_children($result);

#打印元素的所有子节点
function show_children($tag, $layer = 1)
{
    $space = '';
    for ($i = 1; $i < $layer; $i++) {
        $space .= '&nbsp;&nbsp;';
    }
    foreach ($tag->childNodes as $child) {#遍历所有子元素
        if (hasChild($child)) {#若有非文本的子元素
            echo $space . '[' . $layer . ']' . $child->nodeName . '<br />';
            $next_layer = $layer + 1;
            show_children($child, $next_layer);
        } elseif ($child->nodeType == XML_ELEMENT_NODE) {#没有非文本的子元素
            echo $space . '[' . $layer . ']' . $child->nodeName . '<br />';# (' . $child->nodeValue . ')
        }
    }
}

#检查元素是否包含非文本元素
function hasChild($element)
{
    if ($element->hasChildNodes()) {
        foreach ($element->childNodes as $child) {
            if ($child->nodeType == XML_ELEMENT_NODE)
            {
                return true;
            }
        }
    }
    return false;
}

#打印元素的父元素和子元素
function get_parent_children($tag){
    echo '<h4>[children]</h4>';
    foreach ($tag->childNodes as $child) {
        echo $child->nodeName . '<br />';
    }
    echo '<h4>[parent]</h4>';
    $parent=$tag->parentNode;
    echo $parent->tagName;
}

exit;