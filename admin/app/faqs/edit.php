<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    $id = intval($_GET['id']);
    $faqResult = $conn->query("SELECT * FROM faqs WHERE id = $id");
    $faq = $faqResult->fetch_assoc();
}
?>

<div class="modal-header">
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">Edit Website FAQ</h3>
        <p class="text-muted">Fill in the details to add a Update faq easily.</p>
    </div>
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-edit-faq" action="/admin/app/faqs/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $faq['ID'] ?>">

            <div class="mb-3 col-md-12">
                <label class="form-label">Question <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="<?= $faq['Question'] ?>" name="question" placeholder="Enter a Question.." required>
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Answer <span class="text-danger">*</span></label>
                <textarea class="ckeditor" id="editor" name="answer" rows="10" required><?= $faq['Answer'] ?></textarea>
                <span id="content-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="modal-footer clearfix text-end">
                <button type="submit" class="btn btn-primary btn-cons btn-animated from-left">
                    <span>Save</span>
                </button>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        $('#form-edit-faq').validate({
            rules: {
                question: {
                    required: true
                },
                answer: {
                    required: true
                }
            },
            highlight: function(element) {
                $(element).addClass('error');
                $(element).closest('.form-control').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).removeClass('error');
                $(element).closest('.form-control').removeClass('has-error');
            }
        });

        $("#form-edit-faq").on("submit", function(e) {
            if ($('#form-edit-faq').valid()) {
                var editorContent = CKEDITOR.instances.editor.getData();
                if (editorContent == '') {
                    $("#content-error").text("This field is required.");
                    return false;
                }
                var formData = new FormData(this);
                formData.append('answer', editorContent);
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
                            $('#faqs-table').DataTable().ajax.reload(null, false);
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