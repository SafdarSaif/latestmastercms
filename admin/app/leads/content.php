<?php require '../../includes/db-config.php'; ?>
<?php require '../../includes/helper.php'; ?>
<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $leadsArr = $conn->query("SELECT Content FROM leads WHERE ID = $id");
    $leadsArr = $leadsArr->fetch_assoc();
}
?>

<div class="modal-header">
    <h5 class="modal-title" id="viewContentLabel">Lead Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div id="modalContent">
        <?php if (!empty($leadsArr) && isset($leadsArr['Content'])): ?>
            <?php
            $contentData = json_decode($leadsArr['Content'], true);
            ?>
            <?php if (is_array($contentData)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Field</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contentData as $key => $value): ?>
                            <tr>
                                <td><?= ucwords(str_replace('_', ' ', $key)); ?></td>
                                <!-- <td><?= $value; ?></td> -->
                                 <td>
                                <?php
                                if ($key == 'Check-in Date' || $key == 'Check-out Date') {
                                    $formattedDate = date('d-M-Y', strtotime($value));
                                    echo $formattedDate;
                                } else {
                                    echo $value;
                                }
                                ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Invalid content format.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>No content found.</p>
        <?php endif; ?>
    </div>
</div>