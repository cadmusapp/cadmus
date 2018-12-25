<?php

function current_url()
{
    return "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function modify_get($data, $url = "", $include = true)
{
    if (empty($url))
        $url = current_url();

    if (strpos($url, "?") === false)
        $url .= "?pagination=true";

    $queries = substr($url, strpos($url, "?") + 1);
    $retdata = [];
    foreach (explode("&", $queries) as $query) {
        $d = explode("=", $query);
        $retdata[$d[0]] = $d[1];
    }

    // Append data
    foreach ($data as $key => $value) {
        $retdata[$key] = $value;
    }
    if ($include) {
        return substr($url, 0, strpos($url, "?")) . '?' . http_build_query($retdata);
    }
    else {
        unset($retdata['pagination']);
        return '?' . http_build_query($retdata);
    }
}

function get_meta($file, $ret)
{
    // Check if file exists
    if (!is_file($file))
        return false;

    // Extract the meta portion
    $data = file_get_contents($file);
    $meta_start = substr($data, strpos($data, "---") + 3);
    $meta_end = substr($meta_start, strpos($meta_start, "---") + 3);
    $meta = trim(substr($meta_start, 0, strpos($meta_start, $meta_end) - 3));

    // Explode the meta
    foreach (explode("\n", $meta) as $m) {
        $d = explode(":", $m);
        if (trim($d[0]) == $ret) {
            return trim($d[1]);
        }
    }

    // Return false for no results
    return false;
}

function get_excerpt($file, $delim = 150, $term = "")
{
    if (get_meta($file, "Excerpt")) {
        return get_meta($file, "Excerpt");
    }
    // Extract the meta portion
    $data = file_get_contents($file);
    $meta_start = substr($data, strpos($data, "---") + 3);
    $meta_end = substr($meta_start, strpos($meta_start, "---") + 3);
    $meta = trim(substr($meta_start, 0, strpos($meta_start, $meta_end) - 3));

    // Replace data
    $data = substr($data, strpos($data, $meta_end));

    if (empty($term)) {
        // Return
        $ret = substr($data, 0, $delim) . "...";
    } else {
        // Start from first instance of term
        $x = strpos($data, $term);
        if ($x < 10) {
            $ret = substr($data, 0, $delim) . "...";
        } else {
            $ret = "..." . substr($data, $x - 10, $delim) . "...";
        }
    }
    $ret = strip_tags($ret);

    return str_replace($term, "<span style='background: yellow; color: #000; font-style: italic;'>{$term}</span>", $ret);
}

function get_content($f)
{
    // Extract the meta portion
    $data = file_get_contents($f);
    $meta_start = substr($data, strpos($data, "---") + 3);
    $meta_end = substr($meta_start, strpos($meta_start, "---") + 3);
    $meta = trim(substr($meta_start, 0, strpos($meta_start, $meta_end) - 3));

    // Replace data
    $data = substr($data, strpos($data, $meta_end));

    return $data;
}

function in_file($q, $file)
{
    $data = file_get_contents($file);
    if (strpos(strtolower($data), strtolower($q)) === false) {
        return false;
    }

    return true;
}

function get_file($id)
{
    $id = $id - 1;
    $files = glob(APP_ROOT . "content/*.1.txt"); // .1.txt is published, .0.txt is a draft.
    usort($files, function($a, $b) {
        return filemtime($a) < filemtime($b);
    });
    return $files[$id];
}

function make_slug($file)
{
    return str_replace(["/content/", "."], "", ("/" . str_replace(".1.txt", "", $file)));
}