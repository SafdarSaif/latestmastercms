<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

$modalID = intval($_GET['id']);

// Function to fetch setting heading name
function getSettingHeadingName($conn, $id)
{
    $query = "SELECT Name FROM setting_headings WHERE ID = $id AND Status = 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Name'];
    }
    return "Add Setting Data";
}

// Function to fetch active headings
function getActiveSettingHeadings($conn)
{
    $query = "SELECT ID, Name FROM setting_headings WHERE Status = 1";
    $result = mysqli_query($conn, $query);

    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

// Function to fetch parent-child mapping
function getParentChildMapping($conn)
{
    $query = "SELECT Parent_ID, Child_ID FROM setting_dependency WHERE Status = 1";
    $result = mysqli_query($conn, $query);

    $mapping = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $mapping[$row['Parent_ID']][] = $row['Child_ID'];
        }
    }
    return $mapping;
}

// Function to fetch child dropdown data based on modalID
function getChildDropdownData($conn, $modalID)
{
    $query = "
    SELECT setting_data.ID, setting_data.Name
    FROM setting_data 
    LEFT JOIN setting_dependency 
    ON setting_dependency.Parent_ID = setting_data.Heading_Setting_ID
    WHERE setting_dependency.Child_ID = $modalID 
    AND setting_dependency.Status = 1 
    AND setting_data.Status = 1
    ";
    $result = mysqli_query($conn, $query);

    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

// Function to fetch dependency setting ID
function getDependencySettingID($conn, $modalID)
{
    $query = "SELECT ID, Parent_ID FROM setting_dependency WHERE Child_ID = $modalID AND Status = 1 LIMIT 1";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return ['ID' => $row['ID'], 'Parent_ID' => $row['Parent_ID']];
    }
    return null;
}

$dependencyData = getDependencySettingID($conn, $modalID);
$dependencySettingID = $dependencyData['ID'] ?? null;
$parentID = $dependencyData['Parent_ID'] ?? null;

$modalTitle = getSettingHeadingName($conn, $modalID);
$headings = getActiveSettingHeadings($conn);
$mapping = getParentChildMapping($conn);
$childDropdownData = getChildDropdownData($conn, $modalID);

// Determine the dropdown to display
$dropdownDetails = null;
foreach ($mapping as $parentID => $children) {
    if (in_array($modalID, $children)) {
        foreach ($headings as $heading) {
            if ($heading['ID'] == $parentID) {
                $parentName = $heading['Name'];
            }
            if ($heading['ID'] == $modalID) {
                $childName = $heading['Name'];
            }
        }
        $dropdownDetails = ['parentName' => $parentName, 'childName' => $childName];
        break;
    }
}
?>

<div class="modal-header">
    <h3 class="modal-title">Add <?= $modalTitle ?> Data</h3>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
    <form id="form-add-setting" action="/admin/app/setting/store" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="heading_setting_id" value="<?= isset($modalID) ? $modalID : '' ?>">
        <input type="hidden" name="dependency_parent_id" value="<?= isset($parentID) ? $parentID : '' ?>">

        <div class="row">
            <!-- Name Field -->
            <div class="mb-3 col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Enter <?= $modalTitle ?> Name.." required>
            </div>

            <!-- Dropdown -->
            <?php if (!empty($childDropdownData)): ?>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Select <?= $dropdownDetails['parentName'] ?> -> <?= $dropdownDetails['childName'] ?></label>
                    <select class="form-control" name="dependency_setting_id" required>
                        <option value="">Select <?= $dropdownDetails['parentName'] ?></option>
                        <?php foreach ($childDropdownData as $child): ?>
                            <option value="<?= $child['ID'] ?>"><?= ($child['Name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php elseif ($dropdownDetails): ?>
                <div class="mb-3 col-md-6">
                    <label class="form-label"><?= $dropdownDetails['parentName'] ?> -> <?= $dropdownDetails['childName'] ?></label>
                    <select class="form-control" name="dropdown">
                        <option value="">Select <?= $dropdownDetails['parentName'] ?></option>
                        <option value="<?= $modalID ?>"><?= $dropdownDetails['parentName'] ?></option>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Photo Field -->
            <div class="mb-3 col-md-12 syllabus_file">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif">
                <small class="text-muted">
                    Note: Please upload a valid image file (PNG, JPG, JPEG, SVG, or AVIF) with a size less than or equal to 200KB.
                </small>
            </div>

            <!-- Content Field -->
            <div class="mb-3 col-md-12">
                <label class="form-label">Content <span class="text-danger">*</span></label>
                <textarea class="ckeditor" id="editor" name="editor" rows="10" required></textarea>
            </div>

            <!-- Position Field -->
            <div class="col-md-12">
                <label class="form-label">Order By <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="position" placeholder="Enter a Position..." required>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
    $(function() {
        CKEDITOR.replace('editor');

        // Form validation
        $('#form-add-setting').validate({
            errorPlacement: function(error, element) {
                if (element.is("select")) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $("#form-add-setting").on("submit", function(e) {
            if ($('#form-add-setting').valid()) {
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
                            $('#setting-table').DataTable().ajax.reload(null, false);
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
