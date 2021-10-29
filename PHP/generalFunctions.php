<?php 
function logError($message) 
{
    try 
    {

        $log = fopen("../errorLog.txt", "a+") or die("Unable to open error log file!");
        $currentDate = new DateTime();
        $logPrefix = $currentDate->format('Y-m-d H:i:s:u');
        $logPrefix =  "\n" . $logPrefix . ": ";
        fwrite($log, $logPrefix . $message . "\n");
        fclose($log);   
    }
    catch (Exception $e)
    {
        die("fuckign guckad");
        die($e->getMessage());
    }
}

function getCallingFunctionName($completeTrace=false)
{
    $trace=debug_backtrace();
    if($completeTrace)
    {
        $str = '';
        foreach($trace as $caller)
        {
            $str .= " -- Called by {$caller['function']}";
            if (isset($caller['class']))
                $str .= " From Class {$caller['class']}";
        }
    }
    else
    {
        $caller=$trace[2];
        $str = "Called by {$caller['function']}";
        if (isset($caller['class']))
            $str .= " From Class {$caller['class']}";
    }
    return $str;
}
?>