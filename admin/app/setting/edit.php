<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

$dropdownDetails = [
    'parentName' => 'Parent Setting',
    'childName' => 'Child Setting'
];

$modalID = intval($_GET['second_id']);
$editID = intval($_GET['id']);

echo "<pre>";
echo "The ID is: " . $modalID;
echo "</pre>";

function getSettingHeadingName($conn, $id)
{
    $query = "SELECT Name FROM setting_headings WHERE ID = $id AND Status = 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Name'];
    }
    return "Edit Setting Data";
}

function getActiveSettingHeadings($conn)
{
    $query = "SELECT ID, Name FROM setting_headings WHERE Status = 1";
    $result = mysqli_query($conn, $query);

    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}

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

// function getDependencySettingID($conn, $modalID)
// {
//     $query = "SELECT ID, Parent_ID FROM setting_dependency WHERE Child_ID = $modalID AND Status = 1 LIMIT 1";
//     $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

//     if ($result && mysqli_num_rows($result) > 0) {
//         $row = mysqli_fetch_assoc($result);
//         return ['ID' => $row['ID'], 'Parent_ID' => $row['Parent_ID']];
//     }
//     return null;
// }

// // Fetch required data
// $dependencyData = getDependencySettingID($conn, $modalID);
// $dependencySettingID = $dependencyData['ID'] ?? null;
// $parentID = $dependencyData['Parent_ID'] ?? 0;

function getDependencySettingID($conn, $modalID)
{
    $query = "SELECT ID, Parent_ID FROM setting_dependency WHERE Child_ID = $modalID AND Status = 1 LIMIT 1";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return ['ID' => $row['ID'], 'Parent_ID' => $row['Parent_ID']];
    }
    // return null;
    return ['ID' => null, 'Parent_ID' => 0];
}
$dependencyData = getDependencySettingID($conn, $modalID);
$dependencySettingID = $dependencyData['ID'] ?? null;
$parentID = $dependencyData['Parent_ID'] ?? 0;

$modalTitle = getSettingHeadingName($conn, $modalID);
$headings = getActiveSettingHeadings($conn);
$mapping = getParentChildMapping($conn);
$childDropdownData = getChildDropdownData($conn, $modalID);

$settingDataQuery = "SELECT * FROM setting_data WHERE ID = $editID";
$settingDataResult = mysqli_query($conn, $settingDataQuery);
$settingData = mysqli_fetch_assoc($settingDataResult);


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
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary"><?= $modalTitle ?></h3>
        <p class="text-muted">Fill in the details to update a new <?= $modalTitle ?> with ease.</p>
    </div>
    <form id="form-edit-setting" action="/admin/app/setting/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $settingData['ID'] ?>">
        <input type="hidden" name="heading_setting_id" value="<?= ($modalID) ?>">
        <!-- <input type="hidden" name="dependency_parent_id" value="<?= ($parentID) ?>"> -->
        <input type="hidden" name="dependency_parent_id" value="<?= isset($dependencyData['Parent_ID']) ? $dependencyData['Parent_ID'] : '' ?>">
        <?php


        // echo "<pre>";
        // echo "The ParentID is: " . $dependencyData['Parent_ID'];

        // echo "</pre>";
        ?>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="<?= ($settingData['Name']) ?>" placeholder="Enter <?= ($modalTitle) ?> Name.." required>
            </div>

            <?php if (!empty($childDropdownData)): ?>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Select <?= ($dropdownDetails['parentName']) ?> -> <?= ($dropdownDetails['childName']) ?></label>

                    <select class="form-control" name="dependency_setting_id" required>
                        <option value="">Select <?= ($dropdownDetails['parentName']) ?></option>
                        <?php foreach ($childDropdownData as $child): ?>
                            <option value="<?= ($child['ID']) ?>" <?= $child['ID'] == $settingData['Dependency_Setting_ID'] ? 'selected' : '' ?>><?= ($child['Name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="mb-3 col-md-12 syllabus_file">

                <label class="form-label">Photo <span class="text-danger">*</span></label>
                <small class="text-muted">
                    Please upload a valid image file (PNG, JPG, JPEG, SVG, or AVIF) with a size less than or equal to 200KB.
                </small>
                <input type="hidden" name="updated_file" value="<?= $settingData['Photo'] ?>">
                <input type="file" name="photo" id="photo" class="form-control" onchange="fileValidation('photo')" accept="image/png, image/jpg, image/jpeg, image/svg,image/avif">

                <?php if (!empty($editID) && !empty($settingData['Photo'])) { ?>
                    <img src="/admin<?php echo !empty($editID) ? $settingData['Photo'] : ''; ?>" height="50" />
                <?php } ?>
            </div>

            <div class="mb-3 col-md-12">
                <label class="form-label">Content <span class="text-danger">*</span></label>
                <textarea class="ckeditor" id="editor" name="editor" rows="10" required><?= ($settingData['Content']) ?></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label">Order By <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="position" value="<?= ($settingData['Position']) ?>" placeholder="Enter a Position..." required>
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

        $('#form-edit-setting').validate({
            errorPlacement: function(error, element) {
                if (element.is("select")) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $("#form-edit-setting").on("submit", function(e) {
            if ($('#form-edit-setting').valid()) {
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