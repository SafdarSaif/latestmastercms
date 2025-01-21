<div class="modal fade" id="modal-md"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" id="modal-md-content">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="modal-lg-content">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="modal-xl-content">
        </div>
    </div>
</div>
<script>
    function toTitleCase(str) {
        return str
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
    }

    function add(url, modal) {
        if (modal.length > 0) {
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    $('#' + modal + '-content').html(data);
                    $('#' + modal).modal('show');
                }
            })
        } else {
            window.location.href = url
        }
    }

    // function addM(url, modal,id) {
    //     if (modal.length > 0) {
    //         $.ajax({
    //             url: url,
    //             type: "GET",
    //             success: function(data) {
    //                 $('#' + modal + '-content').html(data);
    //                 $('#' + modal).modal('show');
    //             }
    //         })
    //     } else {
    //         window.location.href = url
    //     }
    // }
    

   function addbysession(url, modal,id) {
     // alert(model);
     
     $.ajax({
       url: '/admin/app/' + url + '/create?id='+id,
       type: 'GET',
       success: function(data) {
        $('#' + modal + '-content').html(data);
        $('#' + modal).modal('show');
       }
     })
   }

    function edit(url, modal) {
        $(".modal").modal('hide');
        $.ajax({
            url: url,
            type: "GET",
            success: function(data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }


   function editsetting(url, id, second_id, modal) {
     $.ajax({
       url: '/admin/app/' + url + '/edit?id=' + id + '&second_id=' + second_id,
       type: 'GET',
       success: function(data) {
        $('#' + modal + '-content').html(data);
        $('#' + modal).modal('show');
       }
     })
   }

    // function updateActiveStatus(url, table) {
    //     $.ajax({
    //         url: url,
    //         type: "GET",
    //         processData: false,
    //         contentType: false,
    //         dataType: 'json',
    //         success: function(response) {

    //             if (response.status == 'success') {
    //                 toastr.success(response.message);
    //             } else {
    //                 window.location.href = url
    //             }
    //         }
    //     });
    // }



    // function edit(url, modal) {
    //     $(".modal").modal('hide');
    //     $.ajax({
    //         url: url,
    //         type: "GET",
    //         success: function(data) {
    //             $('#' + modal + '-content').html(data);
    //             $('#' + modal).modal('show');
    //         }
    //     })
    // }

    function edit(url, id, modal) {
    $.ajax({
        url: '/admin/app/' + url + '/edit?id=' + id, 
        type: 'GET',
        success: function(data) {
            $('#' + modal + '-content').html(data);
            $('#' + modal).modal('show');
        }
    });
}


    // function updateActiveStatus(url, table) {
    //     $.ajax({
    //         url: url,
    //         type: "GET",
    //         success: function(response) {
    //             if (response.status == 'success' || response.ct_status === 'success' || response
    //                 .le_status === 'success' || response.current_status === 'success' || response
    //                 .bp_status === 'success') {
    //                 toastr.success(response.message);
    //             } else {
    //                 toastr.error(response.message);
    //             }
    //             $('#' + table).DataTable().ajax.reload();
    //         }
    //     })
    // }
    function updateActiveStatus(url, table, id, column = "Status") {
    $.ajax({
        url: url,
        type: "POST",
        data: {
            table: table,
            id: id,
            column: column
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 200) {
                toastr.success(response.message,'Success');
            } else {
                toastr.error(response.message);
            }
            $('#' + table).DataTable().ajax.reload();
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
        }
    });
}



    function destry(url, table) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            customClass: {
                confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "GET",
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            if (table.length > 0) {
                                $('#' + table).DataTable().ajax.reload();
                            } else {
                                window.location.reload();
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    }
                })
            }
        });
    }
</script>

<!-- <script type="text/javascript">
  function destroy(url, id) {
    $(".modal").modal('hide');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/admin/app/" + url + "/destroy?id=" + id,
          type: 'DELETE',
          dataType: 'json',
          success: function(data) {
            if (data.status == 200) {
              toastr.success(data.message, 'Success');
              $('.table').DataTable().ajax.reload(null, false);;
            } else {
              toastr.error(data.message, 'Error');
            }
          }
        });
      }
    })
  }
</script> -->

<script type="text/javascript">
    function changeStatus(table, id, column = null) {
        $.ajax({
            url: '/admin/app/status/update',
            type: 'post',
            data: {
                table,
                id,
                column
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 200) {
                    toastr.success(data.message, 'Success');
                    var datatable = table == 'Students' ? 'application' : table.toLowerCase();
                    //  alert('#' + datatable + '-table');
                    $('#' + datatable + '-table').DataTable().ajax.reload(null, false);;
                } else {
                    toastr.error(data.message, 'Error');
                    $('#' + table + '-table').DataTable().ajax.reload(null, false);;
                }
            }
        });
    }
</script>
<script>
    function destroy(url, id) {
        $(".modal").modal('hide');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url + "?id=" + id,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == 200) {
                            toastr.success(data.message, 'Success');
                            $('.table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(data.message, 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred. Please try again.', 'Error');
                    }
                });
            }
        });
    }
</script>
<script>
    function allot(url, modal) {
        alert(url);
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }
</script>


</body>


<!-- Mirrored from demos.pixinvent.com/vuexy-html-admin-template/html/vertical-menu-template/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Aug 2024 07:15:43 GMT -->

</html>