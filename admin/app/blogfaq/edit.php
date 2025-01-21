<?php
if (isset($_GET['id'])) {
  require '../../includes/db-config.php';
  require '../../includes/helper.php';
  $id = intval($_GET['id']);
  $getdataQuery = $conn->query("SELECT * FROM blogsfaq WHERE ID = $id");
  $getdata = $getdataQuery->fetch_assoc();
}
?>

<div class="modal-body p-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold text-primary">Edit Blog FAQ</h3>
    <p class="text-muted">Update the details for the selected FAQ.</p>
  </div>
  <form id="form-add-faq" action="/admin/app/blogfaq/update" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="id" value="<?= $getdata['id'] ?>">

    <!-- Blog Selection -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="blog_id">Blogs <span class="text-danger">*</span></label>
      <?php $blogArr = getblogFunc($conn); ?>
      <select id="blog_id" name="blog_id" class="form-control border-primary shadow-sm sumoselect" required>
        <option value="">Select blog</option>
        <?php foreach ($blogArr as $blog) { ?>
          <option value="<?= $blog['ID'] ?>" <?= $getdata['blog_id'] == $blog['ID'] ? 'selected' : '' ?>>
            <?= $blog['Name'] ?>
          </option>
        <?php } ?>
      </select>
      <div class="invalid-feedback">Please select a blog.</div>
    </div>

    <!-- Question -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="question">Question <span class="text-danger">*</span></label>
      <input type="text" id="question" name="question" class="form-control border-primary shadow-sm" value="<?= $getdata['questions'] ?>" placeholder="Enter a question" required>
      <div class="invalid-feedback">Question is required.</div>
    </div>

    <!-- Answer -->
    <div class="col-12">
      <label class="form-label fw-semibold" for="answer">Answer <span class="text-danger">*</span></label>
      <textarea id="editor" name="answer" class="ckeditor border-primary" rows="5" required><?= $getdata['answers'] ?></textarea>
      <span id="content-error" class="text-danger d-block mt-1" style="font-size: 12px;"></span>
    </div>

    <!-- Submit Buttons -->
    <div class="col-12 text-center mt-3">
      <button type="submit" class="btn btn-primary px-4 shadow-sm">Update</button>
      <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
    </div>
  </form>
</div>

<script>
  $(document).ready(function () {
    // Initialize SumoSelect
    $('.sumoselect').SumoSelect({
      search: true,
      searchText: 'Enter here.'
    });

    // Initialize CKEditor
    CKEDITOR.replace('editor');

    // Form validation
    $('#form-add-faq').validate({
      errorPlacement: function (error, element) {
        if (element.is("select")) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      }
    });

    // Form submission with CKEditor validation
    $("#form-add-faq").on("submit", function (e) {
      if ($('#form-add-faq').valid()) {
        // Ensure CKEditor content validation
        var editorInstance = CKEDITOR.instances['editor'];
        var editorContent = editorInstance.getData();

        if ($.trim(editorContent) === '') {
          $("#content-error").text("Answer is required.");
          e.preventDefault();
          return false;
        } else {
          $("#content-error").text(""); // Clear error if content is valid
        }

        var formData = new FormData(this);
        formData.append('answer', editorContent);

        $.ajax({
          url: this.action,
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (data) {
            if (data.status === 200) {
              $('.modal').modal('hide');
              toastr.success(data.message, 'Success');
              $('#blogsfaq-table').DataTable().ajax.reload(null, false);
            } else {
              toastr.error(data.message, 'Error');
            }
          },
          error: function () {
            toastr.error('An unexpected error occurred.', 'Error');
          }
        });

        e.preventDefault();
      }
    });
  });
</script>
