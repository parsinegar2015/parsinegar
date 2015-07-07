<?php

/**
 * Upload a file to the authenticated user's Dropbox
 * @link https://www.dropbox.com/developers/reference/api#files-POST
 * @link https://github.com/BenTheDesigner/Dropbox/blob/master/Dropbox/API.php#L80-110
 */

// Require the bootstrap
require_once('dropbox/examples/bootstrap.php');

// Create a temporary file and write some data to it
//$tmp = tempnam('/tmp', 'dropbox');
//$data = 'This file was uploaded using the Dropbox API!';
//file_put_contents($tmp, $data);
$file = "dropbox\db_backup\db.sql";
$data = fopen($file,"r");
$tmp = tempnam('/tmp', 'dropbox');
file_put_contents($tmp, $data);

try {
    // Upload the file with an alternative filename
    $put = $dropbox->putFile($tmp,'db.sql'); //api_upload_test
    var_dump($put);
} catch (\Dropbox\Exception\BadRequestException $e) {
    // The file extension is ignored by Dropbox (e.g. thumbs.db or .ds_store)
    echo 'Invalid file extension';
}

// Unlink the temporary file
unlink($tmp);