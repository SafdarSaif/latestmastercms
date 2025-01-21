<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $galleryVideoQuery = $conn->query("SELECT * FROM gallery_video WHERE id = $id");
  $galleryVideoArr = $galleryVideoQuery->fetch_assoc();
}
?>

<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Edit Gallery Video</h3>
    <p class="text-muted">Fill in the details to edit the gallery video.</p>
  </div>
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-edit-gallery" action="/admin/app/gallery_video/update" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $galleryVideoArr['id'] ?>">

      <div class="row">
        <div class="col-md-12">
          <!-- Note -->
          <div class="alert alert-info mb-3">
            <strong>Note:</strong> You can either provide a video link or upload a video file. Please do not provide both.
          </div>

          <!-- Video Link Field -->
          <div class="form-group mb-3">
            <label class="form-label">Video Link (Optional)</label>
            <div id="edit_video_link">
              <div class="input-group mb-3">
                <input
                  type="url"
                  class="form-control video-link"
                  placeholder="Video Link"
                  name="video_links"
                  value="<?= isset($galleryVideoArr['video_link']) ? htmlspecialchars($galleryVideoArr['video_link'], ENT_QUOTES, 'UTF-8') : '' ?>"
                  id="video_link">
              </div>
            </div>
            <!-- Video Preview for Link -->
            <?php if (!empty($galleryVideoArr['video_link'])): ?>
              <div class="video-preview">
                <iframe
                  src="<?= htmlspecialchars($galleryVideoArr['video_link'], ENT_QUOTES, 'UTF-8') ?>"
                  frameborder="0"
                  allow="autoplay; encrypted-media"
                  allowfullscreen
                  style="width: 100%; height: 300px;">
                </iframe>
              </div>
            <?php endif; ?>
          </div>

          <!-- Video Upload Field -->
          <div class="form-group mb-3">
            <label class="form-label">Upload Video (Optional)</label>
            <input
              type="file"
              class="form-control"
              name="video_file"
              id="video_file"
              accept="video/*">
          </div>

          <?php if (!empty($galleryVideoArr['video'])): ?>
            <div class="video-preview">
              <iframe
                src="/admin/<?= htmlspecialchars($galleryVideoArr['video'], ENT_QUOTES, 'UTF-8') ?>"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen
                style="width: 100%; height: 300px;">
              </iframe>
            </div>
          <?php endif; ?>


          <!-- Position Field -->
          <div class="form-group mb-3">
            <label class="form-label">Position</label>
            <select class="form-control" name="position" required>
              <option value="">Select Position</option>
              <option value="left" <?= $galleryVideoArr['position'] == 'left' ? 'selected' : '' ?>>Left</option>
              <option value="right" <?= $galleryVideoArr['position'] == 'right' ? 'selected' : '' ?>>Right</option>
            </select>
          </div>
        </div>

        <div class="modal-footer clearfix text-end">
          <div class="col-md-4 m-t-10 sm-m-t-10">
            <button aria-label="" type="submit" class="btn btn-primary btn-cons btn-animated from-left">
              <span>Save</span>
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- <script>
  $(document).ready(function() {
    // Custom validation for ensuring only one input is provided
    function validateVideoInputs() {
      const videoLink = $('#video_link').val().trim();
      const videoFile = $('#video_file').val().trim();

      if (!videoLink && !videoFile) {
        toastr.error('Please provide either a video link or upload a video.');
        return false;
      }
      if (videoLink && videoFile) {
        toastr.error('Please provide only one input: a video link or an uploaded video.');
        return false;
      }
      return true;
    }

    $('#form-edit-gallery').on('submit', function(e) {
      if ($('#form-edit-gallery').valid() && validateVideoInputs()) {
        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        $.ajax({
          url: this.action,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(data) {
            if (data.status == 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#gallery_video-table').DataTable().ajax.reload(null, false);
            } else {
              $(':input[type="submit"]').prop('disabled', false);
              toastr.error(data.message, 'Error');
            }
          },
          error: function(xhr, status, error) {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error("An error occurred: " + error, 'Error');
          }
        });
        e.preventDefault();
      } else {
        e.preventDefault();
      }
    });
  });
</script> -->

<script>
  $(document).ready(function() {
    $('#form-edit-gallery').on('submit', function(e) {
      if ($('#form-edit-gallery').valid()) {
        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        $.ajax({
          url: this.action,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(data) {
            if (data.status == 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#gallery_video-table').DataTable().ajax.reload(null, false);
            } else {
              $(':input[type="submit"]').prop('disabled', false);
              toastr.error(data.message, 'Error');
            }
          },
          error: function(xhr, status, error) {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error("An error occurred: " + error, 'Error');
          }
        });
        e.preventDefault();
      } else {
        e.preventDefault();
      }
    });
  });
</script>