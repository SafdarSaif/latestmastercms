<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $getData = $conn->query("SELECT * FROM setting_headings WHERE ID = $id");
  $setting_headingArr = $getData->fetch_assoc();
}
?>

<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Edit Setting Heading</h3>
    <p class="text-muted">Fill in the details to add a Update Heading easily.</p>
  </div>  <form id="form-add-setting_heading" action="/admin/app/setting_heading/update" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    <input type="hidden" name="id" value="<?= $setting_headingArr['ID'] ?>">
    <div class="row">
      
      <!-- Name Field -->
      <div class="col-12 mb-3">
        <label class="form-label fw-semibold" for="name">Name <span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control border-primary shadow-sm" value="<?= $setting_headingArr['Name'] ?>" placeholder="Enter Setting Heading Name" required />
        <div class="invalid-feedback">Setting heading name is required.</div>
      </div>

      <!-- Content Field -->
      <div class="col-12 mb-3">
        <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
        <textarea id="editor" name="editor" class="ckeditor form-control border-primary shadow-sm" rows="10" required><?= $setting_headingArr['Content'] ?></textarea>
        <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
      </div>

      <!-- Meta Title Field -->
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
        <input type="text" id="meta_title" name="meta_title" class="form-control border-primary shadow-sm" value="<?= $setting_headingArr['Meta_Title'] ?>" placeholder="Enter Meta Title" />
      </div>

      <!-- Meta Key Field -->
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
        <input type="text" id="meta_key" name="meta_key" class="form-control border-primary shadow-sm" value="<?= $setting_headingArr['Meta_Key'] ?>" placeholder="Enter Meta Key" />
      </div>

      <!-- Meta Description Field -->
      <div class="col-12 mb-3">
        <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
        <textarea id="meta_description" name="meta_description" class="form-control border-primary shadow-sm" rows="3" placeholder="Enter Meta Description"><?= $setting_headingArr['Meta_Description'] ?></textarea>
      </div>

      <!-- Position Field -->
      <div class="col-md-12 mb-3">
        <label class="form-label fw-semibold" for="position">Order By <span class="text-danger">*</span></label>
        <input type="number" id="position" name="position" class="form-control border-primary shadow-sm" value="<?= $setting_headingArr['Position'] ?>" min="0" placeholder="Enter Position" required />
      </div>

      <!-- Submit and Cancel Buttons -->
      <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
        <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </form>
</div>



<script>
  $(function() {
    $('#form-add-setting_heading').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-setting_heading").on("submit", function(e) {
    if ($('#form-add-setting_heading').valid()) {

      var editorContent = CKEDITOR.instances.editor.getData();
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
            $('#setting_heading-table').DataTable().ajax.reload(null, false);
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

<!-- <script>
  function fileValidation(id) {
    var fi = document.getElementById(id);
    if (fi.files.length > 0) {
      for (var i = 0; i <= fi.files.length - 1; i++) {
        var fsize = fi.files.item(i).size;
        var file = Math.round((fsize / 1024));
        // The size of the file.
        if (file >= 500) {
          $('#' + id).val('');
          alert("File too Big, each file should be less than or equal to 500KB");
        }
      }
    }
  }
</script> -->

<script>
  CKEDITOR.replace('editor');
</script>