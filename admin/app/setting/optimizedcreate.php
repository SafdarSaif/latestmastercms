<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

$modalID = intval($_GET['id']);

// Combined function to fetch setting details, active headings, mapping, and dropdown data
function getSettingDetails($conn, $modalID)
{
    // Get setting heading name
    $headingQuery = "SELECT Name FROM setting_headings WHERE ID = $modalID AND Status = 1";
    $headingResult = mysqli_query($conn, $headingQuery);
    $modalTitle = mysqli_num_rows($headingResult) > 0 ? mysqli_fetch_assoc($headingResult)['Name'] : 'Add Setting Data';

    // Get active headings
    $headingsQuery = "SELECT ID, Name FROM setting_headings WHERE Status = 1";
    $headingsResult = mysqli_query($conn, $headingsQuery);
    $headings = $headingsResult ? mysqli_fetch_all($headingsResult, MYSQLI_ASSOC) : [];

    // Get parent-child mapping
    $mappingQuery = "SELECT Parent_ID, Child_ID FROM setting_dependency WHERE Status = 1";
    $mappingResult = mysqli_query($conn, $mappingQuery);
    $mapping = [];
    if ($mappingResult) {
        while ($row = mysqli_fetch_assoc($mappingResult)) {
            $mapping[$row['Parent_ID']][] = $row['Child_ID'];
        }
    }

    // Get child dropdown data
    $childDropdownQuery = "
        SELECT setting_data.ID, setting_data.Name
        FROM setting_data 
        LEFT JOIN setting_dependency 
        ON setting_dependency.Parent_ID = setting_data.Heading_Setting_ID
        WHERE setting_dependency.Child_ID = $modalID 
        AND setting_dependency.Status = 1 
        AND setting_data.Status = 1
    ";
    $childDropdownResult = mysqli_query($conn, $childDropdownQuery);
    $childDropdownData = $childDropdownResult ? mysqli_fetch_all($childDropdownResult, MYSQLI_ASSOC) : [];

    // Get dependency setting ID
    $dependencyQuery = "SELECT ID, Parent_ID FROM setting_dependency WHERE Child_ID = $modalID AND Status = 1 LIMIT 1";
    $dependencyResult = mysqli_query($conn, $dependencyQuery);
    $dependencyData = mysqli_num_rows($dependencyResult) > 0 ? mysqli_fetch_assoc($dependencyResult) : null;
    
    return compact('modalTitle', 'headings', 'mapping', 'childDropdownData', 'dependencyData');
}

$settingDetails = getSettingDetails($conn, $modalID);
$modalTitle = $settingDetails['modalTitle'];
$headings = $settingDetails['headings'];
$mapping = $settingDetails['mapping'];
$childDropdownData = $settingDetails['childDropdownData'];
$dependencyData = $settingDetails['dependencyData'];

$dependencySettingID = $dependencyData['ID'] ?? null;
$parentID = $dependencyData['Parent_ID'] ?? null;

// Determine the dropdown details
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
        <input type="hidden" name="heading_setting_id" value="<?= $modalID ?? '' ?>">
        <input type="hidden" name="dependency_parent_id" value="<?= $parentID ?? '' ?>">

        <div class="row">
            <!-- Name Field -->
            <div class="mb-3 col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Enter <?= $modalTitle ?> Name.." required>
            </div>

            <!-- Dropdown -->
            <?php if ($childDropdownData): ?>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Select <?= $dropdownDetails['parentName'] ?> -> <?= $dropdownDetails['childName'] ?></label>
                    <select class="form-control" name="dependency_setting_id" required>
                        <option value="">Select <?= $dropdownDetails['parentName'] ?></option>
                        <?php foreach ($childDropdownData as $child): ?>
                            <option value="<?= $child['ID'] ?>"><?= $child['Name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="mb-3 col-md-12">
                <label class="form-label">Content <span class="text-danger">*</span></label>
                <textarea class="ckeditor" id="editor" name="editor" rows="10" required></textarea>
            </div>

            <!-- Position -->
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
                error.insertAfter(element.is("select") ? element.parent() : element);
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
                            toastr.error(data.message, 'Error');
                        }
                    }
                });
                e.preventDefault();
            }
        });
    });
</script>
