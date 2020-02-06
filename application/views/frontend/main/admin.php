<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <!-- Card Header -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Record Today</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="row">
                <div onclick="openInNewTab('<?php echo base_url('') ?>')"  style="margin: 1vh; width: 50vh; cursor: pointer" >
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase">
                                        <b>TEXT</b> TEXT
                                    </div>
                                    <div class="h6 mb-0 text-gray-800">
                                        TEXT
                                    </div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        TEXT || TEXT
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus();
    }
</script>