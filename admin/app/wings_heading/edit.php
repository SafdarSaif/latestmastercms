<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $getData = $conn->query("SELECT * FROM wings_heading WHERE ID = $id");
  $wings_headingArr = $getData->fetch_assoc();
}
?>

<div class="modal-header">
  <h3 class="modal-title">Edit Wings Heading (<a href="/wings_heading?url=<?= $wings_headingArr['Slug'] ?>" style="color: #222B40;"><?= $wings_headingArr['Name'] ?></a>)</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <form id="form-edit-wings_heading" action="/admin/app/wings_heading/update" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
    <!-- ID (hidden) -->
    <input type="hidden" name="id" value="<?= $wings_headingArr['ID'] ?>">

    <!-- Name -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="name">Name <span class="text-danger">*</span></label>
      <input type="text" id="name" name="name" class="form-control border-primary shadow-sm" value="<?= $wings_headingArr['Name'] ?>" placeholder="Enter a Wings Heading Name" required>
      <div class="invalid-feedback">Name is required.</div>
    </div>

    <!-- Category -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="category">Category <span class="text-danger">*</span></label>
      <select id="category" name="category" class="form-control border-primary shadow-sm" required>
        <option value="" disabled>Select a Category</option>
        <?php foreach ($categoryArr as $key => $value): ?>
          <option value="<?= $key ?>" <?= ($key == $wings_headingArr['Category']) ? 'selected' : '' ?>><?= $value ?></option>
        <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Category is required.</div>
    </div>

    <!-- Content -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
      <textarea id="editor" name="editor" class="ckeditor form-control border-primary shadow-sm" required><?= $wings_headingArr['Content'] ?></textarea>
      <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
    </div>

    <!-- Meta Title -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
      <input type="text" id="meta_title" name="meta_title" class="form-control border-primary shadow-sm" value="<?= $wings_headingArr['Meta_Title'] ?>" placeholder="Enter a Meta Title">
    </div>

    <!-- Meta Key -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
      <input type="text" id="meta_key" name="meta_key" class="form-control border-primary shadow-sm" value="<?= $wings_headingArr['Meta_Key'] ?>" placeholder="Enter a Meta Key">
    </div>

    <!-- Meta Description -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
      <textarea id="meta_description" name="meta_description" class="form-control border-primary shadow-sm" rows="3" placeholder="Enter a Meta Description"><?= $wings_headingArr['Meta_Description'] ?></textarea>
    </div>

    <!-- Position -->
    <div class="col-md-12">
      <label class="form-label fw-semibold" for="position">Order By <span class="text-danger">*</span></label>
      <input type="number" id="position" name="position" class="form-control border-primary shadow-sm" min="0" value="<?= $wings_headingArr['Position'] ?>" placeholder="Enter the Position" required>
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
  $(function() {
    $('#form-edit-wings_heading').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    $("#form-edit-wings_heading").on("submit", function(e) {
      if ($('#form-edit-wings_heading').valid()) {

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
  });

  CKEDITOR.replace('editor');
</script>
