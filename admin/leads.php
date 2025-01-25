<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/side-menu.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php'); ?>


<?php
include './includes/db-config.php';

$typeQuery = "SELECT DISTINCT Type FROM leads";
$typeResults = mysqli_query($conn, $typeQuery);

$types = [];
while ($row = mysqli_fetch_assoc($typeResults)) {
    $types[] = $row['Type'];
}
?>
<script type="module">
    $(function() {
        var dataTableleads = $('#leads-table'),
            dt_permission;

        if (dataTableleads.length) {
            dt_permission = dataTableleads.DataTable({
                ajax: {
                    url: '/admin/app/leads/server.php',
                    type: 'POST',
                    data: function(d) {
                        d.typeFilter = $('#typeFilter').val(); 
                    },
                },
                columns: [{
                        data: 'No'
                    },
                    {
                        data: 'Name'
                    },
                    {
                        data: 'Phone'
                    },
                    {
                        data: 'Email'
                    },
                    {
                        data: ''
                    },
                ],
                columnDefs: [{
                        targets: 0,
                        render: function(data, type, full, meta) {
                            return data;
                        },
                    },
                    {
                        targets: 1,
                        render: function(data, type, full, meta) {
                            return '<span class="text-nowrap">' + full['Name'] + '</span>';
                        },
                    },
                    {
                        targets: 2,
                        render: function(data, type, full, meta) {
                            return '<span class="text-nowrap">' + full['Phone'] + '</span>';
                        },
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            return '<span class="text-nowrap">' + full['Email'] + '</span>';
                        },
                    },
                    {
                        targets: -1,
                        searchable: false,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var id = full['ID'];
                            return (
                                '<span class="text-nowrap">' +
                                '<button class="btn btn-sm btn-icon delete-record" onclick="destroy(\'/admin/app/leads/destroy\', ' + id + ')">' +
                                '<i class="ti ti-trash"></i>' +
                                '</button>' +
                                '</span>'
                            );
                        },
                    },
                ],
                aaSorting: false,
                dom: '<"row mx-1"<"col-md-3"l><"col-md-9"f>>t<"row mx-2"<"col-md-6"i><"col-md-6"p>>',
                language: {
                    sLengthMenu: 'Show _MENU_',
                    search: 'Search',
                    searchPlaceholder: 'Search..',
                },
            });

            $('#typeFilter').on('change', function() {
                dt_permission.ajax.reload(); 
            });
        }
    });
</script>

<h4 class="mb-4">Website Leads</h4>

<!-- Filter Section -->
<div class="row mb-3">
    <div class="col-md-3">
        <label for="typeFilter" class="form-label">Filter for Lead Source</label>
        <select id="typeFilter" class="form-select">
            <option value="">All Types</option>
            <<?php foreach ($types as $type): ?>
                <option value="<?=$type; ?>"><?=$type; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Admission Table -->
<div class="card">
    <div class="card-datatable table-responsive">

        <table id="leads-table" class="table border-top">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <!-- <th>Status</th> -->
                    <th>Phone</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!--/ Admission Table -->
<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-top.php');

include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-bottom.php');

?>