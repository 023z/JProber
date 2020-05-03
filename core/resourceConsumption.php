<h5 class="mt-0 font-17">Server Resource Consumption</h5>
    <div class="table-responsive">
        <table class="table table-centered">
            <tbody>
                <tr>
                    <td>CPU Usage [%]:</td>
                    <td>
                        <?php showCPUUsage(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Free Disc Space:</td>
                    <td>
                        <?php showFreeDiscSpace(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total Disc Space:</td>
                    <td>
                        <?php showTotalDiscSpace(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Space Used [%]:</td>
                    <td>
                        <?php showSpaceUsed(); ?>
                    </td>
                </tr>
                <tr>
                    <td>RAM Usage:</td>
                    <td>
                        <?php showRAMUsage(); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>