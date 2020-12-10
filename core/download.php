<?php
error_reporting(0);
require_once('functions.php');
$path = "logs/".$fileName.".txt";
$file = fopen("$path", "w");
$txt = "---------- Probe Results for ".$showIPAddress." from ".$dtt." ----------\n";
fwrite($file, $txt);
$txt = "CPU Usage [%] - ".$showCPUUsage."\n";
fwrite($file, $txt);
$txt = "Space Usage - ".$showFreeDiscSpace."/".$showTotalDiscSpace." (".$showSpaceUsage.")\n";
fwrite($file, $txt);
$txt = "RAM Usage - ".$showRAMUsage."\n";
fwrite($file, $txt);
$txt = "IP Address - ".$showIPAddress."\n";
fwrite($file, $txt);
$txt = "Remote Port - ".$showRemotePort."\n";
fwrite($file, $txt);
$txt = "Server OS: - ".$showServerOS."\n";
fwrite($file, $txt);
$txt = "Server Software: - ".$showServerSoftware."\n";
fwrite($file, $txt);
$txt = "HTTP User Agent - ".$showHTTPUserAgent."\n";
fwrite($file, $txt);
$txt = "Accept Language - ".$showAcceptLanguage."\n";
fwrite($file, $txt);
$txt = "Server Name - ".$showServerName."\n";
fwrite($file, $txt);
$txt = "Server Time - ".$dtt."\n";
fwrite($file, $txt);
$txt = "Protocol - ".$showProtocol."\n";
fwrite($file, $txt);
$txt = "Script Filename - ".$showScriptFilename."\n";
fwrite($file, $txt);
$txt = "---------- Thank you for using JProber. Have a nice day! -----------\n";
fwrite($file, $txt);
fclose($file);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>JProber</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="JProber" />
        <meta name="author" content="Jan Pabisiak" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/style.min.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" type="image/png" href="../assets/favicon.png"/>
    </head>
    <body data-layout="horizontal">
        <div id="wrapper">
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <h4 class="header-title mb-3">File saved!</h4>
                                    <p><b>Congrats! </b>The prober results have been saved. You can see it here: /core/logs/<?php print $fileName ?>.txt</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo date("Y"); ?> Copyright &copy; | <a href="https://janpabisiak.pl">Jan Pabisiak</a> | JProber v2.0
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>