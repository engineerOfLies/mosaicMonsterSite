<?php
/**
	@brief used to send an error to the front end
*/
function err($msg)
{
	file_put_contents("/tmp/monstererr.log",$msg."\n",FILE_APPEND);
/*    echo json_encode(array(
        "status"=>"error",
        "message"=> "$msg"
    ));*/
}
?>
