<?php
    // Require PHP Functions
    require_once('core/functions.php');

    // Auto refresh every 10 seconds
    $url=$_SERVER['REQUEST_URI'];
    $refreshTime = 15;
    header("Refresh: $refreshTime; URL=$url");
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
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.min.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" type="image/png" href="assets/favicon.png"/>
    </head>
    <body data-layout="horizontal">
        <div id="wrapper">
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <h4 class="header-title mb-3">Welcome in JProber!</h4>
                                    <p><b>Warning! </b>This site auto-refresh every 10 seconds.</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="card-box widget-inline">
                                        <div class="row">
                                            <div class="col-xl-3 col-sm-6 widget-inline-box">
                                                <div class="text-center p-3">
                                                    <h2 class="mt-2"><i class="text-primary mdi mdi-cpu-32-bit mr-2"></i> <b><?php print JProber::showCPUUsage() ?></b></h2>
                                                    <p class="text-muted mb-0">CPU Usage [%]</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-6 widget-inline-box">
                                                <div class="text-center p-3">
                                                    <h2 class="mt-2"><i class="text-teal mdi mdi-database-check mr-2"></i> <b><?php print JProber::showFreeDiscSpace(); ?></b></h2>
                                                    <p class="text-muted mb-0">Free Disc Space</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-6 widget-inline-box">
                                                <div class="text-center p-3">
                                                    <h2 class="mt-2"><i class="text-info mdi mdi-database mr-2"></i> <b><?php print JProber::showTotalDiscSpace(); ?></b></h2>
                                                    <p class="text-muted mb-0">Total Disc Space</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-sm-6">
                                                <div class="text-center p-3">
                                                    <h2 class="mt-2"><i class="text-danger mdi mdi-database-lock mr-2"></i> <b><?php print JProber::showSpaceUsage(); ?></b></h2>
                                                        <p class="text-muted mb-0">Space Usage [%]</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                <h5 class="mt-0 font-17">Server Info</h5>
                                    <div class="table-responsive">
                                        <table class="table table-centered">
                                            <tbody>
                                                <tr>
                                                    <td>IP Address:</td>
                                                    <td><?php print JProber::showIPAddress(); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Remote Port:</td>
                                                    <td>
                                                        <?php print JProber::showRemotePort(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Server OS:</td>
                                                    <td>
                                                        <?php print JProber::showServerOS(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Server Software:</td>
                                                    <td>
                                                        <?php print JProber::showServerSoftware(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>HTTP User Agent:</td>
                                                    <td>
                                                        <?php print JProber::showHTTPUserAgent(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Accept Language:</td>
                                                    <td>
                                                        <?php print JProber::showAcceptLanguage(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Server Name:</td>
                                                    <td>
                                                        <?php print JProber::showServerName(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Server Time:</td>
                                                    <td>
                                                        <?php echo $dt->format('d-m-Y H:i:s'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Protocol:</td>
                                                    <td>
                                                        <?php print JProber::showProtocol(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Script Filename:</td>
                                                    <td>
                                                        <?php print JProber::showScriptFilename(); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                <h5 class="mt-0 font-17">Server Resource Consumption</h5>
                                    <div class="table-responsive">
                                        <table class="table table-centered">
                                            <tbody>
                                                <tr>
                                                    <td>CPU Usage [%]:</td>
                                                    <td>
                                                        <?php print JProber::showCPUUsage(); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Space Usage:</td>
                                                    <td>
                                                        <?php print JProber::showFreeDiscSpace(); ?>/<?php print JProber::showTotalDiscSpace(); ?> (<?php print JProber::showSpaceUsage(); ?>)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>RAM Usage:</td>
                                                    <td>
                                                        <?php print JProber::showRAMUsage(); ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                <h5 class="mt-0 font-17">PHP Info</h5>
                                    <div class="table-responsive">
                                        <table class="table table-centered">
                                            <tbody>
                                                <tr>
                                                    <td>PHP Version:</td>
                                                    <td><?php print JProber::showPHPInfo(); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>PHP Info:</td>
                                                    <td><a href="core/phpInfo.php">Click here</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                <h5 class="mt-0 font-17">Download data</h5>
                                    <div class="table-responsive">
                                        <table class="table table-centered">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="core/download.php">Download JProber Results as .txt</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo date("Y"); ?> Copyright &copy; | <a href="https://github.com/janpabisiak">Jan Pabisiak</a> | JProber v2.0
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>