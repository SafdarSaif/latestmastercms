<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>
<style>
  .form-check-input {
    accent-color: #007bff;
    width: 20px;
    height: 20px;
  }

  .form-check-label {
    margin-left: 5px;
    font-weight: 500;
    font-size: 14px;
  }
</style>

<div class="modal-header">
  <!-- <h3 class="modal-title">Add Wings</h3> -->
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Create Wing</h3>
    <p class="text-muted">Fill in the details to create a new wing easily.</p>
  </div>

  <form id="form-add-wings" action="/admin/app/wings/store" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
    <!-- Name -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="name">Wing Name <span class="text-danger">*</span></label>
      <input type="text" id="name" name="name" class="form-control" placeholder="Enter wing name" required />
      <div class="invalid-feedback">Wing name is required.</div>
    </div>

    <!-- Wing Heading -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="wing_heading">Wings Heading <span class="text-danger">*</span></label>
      <?php $wingHeadingArr = getwingHeadingFunc($conn); ?>
      <select name="wing_heading" id="wing_heading" class="form-control" required>
        <option value="" disabled selected>Select a Wing Heading</option>
        <?php foreach ($wingHeadingArr as $heading) : ?>
          <option value="<?=  $heading['ID'] ?>"><?= $heading['Name'] ?></option>
        <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Wing heading is required.</div>
    </div>

    <!-- Date -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="date">Date <span class="text-danger">*</span></label>
      <input type="date" id="date" name="date" class="form-control" required />
      <div class="invalid-feedback">Date is required.</div>
    </div>

    <!-- Media Type -->
    <div class="col-md-12">
      <label class="form-label fw-semibold">Media Type <span class="text-danger">*</span></label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="media_type" id="media_type_link" value="link" required>
        <label class="form-check-label" for="media_type_link">Link</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="media_type" id="media_type_upload" value="upload" required>
        <label class="form-check-label" for="media_type_upload">Upload</label>
      </div>
    </div>

    <!-- Link Field -->
    <div class="col-md-12 media-field" id="link-field" style="display:none;">
      <label class="form-label fw-semibold" for="media_link">Link <span class="text-danger">*</span></label>
      <input type="url" id="media_link" name="media_link" class="form-control" placeholder="Enter the link">
    </div>

    <!-- Upload Field -->
    <div class="col-md-12 media-field" id="upload-field" style="display:none;">
      <label class="form-label fw-semibold" for="media_file">Photo <span class="text-danger">*</span></label>
      <input type="file" name="media_file" id="media_file" class="form-control" accept="image/*" multiple>
    </div>

    <!-- Content -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
      <textarea id="editor" name="editor" class="ckeditor form-control" rows="10" required></textarea>
      <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
    </div>

    <!-- Meta Title -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
      <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Enter meta title" />
    </div>

    <!-- Meta Key -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
      <input type="text" id="meta_key" name="meta_key" class="form-control" placeholder="Enter meta key" />
    </div>

    <!-- Meta Description -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
      <textarea id="meta_description" name="meta_description" class="form-control" rows="3" placeholder="Enter meta description"></textarea>
    </div>

    <!-- Position -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="position">Order By <span class="text-danger">*</span></label>
      <input type="number" id="position" name="position" class="form-control" placeholder="Enter a position" required />
    </div>

    <!-- Submit Buttons -->
    <div class="col-12 text-center mt-3">
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
    $('#form-add-wings').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-wings").on("submit", function(e) {
    if ($('#form-add-wings').valid()) {
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

            $('#wings-table').DataTable().ajax.reload(null, false);
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