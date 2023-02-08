<style>
    .label-title {
        color: black;
        font-weight: bold;
    }

    .detail {
        color: black;
        text-align: center;
    }
</style>

<section>
    <div class="container-fluid">
        <div class="alert alert-success" role="alert">
            <i class="fas fa-money"></i> Laporan Monitor PO
        </div>
        <?php echo $this->session->flashdata('pesan') ?>
        <form id="laporan_proses_order_pembelian" method="post" action="<?php echo base_url('admin/laporan/index_MonitorPO') ?>">
            <!-- <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="label-title">Tanggal </label>
                    </div>
                    <div class="col-md-3 nopadding">
                        <input type="text" class="date form-control text_input" id="TGL_1" name="TGL_1" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) { echo $_POST["TGL_1"]; } else echo date('d-m-Y'); ?>">
                    </div>
                    <div class="col-md-1">
                        <label class="label-title">s/d</label>
                    </div>
                    <div class="col-md-3 nopadding">
                        <input type="text" class="date form-control text_input" id="TGL_2" name="TGL_2" data-date-format="dd-mm-yyyy" value="<?php if (isset($_POST["tampilkan"])) { echo $_POST["TGL_2"]; } else echo date('d-m-Y'); ?>">
                    </div>
                </div>
            </div> -->
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-sm-2 nopadding">
                        <button class="btn btn-md btn-secondary" id="tampilkan" name="tampilkan"> Tampilkan </button>
                    </div>
                    <div class="dropdown col-sm-2 nopadding">
                        <button class="btn btn-outline secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-download"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="dropdown-item" id="btnExportCopy">
                                <i class="fa fa-clone"></i> Copy
                            </button>
                            <button type="button" class="dropdown-item" id="btnExportExcel">
                                <i class="fa fa-file-excel-o"></i> Excel
                            </button>
                            <button type="button" class="dropdown-item" id="btnExportCsv">
                                <i class="fas fa-file-csv"></i> Csv
                            </button>
                            <button type="button" class="dropdown-item" id="btnExportPdf">
                                <i class="fa fa-file-pdf-o"></i> Pdf
                            </button>
                            <button class="dropdown-item" id="print" name="print" value="print">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="m-t-10">
            <!-- PASTE DIBAWAH INI -->
            <!-- DISINI BATAS AWAL KOOLREPORT-->
            <?php

            use \koolreport\datagrid\DataTables;
            ?>
            <div class="report-content">
                <?php
                DataTables::create(array(
                    "dataStore" => $monitor_po,
                    "name" => "example",
                    "showFooter" => true,
                    "showFooter" => "bottom",
                    "columns" => array(
                        "NO_PO" => array(
                            "label" => "No Bukti",
                        ),
                        "TGL" => array(
                            "label" => "Tanggal",
                        ),
                        "JTEMPO" => array(
                            "label" => "Jatuh Tempo",
                        ),
                        "KODES" => array(
                            "label" => "Kode Supplier",
                        ),
                        "NAMAS" => array(
                            "label" => "Nama Supplier",
                        ),
                        "NOTESKRM" => array(
                            "label" => "Keterangan",
                        ),
                        "NO_PP" => array(
                            "label" => "No PP",
                        ),
                    ),
                    "cssClass" => array(
                        "table" => "table table-hover table-bordered",
                        "th" => "label-title",
                        "td" => "detail",
                        function ($row, $colName) {
                            if ($colName == "total") {
                                return "text-right";
                            }
                        }
                    ),
                    "options" => array(
                        "paging" => true,
                        "searching" => true,
                        "colReorder" => true,
                        "fixedHeader" => true,
                        "select" => true,
                        "dom" => 'lfrtip',
                        "buttons" => array(
                            array(
                                "extend" => 'collection',
                                "text" => 'Export',
                                "buttons" => [
                                    'copy',
                                    'excel',
                                    'csv',
                                    'pdf',
                                    'print'
                                ],
                            ),
                        ),
                    )
                ));
                ?>
            </div>
            <!-- DISINI BATAS AKHIR KOOLREPORT-->
        </form>
    </div>
</section>
<!-- DISINI BATAS AWAL SCRIPT KOOLREPORT-->

<!-- DISINI BATAS AWAL SCRIPT KOOLREPORT-->
<script type="text/javascript">
    $(document).ready(function() {
        $(".date").datepicker({
            'dateFormat': 'dd-mm-yy'
        })
        $("#btnExportCopy").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-copy').trigger();
        });
        $("#btnExportExcel").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-excel').trigger();
        });
        $("#btnExportPdf").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-pdf').trigger();
        });
        $("#btnExportCsv").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-csv').trigger();
        });
        $("#btnExportPrint").on("click", function() {
            var table = $('#example').DataTable();
            table.button('.buttons-print').trigger();
        });
        $('.date').mask('00-00-0000');
    });

    // day-month-year
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        return [day, month, year].join('-');
    }

    function cekkirim() {
        var tgl_kirim = $('#TGL_KIRIM').val();
        var jtemp = $('#JTEMPO').val();
        var harikrm = tgl_kirim.substr(0, 2);
        var bulankrm = tgl_kirim.substr(3, 2);
        var tahunkrm = tgl_kirim.substr(6, 4);
        krmdate = new Date(tahunkrm + '-' + bulankrm + '-' + harikrm);
        var harijt = jtemp.substr(0, 2);
        var bulanjt = jtemp.substr(3, 2);
        var tahunjt = jtemp.substr(6, 4);
        jtdate = new Date(tahunjt + '-' + bulanjt + '-' + harijt);
        if (krmdate > jtdate) {
            $('#TGL_KIRIM').val(jtemp);
            alert("LEBIH");
        }
    }
</script>