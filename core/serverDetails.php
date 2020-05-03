<div class="row">
    <div class="col-xl-3 col-sm-6 widget-inline-box">
        <div class="text-center p-3">
            <h2 class="mt-2"><i class="text-primary mdi mdi-cpu-32-bit mr-2"></i> <b><?php showCPUUsage(); ?></b></h2>
            <p class="text-muted mb-0">CPU Usage [%]</p>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 widget-inline-box">
        <div class="text-center p-3">
            <h2 class="mt-2"><i class="text-teal mdi mdi-database-check mr-2"></i> <b><?php showFreeDiscSpace(); ?></b></h2>
            <p class="text-muted mb-0">Free Disc Space</p>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 widget-inline-box">
        <div class="text-center p-3">
            <h2 class="mt-2"><i class="text-info mdi mdi-database mr-2"></i> <b><?php showTotalDiscSpace(); ?></b></h2>
            <p class="text-muted mb-0">Total Disc Space</p>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="text-center p-3">
            <h2 class="mt-2"><i class="text-danger mdi mdi-database-lock mr-2"></i> <b><?php showSpaceUsed(); ?></b></h2>
                <p class="text-muted mb-0">Space Used [%]</p>
        </div>
    </div>
</div>