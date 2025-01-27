<?php 
require '../../includes/db-config.php';
require '../../includes/helper.php'; 
?>

<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Create Testimonial</h3>
    <p class="text-muted">Fill in the details to add a new testimonial easily.</p>
  </div>
  
  <div class="form-validation">
    <form class="needs-validation" id="form-add-testimonial" action="/admin/app/testimonials/store" method="POST" enctype="multipart/form-data">
      <div class="row">
        <!-- Name -->
        <div class="mb-3 col-md-6">
          <label class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
        </div>

        <!-- Profile -->
        <div class="mb-3 col-md-6">
          <label class="form-label">Profile <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="profile" placeholder="Enter Profile" required>
        </div>

        <!-- Image -->
        <div class="mb-3 col-md-6">
          <label class="form-label">Image <span class="text-danger">*</span></label>
          <input type="file" name="image" id="image" class="form-control" onchange="fileValidation('image')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif" required>
        </div>

        <!-- Rating -->
        <div class="mb-3 col-md-6">
          <label class="form-label">Rating <span class="text-danger">*</span></label>
          <input type="number" class="form-control" name="rating" placeholder="Enter Rating" min="1" max="5" required>
        </div>

        <!-- Testimonial Text -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Testimonial <span class="text-danger">*</span></label>
          <textarea class="ckeditor form-control" name="testimonial" rows="5" required></textarea>
          <span id="testimonial-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal-footer text-end">
  <button type="submit" form="form-add-testimonial" class="btn btn-primary px-4 shadow-sm">Save</button>
  <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
</div>

<script>
  $(function() {
    $('#form-add-testimonial').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    $("#form-add-testimonial").on("submit", function(e) {
      e.preventDefault();
      if ($('#form-add-testimonial').valid()) {
        var formData = new FormData(this);
        formData.append('testimonial_content', CKEDITOR.instances.testimonial.getData());

        $.ajax({
          url: this.action,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(data) {
            if (data.status == 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#testimonials-table').DataTable().ajax.reload(null, false);
            } else {
              toastr.error(data.message, 'Error');
            }
          },
          error: function(xhr, status, error) {
            toastr.error('An error occurred while saving the testimonial.', 'Error');
          }
        });
      }
    });
  });

  function fileValidation(id) {
    var fi = document.getElementById(id);
    if (fi.files.length > 0) {
      for (var i = 0; i <= fi.files.length - 1; i++) {
        var fsize = fi.files.item(i).size;
        var file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 500) {
          $('#' + id).val('');
          toastr.error("File too Big, each file should be less than or equal to 500KB");
        }
      }
    }
  }
</script>

<script>
  CKEDITOR.replace('testimonial', {
    height: 300 
  });
</script>

