<h5 class="mt-0 font-17">Server Info</h5>
    <div class="table-responsive">
        <table class="table table-centered">
            <tbody>
                <tr>
                    <td>IP Address:</td>
                    <td>
                        <?php showIPAddress(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Remote Port:</td>
                    <td>
                        <?php showRemotePort(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Server OS:</td>
                    <td>
                        <?php showServerOS(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Server Software:</td>
                    <td>
                        <?php showServerSoftware(); ?>
                    </td>
                </tr>
                <tr>
                    <td>HTTP User Agent:</td>
                    <td>
                        <?php showHTTPUserAgent(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Accept Language:</td>
                    <td>
                        <?php showAcceptLanguage(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Server Name:</td>
                    <td>
                        <?php showServerName(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Server Time:</td>
                    <td>
                        <?php showCurrentTime(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Protocol:</td>
                    <td>
                        <?php showProtocol(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Script Filename:</td>
                    <td>
                        <?php showScriptFilename(); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>