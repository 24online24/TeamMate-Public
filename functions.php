<?php

function redirect($url)
{
    echo "<script language=\"JavaScript\">\n";
    echo "<!-- hide from old browser\n\n";

    echo "window.location = \"" . $url . "\";\n";
    echo "-->\n";
    echo "</script>\n";
    return true;
}

