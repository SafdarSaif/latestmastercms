<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/side-menu.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php'); ?>


<div class="content-wrapper">
    <!-- Quick Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-primary me-3">
                            <span class="ti ti-users ti-md"></span>
                        </div>
                        <div>
                            <h5 class="mb-0">1,234</h5>
                            <small class="text-muted">Active Users</small>
                        </div>
                    </div>
                    <div class="stat-trend text-success">
                        +12% <i class="ti ti-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-info me-3">
                            <span class="ti ti-file ti-md"></span>
                        </div>
                        <div>
                            <h5 class="mb-0">568</h5>
                            <small class="text-muted">Total Pages</small>
                        </div>
                    </div>
                    <div class="stat-trend text-danger">
                        -3% <i class="ti ti-arrow-down"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-warning me-3">
                            <span class="ti ti-database ti-md"></span>
                        </div>
                        <div>
                            <h5 class="mb-0">82%</h5>
                            <small class="text-muted">Storage Used</small>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-warning" style="width: 82%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-success me-3">
                            <span class="ti ti-brand-leetcode ti-md"></span>
                        </div>
                        <div>
                            <h5 class="mb-0">45</h5>
                            <small class="text-muted">Recent Leads</small>
                        </div>
                    </div>
                    <div class="stat-trend text-success">
                        +24% <i class="ti ti-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Website Traffic Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Website Traffic</h5>
                </div>
                <div class="card-body">
                    <div id="trafficChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Content Statistics -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Content Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="content-stats">
                        <div class="stat-item">
                            <div class="d-flex justify-content-between">
                                <span><i class="ti ti-file-text me-2"></i> Pages</span>
                                <span>256</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar" style="width: 65%"></div>
                            </div>
                        </div>

                        <div class="stat-item mt-4">
                            <div class="d-flex justify-content-between">
                                <span><i class="ti ti-news me-2"></i> Blog Posts</span>
                                <span>128</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: 45%"></div>
                            </div>
                        </div>

                        <div class="stat-item mt-4">
                            <div class="d-flex justify-content-between">
                                <span><i class="ti ti-photo me-2"></i> Media Files</span>
                                <span>1,024</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="row g-4 mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-badge success"></div>
                            <div class="activity-content">
                                <small class="text-muted">10 min ago</small>
                                <p>New page "About Us" created</p>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-badge primary"></div>
                            <div class="activity-content">
                                <small class="text-muted">45 min ago</small>
                                <p>User "John Doe" updated profile</p>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-badge warning"></div>
                            <div class="activity-content">
                                <small class="text-muted">2 hours ago</small>
                                <p>5 new media files uploaded</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 quick-actions">
                        <div class="col-6">
                            <a href="#" class="action-card bg-primary">
                                <i class="ti ti-file-plus"></i>
                                <span>New Page</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="#" class="action-card bg-success">
                                <i class="ti ti-user-plus"></i>
                                <span>Add User</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="#" class="action-card bg-info">
                                <i class="ti ti-photo-up"></i>
                                <span>Upload Media</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="#" class="action-card bg-warning">
                                <i class="ti ti-settings"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-top.php');
?>


<style>
    .stat-card {
        transition: all 0.3s ease-in-out;
        border: none;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }

    .avatar {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: white;
        font-size: 1.4rem;
    }

    .stat-trend {
        font-size: 1rem;
        font-weight: bold;
    }

    .quick-actions .action-card {
        display: block;
        text-align: center;
        padding: 1.5rem;
        border-radius: 12px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
        font-weight: bold;
    }

    .quick-actions .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }

    .quick-actions .action-card i {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }
</style>


<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-bottom.php');

?>