<?php
    // Returns used memory (either in percent (without percent sign) or free and overall in bytes)
    function getServerMemoryUsage($getPercentage=true)
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
                        $memoryFree *= 1024;  // convert from kibibytes to bytes
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
                            $memoryTotal *= 1024;  // convert from kibibytes to bytes
                        }

                        // Free memory
                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                            $memoryFree = trim($statLineData[1]);
                            $memoryFree = explode(" ", $memoryFree);
                            $memoryFree = $memoryFree[0];
                            $memoryFree *= 1024;  // convert from kibibytes to bytes
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

    function convertByte($bytes, $binaryPrefix=true) {
        if ($binaryPrefix) {
            $unit=array('B','KiB','MiB','GiB','TiB','PiB');
            if ($bytes==0) return '0 ' . $unit[0];
            return @round($bytes/pow(1024,($i=floor(log($bytes,1024)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
        } else {
            $unit=array('B','KB','MB','GB','TB','PB');
            if ($bytes==0) return '0 ' . $unit[0];
            return @round($bytes/pow(1000,($i=floor(log($bytes,1000)))),2) .' '. (isset($unit[$i]) ? $unit[$i] : 'B');
        }
    }

    function _getServerLoadLinuxData() {
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
    function getServerLoad()
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

    function showCurrentUser() {
        $username = posix_getpwuid(posix_geteuid())['name'];
        echo $username;
    } 
    function showIPAddress() {
        print "IP Address: ".$_SERVER['REMOTE_ADDR'];
    }

    function showHTTPUserAgent() {
        echo $_SERVER['HTTP_USER_AGENT'];
    }

    function showAcceptLanguage() {
        echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    function showServerOS() {
        echo php_uname();
        echo PHP_OS . "; ";
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            echo 'This is a server using Windows!';
        } else {
            echo 'This is a server not using Windows!';
        }
    }

    function showCurrentTime() {
        echo "Current time: ";
        echo date("Y-m-d, Y H:i:s ");
        echo "GMT" . date("P");
    }

    function showCPUUsage() {
        $cpuLoad = getServerLoad();
        if (is_null($cpuLoad)) {
            echo "CPU load not estimateable (maybe too old Windows or missing rights at Linux or Windows)";
        }
        else {
            $cpuLoadFormat = number_format($cpuLoad, 0);
            echo "$cpuLoadFormat%";
        }
    }

    function showProtocol() {
        echo $_SERVER['SERVER_PROTOCOL'];
    }

    function showPHPInfo() {
        echo phpversion();
    }

    function showRAMUsage() {
        $memUsage = getServerMemoryUsage(false);
            echo sprintf("%s / %s (%s%%)</br>",
            convertByte($memUsage["total"] - $memUsage["free"]),
            convertByte($memUsage["total"]),
            $memUsagePerc = number_format(getServerMemoryUsage(true), 2)
        );
    }

    function showServerName() {
        echo $_SERVER['SERVER_NAME'];
    }

    function showServerSoftware() {
        echo $_SERVER['SERVER_SOFTWARE'];
    }

    function showFreeDiscSpace() {
        $df = disk_free_space("/");
        $discFree = convertByte($df);
        echo $discFree;
    }

    function showTotalDiscSpace() {
        $ds = disk_total_space("/");
        $discTotal = convertByte($ds);
        echo $discTotal;
    }

    function showSpaceUsed() {
        $df = disk_free_space("/");
        $ds = disk_total_space("/");
        $dp = ($df / $ds) * 100;
        $dpFormat = number_format($dp, 2);
        echo "$dpFormat%";
    }

    function showRemotePort() {
        echo $_SERVER['REMOTE_PORT'];
    }

    function showScriptFilename() {
        echo $_SERVER['SCRIPT_FILENAME'];
    }
?>
