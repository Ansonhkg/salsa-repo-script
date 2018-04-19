<?php
/**
 * A list of files or folders that you don't want to display
 */
define("IGNORED_LIST", serialize([
    '.', 
    '..', 
    'index.html',
    'index_files',
    'index.php',
    'test.php',
    'dev.php',
    '.git',
    '.gitignore',
    'list.php',
]));


echo json_encode(getNodes('.'));

/**
 * Get all folders and files in a directory and return as JSON
 *
 * @param [string] $dir
 * @return array
 */
function getNodes($dir){
    $tree = [];
    $nodes = ignore(scandir($dir), IGNORED_LIST);
    
    if(count($nodes) < 1) return;

    foreach($nodes as $node){
        
        $newNode = $dir . '/' . $node;

        if(is_dir($newNode)){
            
            $tree[$node] = getNodes($newNode);

        }else{
            $tree[] = $node;
        }

    }
    return $tree;
}

/**
 * Ignore files/elements in an array given by a list of names
 *
 * @param [array] $dir 
 * @param [array] $unwantedFiles
 * @return Array
 */
function ignore(Array $dir, $unwantedFiles){
    $unwantedFiles = unserialize($unwantedFiles);

    foreach($unwantedFiles as $fileName){
        $fileNameIndex = array_search($fileName, $dir, true);
        unset($dir[$fileNameIndex]);
    };
    
    // Natural case sort && re-index array
    natcasesort($dir);
    array_values($dir);

    return $dir;
}

/**
 * Pretty Print
 *
 * @return void
 */
function print_x($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}