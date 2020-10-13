<?php

include('./SimpleXLS.php');
if ($xlsx = SimpleXLSX::parse('data.xlsx')) {
    // Produce array keys from the array values of 1st array element
    $header_values = $rows = [];
    foreach ($xlsx->rows(1) as $k => $r) {
        if ($k === 0) {
            $header_values = $r;
            continue;
        }
        $rows[] = array_combine($header_values, $r);
    }
}
// print_r($rows);

$company_id = $argv[1];
// print($company_id);


function buildTree(array $elements, $parentId = 0)
{
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parentId'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

function printTree($tree, $seperator)
{
    if (!is_null($tree) && count($tree) > 0) {
        foreach ($tree as $node) {
            print($seperator . ' ' . $node['id'] . " - " . $node['company'] . "\n");
            if (isset($node['children'])) {
                printTree($node['children'], $seperator . '----');
            }
        }
    }
}

$tree = buildTree($rows, $company_id);

// print_r($tree);

printTree($tree, '');
