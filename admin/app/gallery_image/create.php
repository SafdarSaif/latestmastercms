<?php require '../../includes/db-config.php';
require '../../includes/helper.php'; ?>

<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Add New Gallery</h3>
    <p class="text-muted">Fill in the details to add a new gallery easily.</p>
  </div>

  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-gallery" action="/admin/app/gallery_image/store" method="POST" enctype="multipart/form-data">
      <div class="row">
        <!-- Gallery Name Dropdown -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Select Gallery <span class="text-danger">*</span></label>
          <?php $galleryArr = getgalleryFunc($conn); ?>
          <select name="gallery_id" id="gallery_id" class="form-control sumoselect" required>
            <option value="">Select Gallery</option>
            <?php foreach ($galleryArr as $gallery) { ?>
              <option value="<?= $gallery['id'] ?>"><?= $gallery['image_name'] ?></option>
            <?php } ?>
          </select>
        </div>

        
        <!-- Upload Image -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Upload Images <span class="text-danger">*</span></label>
          <div id="add_new_images">
            <div class="input-group mb-3">
              <input type="file" class="form-control image-upload" id="photo" onchange="fileValidation('photo')" accept="image/*" name="images[]" multiple required>
              <button type="button" class="btn btn-danger remove-image">Remove</button>
            </div>
          </div>
          <button type="button" class="btn btn-primary add-image">Add Image</button>
        </div>
      </div>

      <div class="modal-footer clearfix text-end">
        <div class="col-md-4 m-t-10 sm-m-t-10">
          <button type="submit" class="btn btn-primary btn-cons btn-animated from-left">
            <span>Save</span>
          </button>
        </div>
        <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    var count = 0;

    $('.add-image').on('click', function() {
      count++;
      var html = '<div class="input-group mb-3">' +
        '<input type="file" class="form-control image-upload" id="photo' + count + '" onchange="fileValidation(\'photo' + count + '\')" accept="image/*" name="images[]" multiple required >' +
        '<button type="button" class="btn btn-danger remove-image">Remove</button>' +
        '</div>';

      $('#add_new_images').append(html);
    });

    $('#add_new_images').on('click', '.remove-image', function() {
      $(this).closest('.input-group').remove();
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#form-add-gallery').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    $("#form-add-gallery").on("submit", function(e) {
      if ($('#form-add-gallery').valid()) {
        $(':input[type="submit"]').prop('disabled', true);
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
              $('#gallery_image-table').DataTable().ajax.reload(null, false);
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