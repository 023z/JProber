<?php
// Server Time
$dt = new DateTime();
//Functions to txt file
$showCPUUsage = JProber::showCPUUsage();
$showFreeDiscSpace = JProber::showFreeDiscSpace();
$showTotalDiscSpace = JProber::showTotalDiscSpace();
$showSpaceUsage = JProber::showSpaceUsage();
$showRAMUsage = JProber::showRAMUsage();
$showIPAddress = JProber::showIPAddress();
$showRemotePort = JProber::showRemotePort();
$showServerOS = JProber::showServerOS();
$showServerSoftware = JProber::showServerSoftware();
$showHTTPUserAgent = JProber::showHTTPUserAgent();
$showAcceptLanguage = JProber::showAcceptLanguage();
$showServerName = JProber::showServerName();
$dtt = $dt->format('d-m-Y H:i:s');
$fileName = $dt->format('d.m.Y H.i.s');
$showProtocol = JProber::showProtocol();
$showScriptFilename = JProber::showScriptFilename();
$showPHPVersion = JProber::showScriptFilename();

class JProber
{

    // Returns used memory (either in percent (without percent sign) or free and overall in bytes)
    public function getServerMemoryUsage($getPercentage=true)
    {
        $memoryTotal = null;
        $memoryFree = null;

        if (stristr(PHP_OS, "win")) {
            // Get total physical memory (this is in bytes)
            $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
            @exec($cmd, $outputTotalPhysicalMemory);

            // Get free physical memory (this is in kibibytes!)
            $cmd = "wmic OS get FreePhysicalMemory";
            @exec($cmd, $outputFreePhysicalMemory);

            if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                // Find total value
                foreach ($outputTotalPhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryTotal = $line;
                        break;
                    }
                }

                // Find free value
                foreach ($outputFreePhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryFree = $line;
                        $memoryFree *= 1024;
                        break;
                    }
                }
            }
        }
        else
        {
            if (is_readable("/proc/meminfo"))
            {
                $stats = @file_get_contents("/proc/meminfo");

                if ($stats !== false) {
                    // Separate lines
                    $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                    $stats = explode("\n", $stats);

                    // Separate values and find correct lines for total and free mem
                    foreach ($stats as $statLine) {
                        $statLineData = explode(":", trim($statLine));

                        // Total memory
                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                            $memoryTotal = trim($statLineData[1]);
                            $memoryTotal = explode(" ", $memoryTotal);
                            $memoryTotal = $memoryTotal[0];
                            $memoryTotal *= 1024;
                        }

                        // Free memory
                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                            $memoryFree = trim($statLineData[1]);
                            $memoryFree = explode(" ", $memoryFree);
                            $memoryFree = $memoryFree[0];
                            $memoryFree *= 1024;
                        }
                    }
                }
            }
        }

        if (is_null($memoryTotal) || is_null($memoryFree)) {
            return null;
        } else {
            if ($getPercentage) {
                return (100 - ($memoryFree * 100 / $memoryTotal));
            } else {
                return array(
                    "total" => $memoryTotal,
                    "free" => $memoryFree,
                );
            }
        }
    }

    public function convertByte($bytes, $binaryPrefix=true) {
        if ($binaryPrefix) {
            $unit=array('B','KB','MB','GB','TB','PB');
            if ($bytes==0) return '0 ' . $unit[0];
            return @round($bytes/pow(1024,($i=floor(log($bytes,1024)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
        }
    }

    public function _getServerLoadLinuxData() {
        if (is_readable("/proc/stat"))
        {
            $stats = @file_get_contents("/proc/stat");

            if ($stats !== false)
            {
                // Remove double spaces to make it easier to extract values with explode()
                $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find line for main CPU load
                foreach ($stats as $statLine)
                {
                    $statLineData = explode(" ", trim($statLine));

                    // Found!
                    if
                    (
                        (count($statLineData) >= 5) &&
                        ($statLineData[0] == "cpu")
                    )
                    {
                        return array(
                            $statLineData[1],
                            $statLineData[2],
                            $statLineData[3],
                            $statLineData[4],
                        );
                    }
                }
            }
        }
        return null;
    }

    // Returns server load in percent (just number, without percent sign)
    public function getServerLoad()
    {
        $load = null;

        if (stristr(PHP_OS, "win"))
        {
            $cmd = "wmic cpu get loadpercentage /all";
            @exec($cmd, $output);

            if ($output)
            {
                foreach ($output as $line)
                {
                    if ($line && preg_match("/^[0-9]+\$/", $line))
                    {
                        $load = $line;
                        break;
                    }
                }
            }
        }
        else
        {
            if (is_readable("/proc/stat"))
            {
                // Collect 2 samples - each with 1 second period
                // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
                $statData1 = _getServerLoadLinuxData();
                sleep(1);
                $statData2 = _getServerLoadLinuxData();

                if
                (
                    (!is_null($statData1)) &&
                    (!is_null($statData2))
                )
                {
                    // Get difference
                    $statData2[0] -= $statData1[0];
                    $statData2[1] -= $statData1[1];
                    $statData2[2] -= $statData1[2];
                    $statData2[3] -= $statData1[3];

                    // Sum up the 4 values for User, Nice, System and Idle and calculate
                    // the percentage of idle time (which is part of the 4 values!)
                    $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                    // Invert percentage to get CPU time, not idle time
                    $load = 100 - ($statData2[3] * 100 / $cpuTime);
                }
            }
        }

        return $load;
    }

    public function showIPAddress() {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function showHTTPUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function showAcceptLanguage() {
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    public function showServerOS() {
        return php_uname();
        return PHP_OS . "; ";
    }

    public function showCurrentTime() {
        return date("Y-m-d, Y H:i:s ");
        return "GMT" . date("P");
    }

    public function showCPUUsage() {
        $cpuLoad = self::getServerLoad();
        if (is_null($cpuLoad)) {
            echo "CPU load not estimateable (maybe too old Windows or missing rights at Linux or Windows)";
        }
        else {
            $cpuLoadFormat = number_format($cpuLoad, 0);
            return "$cpuLoadFormat%";
        }
    }

    public function showProtocol() {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    public function showPHPInfo() {
        return phpversion();
    }

    public function showRAMUsage() {
        $memUsage = self::getServerMemoryUsage(false);
            return sprintf("%s/%s (%s%%)",
            self::convertByte($memUsage["total"] - $memUsage["free"]),
            self::convertByte($memUsage["total"]),
            $memUsagePerc = number_format(self::getServerMemoryUsage(true), 2)
        );
    }

    public function showServerName() {
        return $_SERVER['SERVER_NAME'];
    }

    public function showServerSoftware() {
        return $_SERVER['SERVER_SOFTWARE'];
    }

    public function showFreeDiscSpace() {
        $df = disk_free_space("/");
        $discFree = self::convertByte($df);
        return $discFree;
    }

    public function showTotalDiscSpace() {
        $ds = disk_total_space("/");
        $discTotal = self::convertByte($ds);
        return $discTotal;
    }

    public function showSpaceUsage() {
        $df = disk_free_space("/");
        $ds = disk_total_space("/");
        $dp = ($df / $ds) * 100;
        $dpFormat = number_format($dp, 2);
        return "$dpFormat%";
    }

    public function showRemotePort() {
        return $_SERVER['REMOTE_PORT'];
    }

    public function showScriptFilename() {
        return $_SERVER['SCRIPT_FILENAME'];
    }
}
?>
