<?php 
require '../../includes/db-config.php';
require '../../includes/helper.php'; 
?>

<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Create Video</h3>
    <p class="text-muted">Fill in the details to add a new video easily.</p>
  </div>

  <div class="form-validation">
    <form class="needs-validation" id="form-add-gallery" action="/admin/app/gallery_video/store" method="POST" enctype="multipart/form-data">
      <!-- Note -->
      <div class="alert alert-info mb-3">
        <strong>Note:</strong> You can either provide a video link or upload a video file. Please do not provide both.
      </div>
      <div class="row">
        <!-- Video Link -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Video Link (Optional)</label>
          <input type="url" class="form-control" name="video_links" id="video_link" placeholder="Video Link">
        </div>

        <!-- Video Upload -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Upload Video (Optional)</label>
          <input type="file" class="form-control" name="video_file" id="video_file" accept="video/*">
        </div>

        <!-- Position -->
        <div class="mb-3 col-md-12">
          <label class="form-label">Position <span class="text-danger">*</span></label>
          <select class="form-control" name="position" required>
            <option value="">Select Position</option>
            <option value="left">Left</option>
            <option value="right">Right</option>
          </select>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal-footer text-end">
  <button type="submit" form="form-add-gallery" class="btn btn-primary px-4 shadow-sm">Save</button>
  <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
</div>

<script>
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

    $('#form-add-gallery').on('submit', function(e) {
      if ($('#form-add-gallery').valid() && validateVideoInputs()) {
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
