<?php require '../../includes/db-config.php'; ?>
<?php require '../../includes/helper.php'; ?>
<style>
  select[id^="heading_"] {
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  select[id^="heading_"] option:checked {
    background-color: #007bff;
    color: white;
  }

  select[id^="heading_"] option:disabled {
    background-color: #f0f0f0;
    color: #ccc;
    cursor: not-allowed;
  }

  select[id^="heading_"]:hover {
    background-color: #e9ecef;
  }

  .invalid-feedback {
    font-size: 12px;
    color: #b91e1e;
  }

  .is-invalid {
    border-color: #b91e1e;
  }

  #content-error {
    font-size: 12px;
    color: #b91e1e;
  }
</style>
<div class="modal-header">
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Create Setting Depenedency</h3>
    <p class="text-muted">Fill in the details to add a new Depenedency easily.</p>
  </div>
  <div class="form-validation">
    <form class="needs-validation" id="form-add-setting_dependency" action="/admin/app/setting_dependency/store" method="POST">
      <div class="row">
        <?php
        $query = "SELECT ID, Name FROM setting_headings WHERE Status = 1";
        $result = mysqli_query($conn, $query);
        $headings = [];
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $headings[] = $row;
          }
        }
        foreach ($headings as $index => $heading): ?>
          <div class="mb-3 col-md-6">
            <label class="form-label">Select Heading <?= $index + 1 ?> <span class="text-danger">*</span></label>
            <select class="form-control" name="heading_<?= $heading['ID'] ?>" id="heading_<?= $heading['ID'] ?>" required>
              <option value="" disabled selected>Select an option for Heading <?= $index + 1 ?></option>
              <?php foreach ($headings as $option): ?>
                <option value="<?= $option['ID'] ?>"><?= $option['Name'] ?>ID=<?= $option['ID'] ?></option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">This field is required.</div>
          </div>
        <?php endforeach; ?>
        <div class="mb-3 col-md-12">
          <label class="form-label">Content <span class="text-danger">*</span></label>
          <textarea class="ckeditor" id="editor" name="editor" rows="10"></textarea>
          <span id="content-error"></span>
        </div>
      </div>
      <div class="modal-footer text-end">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    function updateDropdownOptions() {
      var selectedValues = [];
      $('select[id^="heading_"]').each(function() {
        var selectedVal = $(this).val();
        if (selectedVal) {
          selectedValues.push(selectedVal);
        }
      });

      $('select[id^="heading_"]').each(function() {
        var currentSelect = $(this);
        currentSelect.find('option').each(function() {
          var optionValue = $(this).val();
          if (selectedValues.includes(optionValue) && !$(this).is(':selected')) {
            $(this).prop('disabled', true);
          } else {
            $(this).prop('disabled', false);
          }
        });
      });
    }

    $('select[id^="heading_"]').on('change', function() {
      updateDropdownOptions();
    });

    updateDropdownOptions();

    CKEDITOR.replace('editor');

    $('#form-add-setting_dependency').on('submit', function(e) {
      e.preventDefault();
      var isValid = true;

      $('select[id^="heading_"]').each(function() {
        if ($(this).val() === "") {
          isValid = false;
          $(this).addClass('is-invalid');
        } else {
          $(this).removeClass('is-invalid');
        }
      });

      var editorContent = CKEDITOR.instances.editor.getData();
      if (editorContent === '') {
        $("#content-error").text("This field is required.");
        isValid = false;
      } else {
        $("#content-error").text("");
      }

      if (!isValid) {
        return false;
      }

      var formData = new FormData(this);
      formData.append('editor', editorContent);

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response) {
          if (response.status === 200) {
            $('.modal').modal('hide');
            toastr.success(response.message, 'Success');
            $('#setting_dependency-table').DataTable().ajax.reload(null, false);
          } else {
            toastr.error(response.message, 'Error');
          }
        },
        error: function() {
          toastr.error('An error occurred while submitting the form.', 'Error');
        }
      });
    });
  });
</script>