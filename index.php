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
                echo '<div id=\''.linkify($ffName).'\' onclick="setVideo(\''.$dir.'/'.addslashes($node).'\');setTitle(event)" class="btn-link sm:p-1 text-blue cursor-pointer bg-grey-light hover:text-blue-lighter hover:bg-blue-darker border-b border-blue text-sm p-2">'.$ffName.'</div>';
            }
            
            // If it's a folder
            if(is_dir($path)){

                // If it's first level
                if(in_array($node, LEVEL_0)){
                    echo '<div class="bg-blue-darkest font-bold p-4 text-sm text-white">'.$ffName.'</div>';
                }else{
                    echo '<div class="bg-blue block text-blue-lighter p-1 sm:p-2">'.$ffName.'</div>';
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
     * @param [string] $string
     * @return String
     */
    function beautify($string){
        $string = str_replace("-", " ", $string);
        $string = str_replace(".mov", " ", $string);
        $string = str_replace(".mp4", " ", $string);
        return ucwords($string);
    }

    /**
     * Make link seo friendly
     *
     * @param [string] $string
     * @return String
     */
    function linkify($string){
        $string = str_replace(" ", "-", $string);
        $string = str_replace(".", "-", $string);
        return strtolower($string);
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
<body class="overflow-auto lg:overflow-hidden">

<!-- MAIN -->
<div id="app" class="bg-grey-light flex mb-4 flex-col-reverse lg:flex-row">

    <!-- SIDEBAR -->
    <div class="lg:overflow-y-scroll w-full text-dark h-screen lg:w-1/5 ">
        <?php listHTML(DIR); ?>
    </div>

    <!-- CONTENT -->
    <div class="w-full lg:w-4/5">

        <!-- Nav -->
        <div class="sm-w-1/5 bg-grey-lighter p-2 text-center font-bold text-xs sm:text-sm text-grey shadow-md uppercase">
            <div class="flex flex-wrap sm:inline-flex">
                <a href="/" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-1 sm:py-2 px-4 leading-loose">Partnerwork</a>
                <a href="/?p=2-footwork-on1" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-1 sm:py-2 px-4 leading-loose">Footwork</a>
                <a href="/?p=3-musicality" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-1 sm:py-2 px-4 leading-loose">Musicality</a>
                <a href="/?p=4-body-movement" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-1 sm:py-2 px-4">Body Movement</a>
                <a href="/?p=5-workshop" class="flex-1 text-grey-dark hover:bg-grey hover:text-white font-bold py-1 sm:py-2 px-4 leading-loose">Workshop</a>
            </div>
        </div>
        
        <!-- Video Content -->
        <div class="container mx-auto sm:p-4 lg:w-5/6">
            <video id="video" class="lg: w-full sm:shadow-lg sm:rounded border" controls>
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Video Title -->
        <div class="text-center container mx-auto text-grey w-4/5 text-sm pb-2 lg:pb-x lg:text-lg">
            <h3 onclick="scrollToTitle()" id="video-title" class="text-center cursor-pointer underline"></h3><h6 id="video-scroll-to-text" class="text-xs"><h6>
        </div>

    </div>

</div><!-- /MAIN -->

<script>

function setVideo(src){
    var video = document.getElementById('video');
    video.innerHTML = '';    
    var source = document.createElement('source');
    video.appendChild(source);
    source.setAttribute('src', src); 
    video.load();
    video.play();
}

function setTitle(e){
    var btn = document.getElementById(e.target.id);
    var videoTitle = document.getElementById('video-title')
    var videoScrollTo = document.getElementById('video-scroll-to-text')
    videoTitle.innerHTML = btn.innerHTML
    videoScrollTo.innerHTML = '(Scroll to)'
    videoTitle.setAttribute('video_id', btn.id);
    videoTitle.scrollIntoView({block: 'end', behavior: 'auto'})
    //highlight

}

function scrollToTitle(){
    var videoTitle = document.getElementById('video-title')
    var videoId = videoTitle.getAttribute('video_id')
    var btnVideo = document.getElementById(videoId)
    btnVideo.scrollIntoView({block: 'start', behavior: 'smooth'})
}

</script>

</body>
</html>