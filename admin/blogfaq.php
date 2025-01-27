<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/side-menu.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php'); ?>
<script type="module">
    $(function() {
        var dataTableblogsfaq = $('#blogsfaq-table'),
            dt_permission;
        // Users List datatable
        if (dataTableblogsfaq.length) {
            dt_permission = dataTableblogsfaq.DataTable({
                ajax: {
                    'url': '/admin/app/blogfaq/server',
                    'type': 'POST',
                    // 'dataSrc': function(json) {
                    // 	console.log('Data received:', json); 
                    // 	return json.data;
                    // }
                },

                columns: [{
                        data: 'No',
                    },
                    {
                        data: 'Blog_Name'
                    },
                    {
                        data: 'Status'
                    },
                    {
                        data: 'Question'
                    },
                    {
                        data: 'Answer'
                    },
                    {
                        data: ''
                    },
                ],
                columnDefs: [{
                        targets: 0,
                        render: function(data, type, full, meta) {
                            return data;
                        }
                    },
                    {
                        // Name
                        targets: 1,
                        render: function(data, type, full, meta) {
                            var $name = full['Blog_Name'];
                            return '<span class="text-nowrap">' + $name + '</span>';
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            var id = full['ID'];
                            var $checkedStatus = full['Status'] == 1 ? 'checked' : '';
                            var $nameStatus = full['Status'] == 1 ? 'Yes' : 'No';
                            return (
                                '<label class="switch">' +
                                '<input type="checkbox" ' +
                                $checkedStatus +
                                ' class="switch-input" onclick="updateActiveStatus(\'/admin/app/status/update\', \'blogsfaq\', ' + id + ')">' +
                                '<span class="switch-toggle-slider">' +
                                '<span class="switch-on">' +
                                '<i class="ti ti-check"></i>' +
                                '</span>' +
                                '<span class="switch-off">' +
                                '<i class="ti ti-x"></i>' +
                                '</span>' +
                                '</span>' +
                                '<span class="switch-label">' + $nameStatus + '</span>' +
                                '</label>'
                            );
                        },
                    },





                    {
                        // Name
                        targets: 2,
                        render: function(data, type, full, meta) {
                            var $name = full['Question'];
                            return '<span class="text-nowrap">' + $name + '</span>';
                        }
                    },
                    {
                        // Name
                        targets: 3,
                        render: function(data, type, full, meta) {
                            var $name = full['Answer'];
                            return '<span class="text-nowrap">' + $name + '</span>';
                        }
                    },


                    {
                        // Actions
                        targets: -1,
                        searchable: false,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            var id = full['ID'];
                            return (
                                '<span class="text-nowrap">' +
                                '<button class="btn btn-sm btn-icon me-2" onclick="edit(\'blogfaq\', ' + id + ', \'modal-lg\')">' +
                                '<i class="ti ti-edit"></i>' +
                                '</button>' +
                                '<button class="btn btn-sm btn-icon delete-record" onclick="destroy(&#39;/admin/app/blogfaq/destroy&#39;, ' + id + ')">' +
                                '<i class="ti ti-trash"></i>' +
                                '</button>' +
                                '</span>'
                            );
                        }
                    }

                ],
                aaSorting: false,
                dom: '<"row mx-1"' +
                    '<"col-sm-12 col-md-3" l>' +
                    '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>' +
                    '>t' +
                    '<"row mx-2"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                language: {
                    sLengthMenu: 'Show _MENU_',
                    search: 'Search',
                    searchPlaceholder: 'Search..'
                },
                buttons: [{
                    text: 'Add BlogFAQ',
                    className: 'add-new btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
                    attr: {
                        'onclick': "add('app/blogfaq/create', 'modal-lg')"

                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }],
                // For responsive popup
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details of ' + data['name'];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !==
                                    '' ? '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<td>' + col.title + ':</td> ' +
                                    '<td>' + col.data + '</td>' +
                                    '</tr>' : '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                }
            });
        }
    });
</script>
<h4 class="mb-4">Blogsfaq</h4>

<!-- Admission Table -->
<div class="card">
    <div class="card-datatable table-responsive">

        <table id="blogsfaq-table" class="table border-top">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Questions</th>
                    <th>Answers</th>
                    <th>Status </th>
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