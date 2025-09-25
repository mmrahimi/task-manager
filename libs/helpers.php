<?php

function diePage($msg)
{
    echo "<div style = 'padding: 30px;
    background: #ff9696;
    color: #631414;
    border: 1px solid #ea8181;
    border-radius: 5px; margin: 30px; text-align:center;font-size:20px'>$msg</div>";
    die();
}

function isAjaxRequest()
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }

    return false;
}

function dd($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function site_url($uri = '')
{
    return BASE_URL . $uri;
}

function redirect($url)
{
    header("location: $url");
    die();
}
