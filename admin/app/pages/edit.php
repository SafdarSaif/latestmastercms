<?php require '../../includes/db-config.php'; ?>
<?php require '../../includes/helper.php'; ?>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Edit Page</h3>
    <p class="text-muted">Modify the details of the page.</p>  
  </div>

  <?php
  if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $getData = $conn->query("SELECT * FROM pages WHERE ID = $id");
    $pagesArr = $getData->fetch_assoc();
  }
  ?>

  <form id="form-edit-pages" action="/admin/app/pages/update" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    <input type="hidden" name="id" value="<?= $pagesArr['ID'] ?>">

    <div class="row">
      <!-- Page Name -->
      <div class="col-12 mb-3">
        <label class="form-label fw-semibold" for="name">Page Name <span class="text-danger">*</span></label>
        <input type="text" id="name" name="name" class="form-control border-primary shadow-sm" placeholder="Enter page name" value="<?= $pagesArr['Name'] ?>" required />
        <div class="invalid-feedback">Page name is required.</div>
      </div>

      <!-- Photo -->
      <div class="col-12 mb-3">
        <label class="form-label fw-semibold" for="photo">Photo</label>
        <input type="hidden" name="updated_file" value="<?= $pagesArr['Photo'] ?>">
        <input type="file" name="photo" id="photo" class="form-control border-primary shadow-sm" accept="image/*" onchange="fileValidation('photo')" />
        <small class="form-text text-muted">Accepted formats: PNG, JPG, JPEG, SVG, AVIF</small>
        <?php if (!empty($pagesArr['Photo'])) { ?>
          <img src="/admin<?= $pagesArr['Photo'] ?>" height="50" />
        <?php } ?>
      </div>

      <!-- Content -->
      <div class="col-12 mb-3">
        <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
        <textarea id="editor" name="editor" class="ckeditor " required><?= $pagesArr['Content'] ?></textarea>
        <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
      </div>

      <!-- Meta Title -->
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
        <input type="text" id="meta_title" name="meta_title" class="form-control border-primary shadow-sm" placeholder="Enter meta title" value="<?= $pagesArr['Meta_Title'] ?>" />
      </div>

      <!-- Meta Key -->
      <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
        <input type="text" id="meta_key" name="meta_key" class="form-control border-primary shadow-sm" placeholder="Enter meta key" value="<?= $pagesArr['Meta_Key'] ?>" />
      </div>

      <!-- Meta Description -->
      <div class="col-12 mb-3">
        <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
        <textarea id="meta_description" name="meta_description" class="form-control border-primary shadow-sm" rows="3" placeholder="Enter meta description"><?= $pagesArr['Meta_Description'] ?></textarea>
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
    $('#form-edit-pages').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-edit-pages").on("submit", function(e) {
    if ($('#form-edit-pages').valid()) {

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