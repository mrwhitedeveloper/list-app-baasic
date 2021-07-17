<?php 
 
// Load and initialize downloader class 
include_once 'lib/YouTubeDownloader.class.php'; 
$handler = new YouTubeDownloader(); 
 
// Youtube video url 
$youtubeURL = $_REQUEST['vurl']; 
 
// Check whether the url is valid 
if(!empty($youtubeURL) && !filter_var($youtubeURL, FILTER_VALIDATE_URL) === false){ 
    // Get the downloader object 
    $downloader = $handler->getDownloader($youtubeURL); 
     
    // Set the url 
    $downloader->setUrl($youtubeURL); 
     
    // Validate the youtube video url 
    if($downloader->hasVideo()){ 
        // Get the video download link info 
        $videoDownloadLink = $downloader->getVideoDownloadLink(); 
         
        $videoTitle = $videoDownloadLink[0]['title']; 
        $videoQuality = $videoDownloadLink[0]['qualityLabel']; 
        $videoFormat = $videoDownloadLink[0]['format']; 
        $videoFileName = strtolower(str_replace(' ', '_', $videoTitle)).'.'.$videoFormat; 
        $downloadURL = $videoDownloadLink[0]['url']; 
        $fileName = preg_replace('/[^A-Za-z0-9.\_\-]/', '', basename($videoFileName)); 
        $response['title']=$videoTitle;
        $response['url']=$downloadURL;
        $response['file_name']=$fileName;
        $response['video_quality']=$videoQuality;
        $response['video_format']=$videoFormat;

         
        // if(!empty($downloadURL)){ 
        //     // Define header for force download 
        //     header("Cache-Control: public"); 
        //     header("Content-Description: File Transfer"); 
        //     header("Content-Disposition: attachment; filename=$fileName"); 
        //     header("Content-Type: application/zip"); 
        //     header("Content-Transfer-Encoding: binary"); 
             
        //     // Read the file 
        //     readfile($downloadURL); 
        // } 
    }else{ 
        $response['title']="Please check URL."; 
    } 
}else{ 
    $response['title']="Please provide valid URL.";
} 
echo json_encode($response);
?>