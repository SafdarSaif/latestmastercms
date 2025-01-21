<?php require '../../includes/db-config.php'; ?>
<?php require '../../includes/helper.php'; ?>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Theme Settings</h3>
    <p class="text-muted">Update the master theme settings for your application.</p>
  </div>
  <form id="form-theme-settings" action="/admin/app/themesetting/store" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
    <!-- Theme Name -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="name">Theme Name <span class="text-danger">*</span></label>
      <input type="text" id="name" name="name" class="form-control " placeholder="Enter theme name" required autofocus value="" />
      <div class="invalid-feedback">Theme name is required.</div>
    </div>

    <!-- Logo -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="logo">Logo</label>
      <input type="file" id="logo" name="logo" class="form-control " accept="image/*" />
      <small class="form-text text-muted">Accepted formats: PNG, JPG, JPEG, SVG, AVIF</small>
    </div>

    <!-- Fav-Icon -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="fav_icon">Fav-Icon</label>
      <input type="file" id="fav_icon" name="fav_icon" class="form-control " accept="image/*" />
      <small class="form-text text-muted">Accepted formats: PNG, JPG, ICO</small>
    </div>

    <!-- Footer Information -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="footer_information">Footer Information <span class="text-danger">*</span></label>
      <textarea id="footer_information" name="footer_information" class="form-control " rows="3" placeholder="Enter footer information" required></textarea>
      <div class="invalid-feedback">Footer information is required.</div>
    </div>

   

    <!-- Submit Buttons -->
    <div class="col-12 text-center mt-3">
      <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
      <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
  </form>
</div>

<script>
  // Initialize form validation
  $(function() {
    $('#form-theme-settings').validate({
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      }
    });
  });

  // Submit handler
  $("#form-theme-settings").on("submit", function(e) {
    if ($('#form-theme-settings').valid()) {
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
            $('#themesetting-table').DataTable().ajax.reload(null, false);
          } else {
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });
</script>
