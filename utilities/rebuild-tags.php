<?php
if( !preg_match('~/admin$~', realpath(dirname(__FILE__))) )
{
    echo "This file must be located in the admin directory of your TubeX installation";
    exit;
}
define('TUBEX_CONTROL_PANEL', true);
require_once('includes/cp-global.php');
$DB = GetDB();
$DB->Update('DELETE FROM `tbx_video_tag`');
$result = $DB->Query('SELECT * FROM `tbx_video` WHERE `status`=? AND `is_private`=?', array(STATUS_ACTIVE, 0));
while( $video = $DB->NextRow($result) )
{
    $video['tags'] = Tags::Format($video['tags']);
    Tags::AddToFrequency($video['tags']);

    $DB->Update('UPDATE `tbx_video` SET `tags`=? WHERE `video_id`=?', array($video['tags'], $video['video_id']));
}
$DB->Free($result);
echo "VIDEO TAGS HAVE BEEN SUCCESSFULLY UPDATED!\n";
?>
