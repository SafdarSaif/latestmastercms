<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-top.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header-bottom.php');  ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/side-menu.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/menu.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/helperforindex.php'); ?>


<div class="content-wrapper">
    <!-- Quick Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Dynamic Stats from Database -->
        <?php
        $stats = [
            [
                'title' => 'Active Users',
                'value' => getTotalActiveUsers($conn),
                'icon' => 'ti-users',
                'color' => 'primary',
                'trend' => 12
            ],
            [
                'title' => 'Total Pages',
                'value' => getTotalPages($conn),
                'icon' => 'ti-file',
                'color' => 'info',
                'trend' => -3
            ],
            [
                'title' => 'Storage Used',
                'value' => getStorageUsed($conn),
                'icon' => 'ti-database',
                'color' => 'warning',
                'progress' => 82
            ],
            [
                'title' => 'Recent Leads',
                'value' => getRecentLeads($conn),
                'icon' => 'ti-brand-leetcode',
                'color' => 'success',
                'trend' => 24
            ]
        ];

        foreach ($stats as $stat): ?>
        <div class="col-6 col-lg-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar bg-<?= $stat['color'] ?> me-3">
                            <span class="ti <?= $stat['icon'] ?> ti-md"></span>
                        </div>
                        <div>
                            <h5 class="mb-0" data-target="<?= $stat['value'] ?>">0</h5>
                            <small class="text-muted"><?= $stat['title'] ?></small>
                        </div>
                    </div>
                    <?php if(isset($stat['trend'])): ?>
                    <div class="stat-trend text-<?= $stat['trend'] > 0 ? 'success' : 'danger' ?>">
                        <?= abs($stat['trend']) ?>% <i class="ti ti-arrow-<?= $stat['trend'] > 0 ? 'up' : 'down' ?>"></i>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($stat['progress'])): ?>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-<?= $stat['color'] ?>" style="width: <?= $stat['progress'] ?>%"></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Website Traffic Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Website Traffic</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                id="trafficFilter" data-bs-toggle="dropdown">
                            Last 7 Days
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-range="7">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="#" data-range="30">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#" data-range="365">Last Year</a></li>
                        </ul>
                    </div>
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
                    <h5 class="card-title mb-0">Content Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="contentChart" style="min-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="row g-4 mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                    <a href="/admin/activity-logs" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <?php foreach(getRecentActivities($conn) as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-badge bg-<?= $activity['type'] ?>"></div>
                            <div class="activity-content">
                                <small class="text-muted"><?= time_ago($activity['created_at']) ?></small>
                                <p><?= $activity['description'] ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
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
                            <a href="/admin/pages/create" class="action-card bg-primary">
                                <i class="ti ti-file-plus"></i>
                                <span>New Page</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/users/create" class="action-card bg-success">
                                <i class="ti ti-user-plus"></i>
                                <span>Add User</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/media" class="action-card bg-info">
                                <i class="ti ti-photo-up"></i>
                                <span>Upload Media</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/settings" class="action-card bg-warning">
                                <i class="ti ti-settings"></i>
                                <span>System Settings</span>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Animate stats counters
        const counters = document.querySelectorAll('.stat-card h5[data-target]');
        counters.forEach(counter => {
            const target = +counter.dataset.target;
            const duration = 2000;
            const step = target / (duration / 10);
            let current = 0;

            const updateCounter = () => {
                current += step;
                if (current < target) {
                    counter.textContent = Math.ceil(current);
                    setTimeout(updateCounter, 10);
                } else {
                    counter.textContent = target;
                }
            };
            updateCounter();
        });

        // Initialize charts
        const trafficChart = new ApexCharts(document.querySelector("#trafficChart"), {
            chart: {
                type: 'area',
                height: '350'
            },
            series: [{
                name: 'Visitors',
                data: <?= json_encode(getTrafficData($conn)) ?>
            }],
            xaxis: {
                type: 'datetime',
                categories: <?= json_encode(getTrafficDates($conn)) ?>
            }
        });
        trafficChart.render();

        const contentChart = new ApexCharts(document.querySelector("#contentChart"), {
            chart: {
                type: 'donut',
                height: '350'
            },
            series: <?= json_encode(getContentDistribution($conn)) ?>,
            labels: ['Pages', 'Blog Posts', 'Media Files', 'Users']
        });
        contentChart.render();
    });
</script>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer-bottom.php');

?>