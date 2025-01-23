<?php require '../../includes/db-config.php'; ?>
<?php require '../../includes/helper.php'; ?>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Edit Blog</h3>
    <p class="text-muted">Update the details of the selected blog.</p>
  </div>

  <?php
  if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $blogsArr = $conn->query("SELECT * FROM blogs WHERE ID = $id");
    $blogsArr = $blogsArr->fetch_assoc();
  }
  ?>

  <form id="form-edit-blogs" action="/admin/app/blogs/update" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="id" value="<?= $blogsArr['ID'] ?>">

    <!-- Blog Name -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="name">Blog Name <span class="text-danger">*</span></label>
      <input type="text" id="name" name="name" class="form-control border-primary shadow-sm" placeholder="Enter blog name" value="<?= $blogsArr['Name'] ?>" required autofocus />
      <div class="invalid-feedback">Blog name is required.</div>
    </div>

    <!-- Photo -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="photo">Photo</label>
      <input type="hidden" name="updated_file" value="<?= $blogsArr['Photo'] ?>">
      <input type="file" id="photo" name="photo" class="form-control border-primary shadow-sm" accept="image/*" onchange="fileValidation('photo')" />
      <?php if (!empty($blogsArr['Photo'])) { ?>
        <img src="<?= $blogsArr['Photo'] ?>" height="50" />
      <?php } ?>
      <small class="form-text text-muted">Accepted formats: PNG, JPG, JPEG, SVG, AVIF</small>
    </div>

    <!-- Short Description -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="description">Short Description <span class="text-danger">*</span></label>
      <textarea id="description" name="description" class="form-control border-primary shadow-sm" rows="3" placeholder="Enter a short description" required><?= $blogsArr['Description'] ?></textarea>
      <div class="invalid-feedback">Short description is required.</div>
    </div>

    <!-- Content -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
      <textarea id="editor" name="editor" class="ckeditor border-primary" required><?= $blogsArr['Content'] ?></textarea>
      <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
    </div>

    <!-- Meta Title -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
      <input type="text" id="meta_title" name="meta_title" class="form-control border-primary shadow-sm" placeholder="Enter meta title" value="<?= $blogsArr['Meta_Title'] ?>" />
    </div>

    <!-- Meta Key -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
      <input type="text" id="meta_key" name="meta_key" class="form-control border-primary shadow-sm" placeholder="Enter meta key" value="<?= $blogsArr['Meta_Key'] ?>" />
    </div>

    <!-- Meta Description -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
      <textarea id="meta_description" name="meta_description" class="form-control border-primary shadow-sm" rows="3" placeholder="Enter meta description"><?= $blogsArr['Meta_Description'] ?></textarea>
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
    $('#form-edit-blogs').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  });

  // Submit handler with CKEditor validation
  $("#form-edit-blogs").on("submit", function(e) {
    if ($('#form-edit-blogs').valid()) {
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
            $('#blogs-table').DataTable().ajax.reload(null, false);
          } else {
            toastr.error(data.message, 'Error');
          }
        }
      });
      e.preventDefault();
    }
  });

  // Initialize CKEditor
  CKEDITOR.replace('editor');
</script>

<script>
  function fileValidation(id) {
    var fi = document.getElementById(id);
    if (fi.files.length > 0) {
      for (var i = 0; i <= fi.files.length - 1; i++) {
        var fsize = fi.files.item(i).size;
        var file = Math.round((fsize / 1024)); // Size in KB
        if (file >= 500) {
          $('#' + id).val('');
          alert("File too Big, each file should be less than or equal to 500KB");
        }
      }
    }
  }
</script>
