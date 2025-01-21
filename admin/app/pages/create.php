<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>

<div class="modal-body p-4">
<div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Create Page</h3>
    <p class="text-muted">Fill in the details to create a new page easily.</p>  
</div>
<div class="modal-body p-4">
  
  <form id="form-add-pages" action="/admin/app/pages/store" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
  <div class="row">

    <!-- Page Name -->
    <div class="col-12 mb-3">
      <label class="form-label fw-semibold" for="name">Page Name <span class="text-danger">*</span></label>
      <input type="text" id="name" name="name" class="form-control border-primary shadow-sm" placeholder="Enter page name" required />
      <div class="invalid-feedback">Page name is required.</div>
    </div>

    <!-- Photo -->
    <div class="col-12 mb-3">
      <label class="form-label fw-semibold" for="photo">Photo</label>
      <input type="file" id="photo" name="photo" class="form-control border-primary shadow-sm" accept="image/*" />
      <small class="form-text text-muted">Accepted formats: PNG, JPG, JPEG, SVG, AVIF</small>
    </div>

    <!-- Content -->
    <div class="col-12 mb-3">
      <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
      <textarea id="editor" name="editor" class="ckeditor form-control border-primary shadow-sm" required></textarea>
      <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
    </div>

    <!-- Meta Title -->
    <div class="col-md-6 mb-3">
      <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
      <input type="text" id="meta_title" name="meta_title" class="form-control border-primary shadow-sm" placeholder="Enter meta title" />
    </div>

    <!-- Meta Key -->
    <div class="col-md-6 mb-3">
      <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
      <input type="text" id="meta_key" name="meta_key" class="form-control border-primary shadow-sm" placeholder="Enter meta key" />
    </div>

    <!-- Meta Description -->
    <div class="col-12 mb-3">
      <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
      <textarea id="meta_description" name="meta_description" class="form-control border-primary shadow-sm" rows="3" placeholder="Enter meta description"></textarea>
    </div>

    <!-- Submit Buttons -->
    <div class="col-12 text-center mt-3">
      <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
      <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
  </form>
</div>





<script>
  $(function() {
    $('#form-add-pages').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-pages").on("submit", function(e) {
    if ($('#form-add-pages').valid()) {
      // $(':input[type="submit"]').prop('disabled', true);

      var editorContent = CKEDITOR.instances.editor.getData();
      if (editorContent == '') {
        $("#content-error").text("This field is required.");
        return false;
      }
      var formData = new FormData(this);
      formData.append('content', editorContent);

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

            $('#pages-table').DataTable().ajax.reload(null, false);
          } else {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });
</script>

<script>
  CKEDITOR.replace('editor');
</script>