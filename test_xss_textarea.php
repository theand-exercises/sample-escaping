<?php

function textarea($value)
{
    echo "<textarea>{$value}</textarea><br/>\n";
}

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "<hr />\n";


echo "<h1>Original string in textarea</h1>";
array_map("textarea", $input);


echo "<h1>htmlspecialchars with ENT_QUOTES string in textarea</h1>";
array_map("textarea", $result_htmlspecialchars);


echo "<h1>mysql_real_escape_string string in textarea</h1>";
array_map("textarea", $result_mysql_real_escape_string);


echo "<h1>htmlspecialchars with ENT_NOQUOTES after mysql_real_escape_string string in textarea</h1>";
array_map("textarea", $result_htmlspecialchars_after_mysql_real_escape_string);

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "<hr />\n";

echo "<h1>stripslashes - Original string in textarea</h1>";
array_map("textarea", array_map("stripslashes", $input));

echo "<h1>stripslashes - htmlspecialchars with ENT_QUOTES string in textarea</h1>";
array_map("textarea", array_map("stripslashes", $result_htmlspecialchars));

echo "<h1>stripslashes - mysql_real_escape_string string in textarea</h1>";
array_map("textarea", array_map("stripslashes", $result_mysql_real_escape_string));

echo "<h1>stripslashes - htmlspecialchars with ENT_NOQUOTES after mysql_real_escape_string string in textarea</h1>";
array_map("textarea", array_map("stripslashes", $result_htmlspecialchars_after_mysql_real_escape_string));

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////


echo "<hr />\n";


$param = array_fill(0, count($input), ENT_QUOTES );
echo "<h1>htmlspecialchars after stripslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("textarea",
    array_map("htmlspecialchars",
        array_map("stripslashes", $result_mysql_real_escape_string),
        $param)
);

$ent = array_fill(0, count($input), ENT_QUOTES );
$encoding = array_fill(0, count($input), 'UTF-8');
$double = array_fill(0, count($input), false );

echo "<h1>htmlentities after stripslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("textarea",
    array_map("htmlentities",
        array_map("stripslashes", $result_mysql_real_escape_string),
        $ent, $encoding, $double)
);
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

echo "<hr />\n";


$param = array_fill(0, count($input), ENT_QUOTES );
echo "<h1>htmlspecialchars after stripcslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("textarea",
    array_map("htmlspecialchars",
        array_map("stripcslashes", $result_mysql_real_escape_string),
        $param)
);


$ent = array_fill(0, count($input), ENT_QUOTES );
$encoding = array_fill(0, count($input), 'UTF-8');
$double = array_fill(0, count($input), false );

echo "<h1>htmlentities after stripcslashes - mysql_real_escape_string string in input type=text</h1>";

array_map("textarea",
    array_map("htmlentities",
        array_map("stripcslashes", $result_mysql_real_escape_string),
        $ent, $encoding, $double)
);

