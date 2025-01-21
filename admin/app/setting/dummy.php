<?php
require '../../includes/db-config.php';
require '../../includes/helper.php';

$modalID = intval($_GET['id']);

echo "<pre>";
echo "The ID is: " . $modalID;
echo "</pre>";



// Fetch the setting heading name for the given modal ID
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

$modalTitle = getSettingHeadingName($conn, $modalID);


function getActiveSettingHeadings($conn)
{
    $query = "SELECT ID, Name FROM setting_headings WHERE Status = 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return [];
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

$headings = getActiveSettingHeadings($conn);
$mapping = getParentChildMapping($conn);

// Check if the modalID has any parent-child relationship
$hasParent = false;
foreach ($mapping as $parentID => $children) {
    if (in_array($modalID, $children)) {
        $hasParent = true;
        break;
    }
}
?>

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

    /* Hide all dropdowns initially */
    .parent-child-dropdown {
        display: none;
    }
</style>

<div class="modal-header">
<h3 class="modal-title">Add <?= $modalTitle ?> Data</h3>

    <!-- <h3 class="modal-title">Add Setting Data</h3> -->
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="card-body">
    <div class="form-validation">
        <form class="needs-validation" role="form" id="form-add-setting" action="/admin/app/setting/store" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="Enter a <?= $modalTitle ?> Name.." required>
                </div>

                <?php
                $counter = 1;

                // Loop through the parent-child mapping and create the dropdowns
                foreach ($mapping as $parentID => $children):
                    foreach ($children as $childID):
                        $parentName = '';
                        $childName = '';
                        // Find the names of the parent and child from the $headings array
                        foreach ($headings as $heading) {
                            if ($heading['ID'] == $parentID) {
                                $parentName = $heading['Name'];
                            }
                            if ($heading['ID'] == $childID) {
                                $childName = $heading['Name'];
                            }
                        }

                        // Determine visibility based on modalID
                        $isModalSelected = 'none';  
                        if ($modalID == 2 && $counter == 1) {
                            $isModalSelected = 'block';  
                        } elseif ($modalID == 3 && $counter <= 2) {
                            $isModalSelected = 'block';  
                        } elseif ($modalID == 4 && $counter <= 3) {
                            $isModalSelected = 'block';  
                        }
                ?>
                        <!-- Parent Dropdown -->
                        <div class="mb-3 col-md-6 parent-child-dropdown" id="dropdown-container-<?= $counter ?>" style="display: <?= $isModalSelected ?>;">
                            <label class="form-label"><?= $parentName ?> -> <?= $childName ?></label>
                            <select class="form-control" name="dropdown_<?= $counter ?>" id="dropdown-<?= $counter ?>">
                                <option value="">Select <?= $childName ?></option>
                                <option value="<?= $parentID ?>"><?= $parentName ?></option>
                                <option value="<?= $childID ?>"><?= $childName ?></option>
                            </select>
                        </div>
                <?php
                        $counter++;
                    endforeach;
                endforeach;
                ?>

                <!-- Content -->
                <div class="mb-3 col-md-12">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea class="ckeditor" cols="80" id="editor" name="editor" rows="10" required></textarea>
                    <span id="content-error" style="color:#b91e1e;font-weight: 500;font-size: 12px;"></span>
                </div>

                <!-- Position -->
                <div class="col-md-12">
                    <label class="form-label">Order By <span class="text-danger">*</span></label>
                    <input type="number" min="0" class="form-control" name="position" placeholder="Enter a Position..." required>
                </div>
            </div>

            <div class="modal-footer clearfix text-end">
                <div class="col-md-4 m-t-10 sm-m-t-10">
                    <button type="submit" class="btn btn-primary btn-cons btn-animated from-left"><span>Save</span></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        // Validate form
        $('#form-add-setting').validate({
            errorPlacement: function(error, element) {
                if (element.is("select")) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Handle dynamic dropdown visibility based on modalID
        $(".parent-child-dropdown").each(function(index) {
            var containerID = $(this).attr('id');
            if (($modalID == 2 && index == 0) ||
                ($modalID == 3 && index < 2) ||
                ($modalID == 4 && index < 3)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // Handle form submission
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

    CKEDITOR.replace('editor');
</script>


<!-- query for count the parent 
WITH RECURSIVE ParentHierarchy AS (
    -- Anchor query: Start with the given Child_ID
    SELECT 
        Parent_ID, 
        Child_ID
    FROM 
        setting_dependency
    WHERE 
        Child_ID = 4 -- Replace 4 with your desired Child_ID

    UNION ALL

    -- Recursive query: Find the parent of the current Parent_ID
    SELECT 
        sd.Parent_ID, 
        ph.Parent_ID AS Child_ID
    FROM 
        setting_dependency sd
    INNER JOIN 
        ParentHierarchy ph 
    ON 
        sd.Child_ID = ph.Parent_ID
)
SELECT 
    ph.Parent_ID, 
    sph.Name AS Parent_Name,
    ph.Child_ID,
    sch.Name AS Child_Name,
    COUNT(ph.Child_ID) OVER (PARTITION BY ph.Parent_ID) AS Total_Parents
FROM 
    ParentHierarchy ph
LEFT JOIN 
    setting_headings sph ON ph.Parent_ID = sph.ID
LEFT JOIN 
    setting_headings sch ON ph.Child_ID = sch.ID; -->