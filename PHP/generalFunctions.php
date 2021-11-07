<?php 
function logError($message) 
{
    try 
    {
        // Opening a text file in append mode, setting the current time and date as prefex then writing the message and closing the file.
        $log = fopen("../errorLog.txt", "a+") or die("Unable to open error log file!");
        $currentDate = new DateTime();
        $logPrefix = $currentDate->format('Y-m-d H:i:s:u');
        $logPrefix =  "\n" . $logPrefix . ": ";
        fwrite($log, $logPrefix . $message . "\n");
        fclose($log);   
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
}

?>