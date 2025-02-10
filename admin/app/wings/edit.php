<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $getData = $conn->query("SELECT * FROM wings WHERE ID = $id");
  $wingsArr = $getData->fetch_assoc();

  // // Extract Start_Date and End_Date from database record
  // $start_date = date("d-m-Y h:i A", strtotime($wingsArr['Start_Date']));
  // $end_date = date("d-m-Y h:i A", strtotime($wingsArr['End_Date']));
  // $date_range = $start_date . " - " . $end_date; 
  // Extract Start_Date and End_Date, ensuring they are not NULL
  $start_date = !empty($wingsArr['Start_Date']) ? date("d-m-Y h:i A", strtotime($wingsArr['Start_Date'])) : null;
  $end_date = !empty($wingsArr['End_Date']) ? date("d-m-Y h:i A", strtotime($wingsArr['End_Date'])) : null;
  $date_range = ($start_date && $end_date) ? "$start_date - $end_date" : "";
}
?>

<div class="modal-header">
  <!-- <h3 class="modal-title">Edit Wings (<a href="/wings?url=<?= $wingsArr['Slug'] ?>" style="color: #222B40;"><?= $wingsArr['Name'] ?></a>)</h3> -->
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Edit Wing Details</h3>
    <p class="text-muted">Update the information for this wing below.</p>
  </div>
  <form class="row g-3 needs-validation" id="form-add-wings" action="/admin/app/wings/update" method="POST" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="id" value="<?= $wingsArr['ID'] ?>">

    <div class="col-md-6">
      <label class="form-label fw-semibold" for="name">Wing Name <span class="text-danger">*</span></label>
      <input type="text" class="form-control border-primary shadow-sm" name="name" value="<?= $wingsArr['Name'] ?>" required>
      <div class="invalid-feedback">Wing name is required.</div>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold" for="wing_heading">Wing Heading <span class="text-danger">*</span></label>
      <?php $wingHeadingArr = getwingHeadingFunc($conn); ?>
      <select name="wing_heading" id="wing_heading" class="form-control border-primary shadow-sm" required>
        <option value="" disabled selected>Select a Wing Heading</option>
        <?php foreach ($wingHeadingArr as $heading): ?>
          <option value="<?= $heading['ID'] ?>" <?= $wingsArr['Wing_Heading_ID'] == $heading['ID'] ? 'selected' : '' ?>><?= $heading['Name'] ?></option>
        <?php endforeach; ?>
      </select>
      <div class="invalid-feedback">Wing heading is required.</div>
    </div>
    <!-- Date -->
    <!-- <div class="col-md-6">
      <label class="form-label fw-semibold" for="date">Date <span class="text-danger">*</span></label>
      <input type="date" class="form-control border-primary shadow-sm" name="date" value="<?= $wingsArr['Date'] ?>" required>
      <div class="invalid-feedback">Date is required.</div>
    </div> -->
    <div class="col-md-6">
      <label class="form-label fw-semibold" for="date_range">Date Range <span class="text-danger">*</span></label>
      <input type="text" id="date_time_range" name="date" class="form-control" placeholder="Select date range" value="<?= isset($date_range) ? $date_range : '' ?>" required />
      <div class="invalid-feedback">Date range is required.</div>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold" for="media_type">Media Type <span class="text-danger">*</span></label><br>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="media_type" id="media_type_link" value="link" <?= $wingsArr['Media_Type'] == 'link' ? 'checked' : '' ?> required>
        <label class="form-check-label" for="media_type_link">Link</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="media_type" id="media_type_upload" value="upload" <?= $wingsArr['Media_Type'] == 'upload' ? 'checked' : '' ?> required>
        <label class="form-check-label" for="media_type_upload">Upload</label>
      </div>
    </div>

    <div class="col-md-12 media-field" id="link-field" style="display: <?= $wingsArr['Media_Type'] == 'link' ? 'block' : 'none' ?>;">
      <label class="form-label fw-semibold" for="media_link">Link <span class="text-danger">*</span></label>
      <input type="url" name="media_link" id="media_link" class="form-control border-primary shadow-sm" value="<?= $wingsArr['Media_File'] ?>" placeholder="Enter the link">
    </div>

    <div class="col-md-12 media-field" id="upload-field" style="display: <?= $wingsArr['Media_Type'] == 'upload' ? 'block' : 'none' ?>;">
      <label class="form-label fw-semibold" for="media_file">Photo <span class="text-danger">*</span></label>
      <input type="hidden" name="updated_file" value="<?= $wingsArr['Media_File'] ?>">
      <input type="file" name="media_file" id="media_file" class="form-control border-primary shadow-sm" accept="image/*">
      <?php if (!empty($id) && !empty($wingsArr['Media_File'])): ?>
        <img src="<?= $wingsArr['Media_File'] ?>" height="50" />
      <?php endif; ?>
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold" for="editor">Content <span class="text-danger">*</span></label>
      <textarea class="ckeditor border-primary" id="editor" name="editor" rows="10" required><?= $wingsArr['Content'] ?></textarea>
      <div id="content-error" class="text-danger mt-1" style="font-size: 12px;"></div>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_title">Meta Title</label>
      <input type="text" class="form-control border-primary shadow-sm" name="meta_title" value="<?= $wingsArr['Meta_Title'] ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold" for="meta_key">Meta Key</label>
      <input type="text" class="form-control border-primary shadow-sm" name="meta_key" value="<?= $wingsArr['Meta_Key'] ?>">
    </div>

    <div class="col-12">
      <label class="form-label fw-semibold" for="meta_description">Meta Description</label>
      <textarea class="form-control border-primary shadow-sm" name="meta_description" rows="2"><?= $wingsArr['Meta_Description'] ?></textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-semibold" for="position">Order By <span class="text-danger">*</span></label>
      <input type="number" class="form-control border-primary shadow-sm" name="position" value="<?= $wingsArr['Position'] ?>" min="0" required>
    </div>

    <div class="col-12 text-center mt-3">
      <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
      <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
  </form>
