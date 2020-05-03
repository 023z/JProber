<?php
    // Require PHP Functions
    require_once('core/functions.php');

    // Auto refresh every 10 seconds
    $url=$_SERVER['REQUEST_URI'];
    header("Refresh: 10; URL=$url");
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
                                        <?php
                                            // Server Details
                                            require_once('core/serverDetails.php');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <?php
                                        // Server Info
                                        require_once('core/serverInfo.php');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <?php
                                        // Resource Consumption
                                        require_once('core/resourceConsumption.php');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <?php
                                        // PHP Info
                                        require_once('core/phpDetails.php');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        // PHP Footer
                        require_once('core/footer.php');
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>