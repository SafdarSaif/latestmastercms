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
  <h3 class="modal-title">Add Setting Dependency</h3>
  <button type="button" class="btn-close" data-bs-dismiss="modal">
  </button>
</div>
<div class="card-body">
  <div class="form-validation">
    <form class="needs-validation" role="form" id="form-add-setting_dependency" action="/admin/app/setting_dependency/store" method="POST" enctype="multipart/form-data">
      <div class="row">



        <!-- <div class="mb-3 col-md-12">
          <label class="form-label">Name
            <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="name" placeholder="Enter a setting_dependency Name.." required>
        </div> -->

        <?php
        $query = "SELECT ID, Name FROM setting_headings";
        $result = mysqli_query($conn, $query);

        $headings = [];
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $headings[] = $row;
          }
        }

        $headingArr = getsettingHeadingFunc($conn);
        ?>





        <!-- <?php foreach ($headings as $index => $heading): ?>
          <div class="mb-3 col-md-6">
            <label class="form-label">
              Select <?= "Heading " . ($index + 1) ?>
              <span class="text-danger">*</span>
            </label>
            <select class="form-control" name="heading_<?= $heading['ID'] ?>" required>
              <option value="" disabled selected>Select an option for <?= "Heading " . ($index + 1) ?></option>

              <?php foreach ($headingArr as $option): ?>
                <option value="<?= $option['ID'] ?>"><?= $option['Name'] ?></option>
              <?php endforeach; ?>

            </select>
          </div>
        <?php endforeach; ?> -->

        <?php foreach ($headings as $index => $heading): ?>
          <div class="mb-3 col-md-6">
            <label class="form-label">
              Select <?= "Heading " . ($index + 1) ?>
              <span class="text-danger">*</span>
            </label>
            <select class="form-control" name="heading_<?= $heading['ID'] ?>" id="heading_<?= $heading['ID'] ?>" required>
              <option value="" disabled selected>Select an option for <?= "Heading " . ($index + 1) ?></option>

              <?php foreach ($headingArr as $option): ?>
                <option value="<?= $option['ID'] ?>"><?= $option['Name'] ?></option>
              <?php endforeach; ?>

            </select>
          </div>
        <?php endforeach; ?>




        <div class="mb-3 col-md-12 ">
          <label class="form-label">Content <span class="text-danger">*</span></label>
          <textarea class="ckeditor" cols="80" id="editor" name="editor" rows="10" required></textarea>
          <span id="content-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
        </div>

        <div class="mb-3 col-md-6">
          <label class="form-label">Meta Title
          </label>
          <input type="text" class="form-control" name="meta_title" placeholder="Enter a Meta Title..">
        </div>
        <div class="mb-3 col-md-6">
          <label class="form-label">Meta Key
          </label>
          <input type="text" class="form-control" name="meta_key" placeholder="Enter a Meta Key..">
        </div>
        <div class="mb-3 col-md-12">
          <label class="form-label">Meta Description</label>
          <textarea cols="2" class="form-control" name="meta_description" placeholder="Enter a Meta Description.."></textarea>
        </div>


        <!-- Position -->
        <div class="col-md-12">
          <label class="form-label">Order By <span class="text-danger">*</span></label>
          <input type="number" min="0" class="form-control" name="position" placeholder="Enter a Position..." required>
        </div>
      </div>
      <div class=" modal-footer clearfix text-end">
        <div class="col-md-4 m-t-10 sm-m-t-10">
          <button aria-label="" type="submit" class="btn btn-primary btn-cons btn-animated from-left">
            <span>Save</span>
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

        </div>
      </div>
  </div>
  </form>
</div>
</div>





<script>
  $(document).ready(function() {
    function updateDropdownOptions() {
      // Get all selected option values
      var selectedValues = [];
      $('select[id^="heading_"]').each(function() {
        var selectedVal = $(this).val();
        if (selectedVal) {
          selectedValues.push(selectedVal);
        }
      });

      // Loop through all select elements and disable the options that are already selected
      $('select[id^="heading_"]').each(function() {
        var currentSelect = $(this);
        var hasSelectedOption = false;
        currentSelect.find('option').each(function() {
          var optionValue = $(this).val();
          if (selectedValues.includes(optionValue)) {
            $(this).prop('disabled', true); // Disable the option
          } else {
            $(this).prop('disabled', false); // Enable the option if not selected
          }

          // Check if the current option is selected
          // if ($(this).prop('selected')) {
          //   hasSelectedOption = true;
          // }
        });

        // Show an error message if no option is selected
        if (!hasSelectedOption) {
          currentSelect.addClass('is-invalid');
          currentSelect.closest('.mb-3').find('.invalid-feedback').remove();
          currentSelect.closest('.mb-3').append('<div class="invalid-feedback">This field is required.</div>');
        } else {
          currentSelect.removeClass('is-invalid');
          currentSelect.closest('.mb-3').find('.invalid-feedback').remove();
        }
      });
    }

    // Bind the updateDropdownOptions function to the change event of each select element
    $('select[id^="heading_"]').on('change', function() {
      updateDropdownOptions();
    });

    // Initialize on page load
    updateDropdownOptions();

    // Form submission validation
    $('#form-add-setting_dependency').on('submit', function(e) {
      var isValid = true;

      // Check each select field
      $('select[id^="heading_"]').each(function() {
        if ($(this).val() === "") {
          isValid = false;
          $(this).addClass('is-invalid');
          if (!$(this).closest('.mb-3').find('.invalid-feedback').length) {
            $(this).closest('.mb-3').append('<div class="invalid-feedback">This field is required.</div>');
          }
        } else {
          $(this).removeClass('is-invalid');
          $(this).closest('.mb-3').find('.invalid-feedback').remove();
        }
      });

      // If any field is invalid, prevent form submission
      if (!isValid) {
        e.preventDefault();
      }
    });
  });
</script>

<script>
  $(function() {
    $('#form-add-setting_dependency').validate({
      errorPlacement: function(error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });
  })

  $("#form-add-setting_dependency").on("submit", function(e) {
    if ($('#form-add-setting_dependency').valid()) {
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

            $('#setting_dependency-table').DataTable().ajax.reload(null, false);
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