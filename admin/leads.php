<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');  ?>
<style>
    /* .h-10{
        height: 30px;
    } */
    .dt-buttons {
        display: flex;
        align-items: center;
    }

    .gap_dtable {
        gap: 12px;
    }
</style>
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
                        data: 'Message'
                    },

                    {
                        data: ''
                    },
                ],
                // columnDefs: [{
                //     targets: -1,
                //     searchable: false,
                //     title: 'Actions',
                //     orderable: false,
                //     render: function(data, type, full, meta) {
                //         var id = full['ID'];
                //         return (
                //             '<span class="text-nowrap">' +
                //             '<button class="btn btn-sm btn-icon delete-record" onclick="destroy(\'/admin/app/leads/destroy\', ' + id + ')">' +
                //             '<i class="ti ti-trash"></i>' +
                //             '</button>' +
                //             '</span>'
                //         );
                //     },
                // }, ],
                columnDefs: [{
                    targets: -1,
                    searchable: false,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var id = full['ID'];
                        // var content = full['Content'] ? full['Content'] : "{}";
                        var content = full['Content'] ? full['Content'] : null;
                        let view = '';
                        if (content) {
                            view = '<button class="btn btn-sm btn-info" onclick="viewContent(' + id + ')"><i class="ti ti-eye"></i></button>';
                        }
                        // console.log("Content:", content);
                        // let view = '<button class="btn btn-sm btn-info" onclick ="viewContent(' + id + ')" ><i class="ti ti-eye"></i></button>';
                        let del = '<button class="btn btn-sm btn-icon delete-record" onclick="destroy(\'/admin/app/leads/destroy\', ' + id + ')"><i class="ti ti-trash"></i></button>';
                        return '<div>' + view + del + '</div>';

                    }
                }],



                aaSorting: false,
                dom: '<"row mx-1 justify-content-between "<"col-md-3 "l><"col-md-6 d-flex flex-row justify-content-end gap_dtable"f text-end"B>>t<"row mx-2"<"col-md-6"i><"col-md-6"p>>',
                buttons: [{
                    text: 'Export⬇',
                    className: 'btn btn-primary h-10',
                    action: function(e, dt, button, config) {
                        exportData();
                    }
                }],
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

    function exportData() {
        window.location.href = "/admin/app/leads/downloadexcel.php?typeFilter=" + $('#typeFilter').val();
    }
</script>





<script>
    function viewContent(id) {
        $.ajax({
            url: "/admin/app/leads/content.php",
            type: "GET",
            data: {
                id: id
            },
            success: function(data) {
                // console.log(data);
                $('#modal-md-content').html(data);
                $('#modal-md').modal('show');
                
            },
            error: function() {
                alert("Failed to load content.");
            }
        });
    }
</script>

<h4 class="mb-4">Website Leads</h4>

<!-- Filter Section -->
<div class="row mb-3">
    <div class="col-md-3">
        <label for="typeFilter" class="form-label">Filter for Lead Source</label>
        <select id="typeFilter" class="form-select">
            <option value="">All Types</option>
            <<?php foreach ($types as $type): ?>
                <option value="<?= $type; ?>"><?= $type; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

</div>
<!--/ Filter Section -->
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
                    <th>Message</th>
                    <!-- <th>Content</th> -->
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