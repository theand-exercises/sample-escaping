<?php

$input = [
    "TEST]\\", //mysql escape
    'TEST"TEST', //mysql escape, html encode
    "TEST'TEST", //mysql escape, html encode
    "TEST<TEST", //html encode
    "TEST>TEST", //html encode
    "TEST&TEST", //html encode
    "TEST%TEST",//none
    "TEST_TEST",//none
    "TEST\nTEST",//mysql escape
    "TEST\rTEST",//mysql escape
];

require "test_sql_injection.php";

//stripslashes($valuate['val_cmt_b']);
//htmlspecialchars_decode($_POST["val_cmt_a"], ENT_QUOTES);
//htmlentities($value, ENT_QUOTES, 'UTF-8', false);

//require "test_xss_input_text.php";


require "test_xss_textarea.php";


