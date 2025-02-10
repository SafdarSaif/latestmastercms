<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/side-menu.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php'); ?>

<div class="content-wrapper">
    <!-- Enhanced Quick Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-gradient-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-white me-3">
                            <span class="ti ti-users ti-md text-primary"></span>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">1,234</h5>
                            <small class="text-white-80">Active Users</small>
                        </div>
                    </div>
                    <div class="stat-trend text-white">
                        +12% <i class="ti ti-arrow-up"></i>
                    </div> 
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-gradient-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-white me-3">
                            <span class="ti ti-file ti-md text-info"></span>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">568</h5>
                            <small class="text-white-80">Total Pages</small>
                        </div>
                    </div>
                    <div class="stat-trend text-white">
                        +8% <i class="ti ti-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-gradient-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-white me-3">
                            <span class="ti ti-database ti-md text-warning"></span>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">82%</h5>
                            <small class="text-white-80">Storage Used</small>
                        </div>
                    </div>
                    <div class="progress mt-2 bg-white-20" style="height: 4px;">
                        <div class="progress-bar bg-white" style="width: 82%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card bg-gradient-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-white me-3">
                            <span class="ti ti-brand-leetcode ti-md text-success"></span>
                        </div>
                        <div>
                            <h5 class="mb-0 text-white">45</h5>
                            <small class="text-white-80">Recent Leads</small>
                        </div>
                    </div>
                    <div class="stat-trend text-white">
                        +24% <i class="ti ti-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Enhanced Traffic Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Website Analytics</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Last 7 Days
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Last 24 Hours</a></li>
                            <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="advancedTrafficChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- System Health Overview -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">System Health</h5>
                </div>
                <div class="card-body">
                    <div class="system-health">
                        <div class="health-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Server Uptime</span>
                                <span class="text-success">99.9%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: 99.9%"></div>
                            </div>
                        </div>

                        <div class="health-item mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>CPU Usage</span>
                                <span class="text-warning">65%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-warning" style="width: 65%"></div>
                            </div>
                        </div>

                        <div class="health-item mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Memory Usage</span>
                                <span class="text-danger">85%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-danger" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Sections -->
    <div class="row g-4 mt-4">
        <!-- Latest Leads Table -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Leads</h5>
                    <a href="/admin/leads" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td><span class="badge bg-success">New</span></td>
                                    <td>2 min ago</td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                    <td>15 min ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Overview -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Content Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="contentPieChart" style="min-height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Recent Activity -->
    <div class="row g-4 mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Activity Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-badge success"></div>
                            <div class="activity-content">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">10 min ago</small>
                                    <span class="badge bg-success">Page</span>
                                </div>
                                <p class="mb-0">"About Us" page created by <strong>John Doe</strong></p>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-badge primary"></div>
                            <div class="activity-content">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">45 min ago</small>
                                    <span class="badge bg-primary">User</span>
                                </div>
                                <p class="mb-0">User profile updated by <strong>Jane Smith</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 quick-actions">
                        <div class="col-6">
                            <a href="#" class="action-card bg-primary hover-elevate">
                                <i class="ti ti-file-plus"></i>
                                <span>New Page</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="#" class="action-card bg-success hover-elevate">
                                <i class="ti ti-user-plus"></i>
                                <span>Add User</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="#" class="action-card bg-info hover-elevate">
                                <i class="ti ti-photo-up"></i>
                                <span>Upload Media</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="#" class="action-card bg-warning hover-elevate">
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

<style>
    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }

    .stat-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    .hover-elevate {
        transition: transform 0.3s ease;
    }

    .hover-elevate:hover {
        transform: translateY(-3px);
    }

    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }

    .activity-item {
        position: relative;
        padding: 15px 0;
        border-left: 2px solid #eee;
        padding-left: 25px;
        margin-left: -25px;
    }

    .activity-badge {
        position: absolute;
        left: -10px;
        top: 20px;
        width: 20px;
        height: 20px;
        border: 3px solid #fff;
        border-radius: 50%;
    }

    .text-white-80 {
        color: rgba(255,255,255,0.8);
    }

    .table-hover tbody tr {
        transition: background-color 0.2s ease;
    }



    /* Quick Actions css */
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const trafficChart = new ApexCharts(document.querySelector("#advancedTrafficChart"), {
            chart: { type: 'area', height: 350 },
            series: [{
                name: 'Visitors',
                data: [30, 40, 35, 50, 49, 60, 70]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul']
            }
        });
        trafficChart.render();

        // Pie Chart
        const pieChart = new ApexCharts(document.querySelector("#contentPieChart"), {
            chart: { type: 'pie', height: 350 },
            series: [44, 55, 13, 33],
            labels: ['Pages', 'Blog Posts', 'Media', 'Users']
        });
        pieChart.render();
    });
</script>





<?php

include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-top.php');
?>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-bottom.php');

?>