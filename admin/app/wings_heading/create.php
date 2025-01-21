<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>



<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Add Wings Heading</h3>
    <p class="text-muted">Provide the necessary details to create a new Wings Heading.</p>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <form id="form-add-wings_heading" action="/admin/app/wings_heading/store" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
    <!-- Name -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="name">Name <span class="text-danger">*</span></label>
      <input type="text" id="name" name="name" class="form-control border-primary shadow-sm" placeholder="Enter a Wings Heading Name" required>
      <div class="invalid-feedback">Name is required.</div>
    </div>

    <!-- Category -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="category">Category <span class="text-danger">*</span></label>
      <select id="category" name="category" class="form-control border-primary shadow-sm" required>
        <option value="" disabled selected>Select a Category</option>
        <?php foreach ($categoryArr as $key => $value) : ?>
          <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
        <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Category is required.</div>
    </div>

    <!-- Content -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
      <textarea id="editor" name="editor" class="ckeditor " required></textarea>

      <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
    </div>

    <!-- Meta Title -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
      <input type="text" id="meta_title" name="meta_title" class="form-control border-primary shadow-sm" placeholder="Enter a Meta Title">
    </div>

    <!-- Meta Key -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
      <input type="text" id="meta_key" name="meta_key" class="form-control border-primary shadow-sm" placeholder="Enter a Meta Key">
    </div>

    <!-- Meta Description -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
      <textarea id="meta_description" name="meta_description" class="form-control border-primary shadow-sm" rows="3" placeholder="Enter a Meta Description"></textarea>
    </div>

    <!-- Position -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="position">Order By <span class="text-danger">*</span></label>
      <input type="number" id="position" name="position" class="form-control border-primary shadow-sm" min="0" placeholder="Enter the Position" required>
      <div class="invalid-feedback">Position is required.</div>
    </div>

    <!-- Buttons -->
    <div class="col-md-12 text-center mt-3">
      <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
      <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
  </form>
</div>



<script>
  $('input[name="media_type"]').on('change', function() {
    if ($(this).val() === 'link') {
      $('#link-field').show();
      $('#upload-field').hide();
    } else {
      $('#upload-field').show();
      $('#link-field').hide();
    }
  });
</script>

<script>
  $(function() {
    $('#form-add-wings_heading').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-wings_heading").on("submit", function(e) {
    if ($('#form-add-wings_heading').valid()) {
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

            $('#wings_heading-table').DataTable().ajax.reload(null, false);
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