<?php


function input_text($value)
{
    echo "<input type=\"text\" value=\"{$value}\" /><br />\n";
}

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "<hr />\n";


echo "<h1>Original string in input type=text</h1>";
array_map("input_text", $input);
/*
 * 오리지널 스트링.
 * " 엔티티 때문에 태그 깨짐.
 * XSS 무방비 상태.
 */

echo "<h1>htmlspecialchars with ENT_QUOTES string in input type=text</h1>";
array_map("input_text", $result_htmlspecialchars);
/*
 * 다 잘 나옴.
 */

echo "<h1>mysql_real_escape_string string in input type=text</h1>";
array_map("input_text", $result_mysql_real_escape_string);
/*
 * stripslashes를 하지 않아서 \ escape가 그대로 보임.
 * " 엔티티 때문에 태그 깨짐.
 * XSS 무방비.
 */

echo "<h1>htmlspecialchars with ENT_NOQUOTES after mysql_real_escape_string string in input type=text</h1>";
array_map("input_text", $result_htmlspecialchars_after_mysql_real_escape_string);
/*
 * stripslashes를 하지 않아서 \ escape가 그대로 보임.
 * " 엔티티 때문에 태그 깨짐.
 * 다른 태그 요소 <, > 등에 대해서는 괜찮지만, "과 '을 인코딩안했기 때문에 해당요소에 대해 취약.
 */

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "<hr />\n";

echo "<h1>stripslashes - Original string in input type=text</h1>";
array_map("input_text", array_map("stripslashes", $input));
/*
 * 오리지널 스트링.
 * XSS 무방비.
 */

echo "<h1>stripslashes - htmlspecialchars with ENT_QUOTES string in input type=text</h1>";
array_map("input_text", array_map("stripslashes", $result_htmlspecialchars));
/*
 * 다 잘 나옴.
 */

echo "<h1>stripslashes - mysql_real_escape_string string in input type=text</h1>";
array_map("input_text", array_map("stripslashes", $result_mysql_real_escape_string));
/*
 * \ escape 한 것은 잘 보임.
 * \r과 \n을 unescape 하면 r과 n이 됨.
 * TODO stripcslashes 를 쓸 것인가, 아니면 escape한 문자열을 쓴 것 자체가 문제인가.
 *
 * 하지만 " 엔티티 때문에 태그 깨짐.
 * XSS 무방비
 */

echo "<h1>stripslashes - htmlspecialchars with ENT_NOQUOTES after mysql_real_escape_string string in input type=text</h1>";
array_map("input_text", array_map("stripslashes", $result_htmlspecialchars_after_mysql_real_escape_string));
/*
 * \ escape 한 것은 잘 보임.
 * \r과 \n을 unescape 하면 r과 n이 됨.
 *
 * 다른 태그 요소 <, > 등에 대해서는 괜찮지만, "과 '을 인코딩안했기 때문에 해당요소에 대해 취약.
 */

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "<hr />\n";


$param = array_fill(0, count($input), ENT_QUOTES );
echo "<h1>htmlspecialchars after stripslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("input_text",
    array_map("htmlspecialchars",
        array_map("stripslashes", $result_mysql_real_escape_string),
        $param)
);
/*
 * \ escape 한 것 잘 보이고.
 * XSS 방어도 됨.
 * \r과 \n의 unescape는 여전히 문제.
 */

$ent = array_fill(0, count($input), ENT_QUOTES );
$encoding = array_fill(0, count($input), 'UTF-8');
$double = array_fill(0, count($input), false );

echo "<h1>htmlentities after stripslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("input_text",
    array_map("htmlentities",
        array_map("stripslashes", $result_mysql_real_escape_string),
        $ent, $encoding, $double)
);
/*
 * 위와 동일한 결과.
 *
 * htmlspecialchars 와 htmlentities의 차이는
 * 앞의 것은 특정 엔티티만 변환하고, 뒤에 것은 모든 HTML 문자를 변환함.
 * http://stackoverflow.com/questions/46483/htmlentities-vs-htmlspecialchars
 * 안정성은 htmlentities가 더 높다?
 * http://stackoverflow.com/questions/3623236/htmlspecialchars-vs-htmlentities-when-concerned-with-xss
 * UTF-7 에 대한 말이 나오는데, htmlspecialchars도
 * htmlentites는 Laravel의 {{{ }}} (escaped echo)  에서 쓰이고 있는 것을 확인함.
 */

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "<hr />\n";


$param = array_fill(0, count($input), ENT_QUOTES );
echo "<h1>htmlspecialchars after stripcslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("input_text",
    array_map("htmlspecialchars",
        array_map("stripcslashes", $result_mysql_real_escape_string),
        $param)
);
/*
 * stripcslashes 를 사용하여 \n과 \r은 \ 제거하지 않음.
 * 가장 제대로 나옴.
 */

$ent = array_fill(0, count($input), ENT_QUOTES );
$encoding = array_fill(0, count($input), 'UTF-8');
$double = array_fill(0, count($input), false );

echo "<h1>htmlentities after stripcslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("input_text",
    array_map("htmlentities",
        array_map("stripcslashes", $result_mysql_real_escape_string),
        $ent, $encoding, $double)
);
/*
 * 상동
 */

