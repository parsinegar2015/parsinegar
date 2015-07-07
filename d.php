<?php
$fullPath = "assets/d/a.pdf";
if($fullPath) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    if($fsize) {//checking if file size exist
      header("Content-length: $fsize");
    }
    readfile($fullPath);
    exit;
}
?>