</div>


<!-- <script>
  $(document).ready(function() {
    $('#date_time_range').daterangepicker({
      timePicker: true,
      timePicker24Hour: false,
      timePickerSeconds: false,
      locale: {
        format: 'DD-MM-YYYY hh:mm A',
      },
      startDate: moment("<?= $start_date ?>", "DD-MM-YYYY hh:mm A"),
      endDate: moment("<?= $end_date ?>", "DD-MM-YYYY hh:mm A"),
    });
  });
</script> -->

<!-- <script>
  $(document).ready(function() {
    var startDate = "<?= $start_date ?>";
    var endDate = "<?= $end_date ?>";

    if (startDate && endDate) {
      $('#date_time_range').daterangepicker({
        timePicker: true,
        timePicker24Hour: false,
        timePickerSeconds: false,
        locale: {
          format: 'DD-MM-YYYY hh:mm A',
        },
        startDate: moment(startDate, "DD-MM-YYYY hh:mm A"),
        endDate: moment(endDate, "DD-MM-YYYY hh:mm A"),
      });
    } else {
      $('#date_time_range').daterangepicker({
        autoUpdateInput: false,
        timePicker: true,
        timePicker24Hour: false,
        timePickerSeconds: false,
        locale: {
          format: 'DD-MM-YYYY hh:mm A',
        },
      }).val("");
    }
  });
</script> -->

<script>
  $(document).ready(function() {
    var startDate = "<?= $start_date ?>";
    var endDate = "<?= $end_date ?>";

    $('#date_time_range').daterangepicker({
      autoUpdateInput: true,
      timePicker: true,
      timePicker24Hour: false,
      timePickerSeconds: false,
      locale: {
        format: 'DD-MM-YYYY hh:mm A',
        cancelLabel: 'Clear'
      },
      startDate: startDate ? moment(startDate, "DD-MM-YYYY hh:mm A") : moment(),
      endDate: endDate ? moment(endDate, "DD-MM-YYYY hh:mm A") : moment().add(1, 'days')
    }, function(start, end) {
      $('#date_time_range').val(start.format('DD-MM-YYYY hh:mm A') + ' - ' + end.format('DD-MM-YYYY hh:mm A'));
    });

    $('#date_time_range').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('input[name="media_type"]').on('change', function() {
      $('.media-field').hide();
      if ($(this).val() === 'link') $('#link-field').show();
      else $('#upload-field').show();
    });

    $('#form-add-wings').validate({
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      }
    });

    $('#form-add-wings').on('submit', function(e) {
      e.preventDefault();
      if ($(this).valid()) {
        var editorContent = CKEDITOR.instances.editor.getData();
        if (!editorContent.trim()) {
          $('#content-error').text('This field is required.');
          return false;
        }

        var formData = new FormData(this);
        formData.append('content', editorContent);

        $.ajax({
          url: this.action,
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(data) {
            if (data.status === 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#wings-table').DataTable().ajax.reload(null, false);
            } else {
              toastr.error(data.message, 'Error');
            }
          }
        });
      }
    });

    CKEDITOR.replace('editor');
  });
</script>