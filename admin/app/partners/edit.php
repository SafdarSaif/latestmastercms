<?php
if (isset($_GET['id'])) {
    require '../../includes/db-config.php';
    $id = intval($_GET['id']);
    $partnerResult = $conn->query("SELECT * FROM partners WHERE ID = $id");
    $partner = $partnerResult->fetch_assoc();
}
?>

<div class="modal-header">
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">Edit Partner</h3>
        <p class="text-muted">Fill in the details to edit the partner's information.</p>
    </div>

    <div class="form-validation">
        <form id="form-edit-partner" action="/admin/app/partners/update" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?= $partner['ID'] ?>">

            <!-- Partner Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold" for="name">Partner Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" class="form-control border-primary shadow-sm" value="<?= $partner['Name'] ?>" placeholder="Enter Partner Name" required />
                <div class="invalid-feedback">Partner name is required.</div>
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label class="form-label fw-semibold" for="photo">Image</label>
                <input type="hidden" name="updated_file" value="<?= $partner['Image'] ?>">
                <input type="file" name="photo" id="photo" class="form-control border-primary shadow-sm" accept="image/png, image/jpg, image/jpeg, image/svg" />
                <?php if (!empty($partner['Image'])) { ?>
                    <img src="/admin<?= $partner['Image'] ?>" height="70" alt="Partner Image" />
                <?php } ?>
                <small class="form-text text-muted">Accepted formats: PNG, JPG, JPEG, SVG</small>
            </div>

            <!-- Submit Buttons -->
            <div class="modal-footer text-end">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">Save</button>
                <button type="reset" class="btn btn-secondary px-4 shadow-sm" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        $('#form-edit-partner').validate({
            rules: {
                name: {
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

        $("#form-edit-partner").on("submit", function(e) {
            e.preventDefault();
            if ($('#form-edit-partner').valid()) {
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
                        if (data.status === 200) {
                            $('.modal').modal('hide');
                            toastr.success(data.message, 'Success');
                            $('#partners-table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(data.message, 'Error');
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred while saving the partner.', 'Error');
                    }
                });
            }
        });
    });
</script>