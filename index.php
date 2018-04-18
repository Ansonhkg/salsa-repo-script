<?php
    // UPDATED AT: 2018-04-18 21:17:07
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
    ]));

    /**
     * A list of video format you want to support
     */
    define("SOURCE_FORMAT", serialize([
        'mp4',
        'mov',
        'ogg',
    ]));

    // Get folder option from URL. Default: 1-partnerwork
    define('DIR', isset($_GET['p']) ? htmlspecialchars($_GET['p']) : '1-partnerwork');
    
    // Get a list of folders name in the first level
    define('LEVEL_0', serialize(scandir(DIR)));

    
    function navHTML(){

        // Get all nodes and Ignore some
        $nodes = ignore(scandir('.'), IGNORED_LIST);

        foreach($nodes as $node){
            $folderName = preg_replace('/[0-9]+/', '', $node);
            $folderName = beautify($folderName);
            echo '<a href="'.dirname($_SERVER['PHP_SELF']).'?p='.$node.'" class="text-grey-dark sm:py-2 hover:bg-grey hover:text-white font-bold py-1 px-4 no-underline">'.$folderName.'</a>';
        }
    }

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

            // If it's a video 
            if(isset($nodeInfo['extension']) && in_array(strtolower($nodeInfo['extension']), unserialize(SOURCE_FORMAT))){
                echo '<div id=\''.linkify($ffName).'\' onclick="setVideo(\''.$dir.'/'.addslashes($node).'\');setTitle(event);" class="video-link sm:p-1 text-blue cursor-pointer bg-grey-light hover:text-blue-lighter hover:bg-blue-darker border-b border-blue text-sm p-2">'.$ffName.'</div>';
            }
            
            // If it's a folder
            if(is_dir($path)){
                // If it's first level
                if(in_array($node, unserialize(LEVEL_0))){
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
    function ignore(Array $dir, $unwantedFiles){
        $unwantedFiles = unserialize($unwantedFiles);

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
    <title>My Repository</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="overflow-auto lg:overflow-hidden">

<!-- App Container -->
<div id="app" class="bg-grey-light flex mb-4 flex-col-reverse lg:flex-row">

    <!-- Sidebar -->
    <div class="lg:overflow-y-scroll w-full text-dark h-screen lg:w-1/5 ">
        <?php listHTML(DIR); ?>
    </div>

    <!-- Content Area -->
    <div class="w-full lg:w-4/5">

        <!-- Mobile Menu Button -->
        <div class="z-50 fixed pin-b pin-r mr-1 mb-1 block lg:hidden">
            <span onclick="showMenu()" class="cursor-pointer flex items-center px-3 py-2 rounded shadow-inner border-blue-darker bg-blue-dark text-blue-lightest hover:bg-blue-darker">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
            </span>
        </div>

        <!-- Nav -->
        <nav id="menu" class="hidden shadow-lg fixed pin-b w-full z-30 lg:relative lg:opacity-100 lg:block bg-grey-lighter p-2 text-center font-bold text-xs md:text-sm text-grey shadow-md uppercase">
            <div class="flex flex-col lg:block lg:flex-row lg:flex-wrap lg:inline-flex">
                <?php navHTML() ;?>
            </div>
        </nav>
        
        <!-- Video Container -->
        <div class="container mx-auto sm:p-4 lg:w-5/6">
            <video id="video" class="lg: w-full sm:shadow-lg sm:rounded border" style="max-height:650px" controls loop>
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

    highlight(btn)
}

function highlight(btn){
    var btns = document.getElementsByClassName('video-link')
    Array.prototype.forEach.call(btns, function(btn){
        btn.classList.remove('p-4', 'bg-blue-darkest', 'font-bold', 'text-blue-lighter')
    })

    btn.classList.add('p-4', 'bg-blue-darkest', 'font-bold', 'text-blue-lighter')
}

function scrollToTitle(){
    var videoTitle = document.getElementById('video-title')
    var videoId = videoTitle.getAttribute('video_id')
    var btnVideo = document.getElementById(videoId)
    btnVideo.scrollIntoView({block: 'center', behavior: 'smooth'})
}

function showMenu(){
    var menu = document.getElementById('menu')
    menu.classList.toggle('hidden')
}   

</script>

</body>
</html>