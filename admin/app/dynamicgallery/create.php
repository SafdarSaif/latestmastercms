<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>

<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Create Gallery</h3>
    <p class="text-muted">Fill in the details to add a new gallery easily.</p>
  </div>
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-gallery" action="/admin/app/dynamicgallery/store" method="POST" enctype="multipart/form-data">
      <div class="row">
        <!-- Image Name -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Image Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="image_names" placeholder="Enter Image Name" required>
        </div>

        <!-- Upload Image -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Upload Image <span class="text-danger">*</span></label>
          <input type="file" name="images" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg, image/avif" required>
        </div>
      </div>

      <div class="modal-footer text-end">
        <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
        <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>



<script>
  $(document).ready(function() {
    $('#form-add-gallery').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    $("#form-add-gallery").on("submit", function(e) {
      if ($('#form-add-gallery').valid()) {
        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        $.ajax({
          url: this.action,
          type: 'post',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(data) {
            if (data.status == 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#dynamicgallery-table').DataTable().ajax.reload(null, false);
            } else {
              $(':input[type="submit"]').prop('disabled', false);
              toastr.error(data.message, 'Error');
            }
          }
        });
        e.preventDefault();
      }
    });
  });
</script>
<script>
  function fileValidation(id) {
    var fi = document.getElementById(id);
    if (fi.files.length > 0) {
      for (var i = 0; i <= fi.files.length - 1; i++) {
        var fsize = fi.files.item(i).size;
        var file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 500) {
          $('#' + id).val('');
          // alert("File too Big, each file should be less than or equal to 500KB");
          toastr.error("File too Big, each file should be less than or equal to 500KB");
        }
      }
    }
  }
</script>