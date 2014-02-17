<?php

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "\n=====\nOriginal Input\n=====\n";

var_dump($input);

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "\n=====\nEscape - htmlspecialchars with ENT_QUOTES\n=====\n";

$param = array_fill(0, count($input), ENT_QUOTES );
$result_htmlspecialchars = array_map("htmlspecialchars", $input, $param  );

var_dump($result_htmlspecialchars );
/*
 * HTML 특수문자에 해당하는 것만 인코딩 함. \, \n, \r 등은 그대로임.
 * SQL 인젝션에는 '과 "의 인코딩이 우연히 도움이 되기는 하지만 본질적이지 않음.
 * HTML 출력시 XSS를 막기 위해서 써야함.
 * 이 함수는 저장할때 쓰는게 아니라 출력할때 쓰는게 맞는 듯.
 */

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "\n=====\nEscape - mysql_real_escape_string\n=====\n";

$result_mysql_real_escape_string = array_map("mysql_real_escape_string", $input);

var_dump($result_mysql_real_escape_string );
/*
 * \, ", ' 을 \으로 escape함. SQL 인젝션을 막을 수 있음.
 * HTML 출력에 쓸때는 stripslashes를 해야하고,
 * slash와 관계없이, HTML 인코딩으로 다시 해서 XSS 방어를 해야함.
 */

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "\n=====\nEscape - htmlspecialchars with ENT_NOQUOTES after mysql_real_escape_string\n=====\n";

$param = array_fill(0, count($input), ENT_NOQUOTES  );
$result_mysql_real_escape_string_first = array_map("mysql_real_escape_string", $input);
$result_htmlspecialchars_after_mysql_real_escape_string = array_map("htmlspecialchars", $result_mysql_real_escape_string_first, $param  );

var_dump($result_htmlspecialchars_after_mysql_real_escape_string);
/*
 * SQL 인젝션 방어를 먼저 하고, "과 '을 제외한 HTML 인코딩을 한 것임.
 * ENT_QUOTES 으로 HTML 인코딩하면, 이미 이스케이프한 " 을 인코딩해버려서 상태가 메롱해짐.
 * DB에 바로 넣어도 되고, stripslashes를 한 다음에 HTML에 바로 출력해도 됨.
 *
 * 결론?
 * 쿼리에 쓸때는  mysql_real_escape만 하고(저장 포함),
 * 디비에서 꺼내와서 출력할때 stripslashes 한 다음에 ENT_QUOTES 포함 html 인코딩해서 출력하면 될듯.
 * DB에서 꺼내올때 stripslashes가 필요할까? TODO
 * 바인딩으로 입력했으면 확실히 stripslashes가 필요 없을텐데,
 * escape한 문자열을 넣었으니 어떨지?
 * 테스트 코드 새로 쓰면 될텐데 귀찮네;;;
 */
