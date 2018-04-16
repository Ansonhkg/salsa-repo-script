<?php

    /**
     * A list of files or folders that you don't want to display
     */
    define("IGNORED_LIST", [
        '.', 
        '..', 
        'index.html',
        'index_files',
        'index.php',
        'index2.php',
    ]);
    
    // Get folder option from URL. Default: 1-partnerwork-on1
    define('DIR', isset($_GET['p']) ? htmlspecialchars($_GET['p']) : '1-partnerwork-on1');
    
    // Get a list of folders name in the first level
    define('LEVEL_0', scandir(DIR));

    /**
     * list all folders and files under a direcotry
     *
     * @param [String] $dir aka. directory name
     */
    function listHTML($dir){
        
        // Get all nodes and Ignore some
        $nodes = ignore(scandir($dir), IGNORED_LIST);
        
        // BASE CASE
        if(count($nodes) < 1) return;
        
        // RECURSIVE CASE
        echo '<ol class="list-reset">';
        foreach($nodes as $node){
            $nodeInfo = pathinfo($node);
            $ffName = beautify($node);
            $path = $dir . '/'  . $node;
            
            echo "<li id='$node'>";

            // If it's a video (.mp4)
            if(isset($nodeInfo['extension']) && $nodeInfo['extension'] === 'mp4'){
                echo '<div onclick="setVideo(\''.$dir.'/'.addslashes($node).'\')" class="p-1 text-blue cursor-pointer hover:text-blue-lighter hover:bg-blue-darker border-b border-blue text-sm p-2">'.$ffName.'</div>';
            }
            
            // If it's a folder
            if(is_dir($path)){

                // If it's first level
                if(in_array($node, LEVEL_0)){
                    echo '<div class="bg-blue-darkest font-bold p-4 text-sm text-white">'.$ffName.'</div>';
                }else{
                    echo '<div class="bg-blue block text-blue-lighter p-2">'.$ffName.'</div>';
                }
            }

            echo '</li>';
            
            

            if(is_dir($path)){
                listHTML($path);
            }
        }
        echo '</ol>';
    }
    
    /**
     * Ignore files/elements in an array given by a list of names
     *
     * @param [array] $dir 
     * @param [array] $unwantedFiles
     * @return Array
     */
    function ignore(Array $dir, Array $unwantedFiles){
        
        foreach($unwantedFiles as $fileName){
            $fileNameIndex = array_search($fileName, $dir, true);
            unset($dir[$fileNameIndex]);
        };
        
        return mySort($dir);
    }

    /**
     * Natural case sort && re-index array
     *
     * @param [array] $dir
     * @return void
     */
    function mySort($dir){

        // Natural case sort
        natcasesort($dir);

        // Re-index
        return array_values($dir);
    }

    /**
     * Re-format a string
     *
     * @param [type] $string
     * @return void
     */
    function beautify($string){
        $string = str_replace("-", " ", $string);
        $string = str_replace(".mov", " ", $string);
        $string = str_replace(".mp4", " ", $string);
        return ucwords($string);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Dance Dojo Repository</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="overflow-hidden">
<!-- MAIN -->
<div id="app" class="bg-grey-light flex mb-4">

    <!-- SIDEBAR -->
    <div class="text-sm text-dark sidebar overflow-y-scroll bg-grey h-screen w-1/5">
        <?php listHTML(DIR); ?>
    </div> <!-- /SIDEBAR -->

    <!-- VIDEO CONTENT -->
    <div class="content w-4/5">
        <div class="bg-grey-lighter p-4 text-center font-bold text-sm text-grey shadow-md uppercase">
            <div class="flex">
                <a href="/" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-2 px-4">Partnerwork</a>
                <a href="/?p=2-footwork-on1" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-2 px-4">Footwork</a>
                <a href="/?p=3-musicality" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-2 px-4">Musicality</a>
                <a href="/?p=4-body-movement" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-2 px-4">Body Movement</a>
                <a href="/?p=5-workshop" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-2 px-4">Workshop</a>
            </div>
        </div>
        

        <div class="container mx-auto p-4">
            <video id="video" class="w-full shadow-lg rounded border" controls>
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        
    </div> <!-- /VIDEO CONTENT -->

</div><!-- /MAIN -->

<script>

function setVideo(src){
    console.log(src)
    var video = document.getElementById('video');
    video.innerHTML = '';    
    var source = document.createElement('source');
    video.appendChild(source);
    source.setAttribute('src', src); 
    video.load();
    video.play();
}

</script>

</body>
</html>