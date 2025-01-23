<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $galleryArr = $conn->query("SELECT * FROM gallery WHERE id = $id");
  $galleryArr = $galleryArr->fetch_assoc();
}
?>

<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Edit Gallery</h3>
    <p class="text-muted">Fill in the details to edit the gallery easily.</p>

  </div>


  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-edit-gallery" action="/admin/app/dynamicgallery/update" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $galleryArr['id'] ?>">

      <!-- Image Name -->
      <div class="mb-3">
        <label class="form-label">Image Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" value="<?= $galleryArr['image_name'] ?>" name="image_names" placeholder="Enter Image Name" required>
      </div>

      <!-- Upload Image -->
      <div class="mb-3">
        <label class="form-label">Upload Image</label>
        <input type="hidden" name="updated_file" value="<?= $galleryArr['image_link'] ?>">
        <input type="file" name="images" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg, image/avif">
        <?php if (!empty($id) && !empty($galleryArr['image_link'])) { ?>
          <div class="mt-2">
            <img src="<?= $galleryArr['image_link'] ?>" alt="Gallery Image" height="50" class="border">
          </div>
        <?php } ?>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer text-end">
        <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
        <button type="button" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>


<script>
  $(function() {
    $('#form-edit-gallery').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-edit-gallery").on("submit", function(e) {
    if ($('#form-edit-gallery').valid()) {
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