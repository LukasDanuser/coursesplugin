<?php

/**
 * @package CoursesPlugin
 */

/*https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous
Copyright (C) 2021  Rafisa Informatik GmbH

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/
global $wpdb;
if (!function_exists('wp_handle_upload')) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
}

$uploadedfile = $_FILES['file'];

/* You can use wp_check_filetype() function to check the
 file type and go on wit the upload or stop it.*/

$movefile = wp_handle_upload($uploadedfile, array('test_form' => false));

if ($movefile && !isset($movefile['error'])) {
    echo "File is valid, and was successfully uploaded.\n";
    var_dump($movefile);
    $table_name = "$wpdb->prefix" . "courseVideos";
    $file_path = $movefile['file'];
    $file_url = $movefile['url'];
    $wpdb->insert(
        $table_name,
        array(
            'file_path' => $file_path,
            'file_url' => $file_url,
            'video_name' => $_REQUEST['vidName'],
            'video_description' => $_REQUEST['vidDes'],
        )
    );
} else {
    /**
     * Error generated by _wp_handle_upload()
     * @see _wp_handle_upload() in wp-admin/includes/file.php
     */
    echo $movefile['error'];
}
?><script>
    window.location.href = "/wp-admin/admin.php?page=courses_plugin";
</script>