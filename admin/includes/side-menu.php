<?php
?>

<?php require 'includes/db-config.php'; ?>


<?php $breadcrumbs = array_filter(explode("/", $_SERVER['REQUEST_URI'])); ?>



<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">

        <img src="<?= $logo_url; ?>" alt="Logo" class="app-brand-logo" style="max-height: 50px;">


        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti ti-menu-2 d-none d-xl-block align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
        </a>

    </div>

    <div class="menu-inner-shadow"></div>


    <?php if ($subdomain === "oldtheme") : ?>
        <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item active open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Dashboards">Dashboards</div>
                    <div class="badge bg-danger rounded-pill ms-auto">1</div>
                </a>
                <ul class="menu-sub">

                    <li class="menu-item active">
                        <a href="./indexnew" class="menu-link">
                            <div data-i18n="Analytics">Analytics</div>
                        </a>
                    </li>

                </ul>
            </li>



            <li class="menu-item">
                <a onclick="add('app/themesetting/create&edit', 'modal-lg')" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Setting Heading">Theme Setting</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="/admin/setting_heading" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="Setting Heading">Setting Heading</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="/admin/setting_dependency" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-menu"></i>
                    <div data-i18n="Setting Dependency">Setting Dependency</div>
                </a>
            </li>

            <!-- Website Flow Section -->
            <?php
            function getActiveSettingHeadings($conn)
            {
                $query = "SELECT ID, Name, Slug FROM setting_headings WHERE Status = 1";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    return mysqli_fetch_all($result, MYSQLI_ASSOC);
                }
                return [];
            }

            $headings = getActiveSettingHeadings($conn);
            ?>
            <li class="menu-item">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-world"></i>
                    <div>Website Flow</div>
                </a>
                <ul class="menu-sub">
                    <?php if (!empty($headings)): ?>
                        <?php foreach ($headings as $heading): ?>
                            <li class="menu-item">
                                <a href="/admin/settingdata?id=<?= $heading['ID']; ?>" class="menu-link">
                                    <div><?= $heading['Name']; ?></div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="menu-item">
                            <div>No headings available.</div>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>

            <!-- Layouts -->
            <li class="menu-item">
                <a href="" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
                    <div data-i18n="Main Menu">Main Menu</div>
                </a>

                <ul class="menu-sub">



                    <li class="menu-item">
                        <a href="./wings_heading" class="menu-link">
                            <div data-i18n="Wings Heading">Wings Heading</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="./wings" class="menu-link">
                            <div data-i18n="Wings ">Wings Data</div>
                        </a>
                    </li>

                    <?php if ($subdomain != "oldtheme") { ?>
                        <li class="menu-item">
                            <a href="./pages" class="menu-link">
                                <div data-i18n="Pages">Pages</div>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="menu-item">
                        <a href="./blogs" class="menu-link">
                            <div data-i18n="Blogs">Blogs</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="./blogfaq" class="menu-link">
                            <div data-i18n="BlogsFAQ">BlogsFAQ</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/partner" class="menu-link">
                            <div data-i18n="Partners">Partners</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/testimonials"
                            class="menu-link">
                            <div data-i18n="Testimonials">Testimonials</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/dynamicgallery" class="menu-link">
                            <div data-i18n="Gallery Category">Gallery Category</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/galleryimages" class="menu-link">
                            <div data-i18n="Gallery Images">Gallery Images</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/galleryvideo" class="menu-link">
                            <div data-i18n="Gallery Videos">Gallery Videos</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/leads" class="menu-link">
                            <div data-i18n="Website Leads">Website Leads</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/faqs" class="menu-link">
                            <div data-i18n="Website Faqs">Website Faqs</div>
                        </a>
                    </li>


                </ul>
            </li>





            <!-- Apps & Pages -->
            <li class="menu-header small">
                <span class="menu-header-text" data-i18n="Apps & Pages">Apps &amp; Pages</span>
            </li>

        </ul>
    <?php elseif ($subdomain === "jvnscms") : ?>
        <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item active open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Dashboards">Dashboards</div>
                    <div class="badge bg-danger rounded-pill ms-auto">1</div>
                </a>
                <ul class="menu-sub">

                    <li class="menu-item active">
                        <a href="./indexnew" class="menu-link">
                            <div data-i18n="Analytics">Analytics</div>
                        </a>
                    </li>

                </ul>
            </li>



            <li class="menu-item">
                <a onclick="add('app/themesetting/create&edit', 'modal-lg')" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Setting Heading">Theme Setting</div>
                </a>
            </li>


            <!-- Layouts -->
            <li class="menu-item">
                <a href="" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
                    <div data-i18n="Main Menu">Main Menu</div>
                </a>

                <ul class="menu-sub">



                    <li class="menu-item">
                        <a href="./wings_heading" class="menu-link">
                            <div data-i18n="Wings Heading">Wings Heading</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="./wings" class="menu-link">
                            <div data-i18n="Wings ">Wings Data</div>
                        </a>
                    </li>

                    <?php if ($subdomain != "oldtheme") { ?>
                        <li class="menu-item">
                            <a href="./pages" class="menu-link">
                                <div data-i18n="Pages">Pages</div>
                            </a>
                        </li>
                    <?php } ?>




                    <li class="menu-item">
                        <a href="/admin/testimonials"
                            class="menu-link">
                            <div data-i18n="Testimonials">Testimonials</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/dynamicgallery" class="menu-link">
                            <div data-i18n="Gallery Category">Gallery Category</div>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="/admin/leads" class="menu-link">
                            <div data-i18n="Website Leads">Website Leads</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/faqs" class="menu-link">
                            <div data-i18n="Website Faqs">Website Faqs</div>
                        </a>
                    </li>


                </ul>
            </li>





            <!-- Apps & Pages -->
            <li class="menu-header small">
                <span class="menu-header-text" data-i18n="Apps & Pages">Apps &amp; Pages</span>
            </li>

        </ul>
    <?php elseif ($subdomain === "prakriticms") : ?>
        <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item active open">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Dashboards">Dashboards</div>
                    <div class="badge bg-danger rounded-pill ms-auto">1</div>
                </a>
                <ul class="menu-sub">

                    <li class="menu-item active">
                        <a href="./indexnew" class="menu-link">
                            <div data-i18n="Analytics">Analytics</div>
                        </a>
                    </li>

                </ul>
            </li>



            <li class="menu-item">
                <a onclick="add('app/themesetting/create&edit', 'modal-lg')" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Setting Heading">Theme Setting</div>
                </a>
            </li>



            <!-- Layouts -->
            <li class="menu-item">
                <a href="" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-layout-sidebar"></i>
                    <div data-i18n="Main Menu">Main Menu</div>
                </a>

                <ul class="menu-sub">



                    <li class="menu-item">
                        <a href="./wings_heading" class="menu-link">
                            <div data-i18n="Wings Heading">Wings Heading</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="./wings" class="menu-link">
                            <div data-i18n="Wings ">Wings Data</div>
                        </a>
                    </li>

                    <?php if ($subdomain != "oldtheme") { ?>
                        <li class="menu-item">
                            <a href="./pages" class="menu-link">
                                <div data-i18n="Pages">Pages</div>
                            </a>
                        </li>
                    <?php } ?>

                    <li class="menu-item">
                        <a href="./blogs" class="menu-link">
                            <div data-i18n="Blogs">Blogs</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="./blogfaq" class="menu-link">
                            <div data-i18n="BlogsFAQ">BlogsFAQ</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="/admin/testimonials"
                            class="menu-link">
                            <div data-i18n="Testimonials">Testimonials</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/dynamicgallery" class="menu-link">
                            <div data-i18n="Gallery Category">Gallery Category</div>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="/admin/leads" class="menu-link">
                            <div data-i18n="Website Leads">Website Leads</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/admin/faqs" class="menu-link">
                            <div data-i18n="Website Faqs">Website Faqs</div>
                        </a>
                    </li>


                </ul>
            </li>





            <!-- Apps & Pages -->
            <li class="menu-header small">
                <span class="menu-header-text" data-i18n="Apps & Pages">Apps &amp; Pages</span>
            </li>

        </ul>

    <?php else : ?>
        <!-- Default or permission error message -->
        <ul class="menu-inner py-1">
            <li class="menu-item">
                <div class="menu-link">
                    <div>You do not have permission Access.</div>
                </div>
            </li>
        </ul>
    <?php endif; ?>




</aside>



<!-- Home Icons:

ti ti-home — Home
ti ti-home-outline — Home Outline
User and Account Icons:

ti ti-user — User
ti ti-user-outline — User Outline
ti ti-user-plus — User Plus
ti ti-user-minus — User Minus
ti ti-users — Users
Settings and Tools:

ti ti-settings — Settings
ti ti-cog — Cog
ti ti-wrench — Wrench
ti ti-tool — Tool
Navigation and Menu:

ti ti-menu — Menu
ti ti-arrow-right — Arrow Right
ti ti-arrow-left — Arrow Left
ti ti-arrow-up — Arrow Up
ti ti-arrow-down — Arrow Down
Social Media Icons:

ti ti-facebook — Facebook
ti ti-twitter — Twitter
ti ti-instagram — Instagram
ti ti-linkedin — LinkedIn
ti ti-youtube — YouTube
ti ti-pinterest — Pinterest
Content and Document:

ti ti-pencil — Pencil
ti ti-clipboard — Clipboard
ti ti-file — File
ti ti-folder — Folder
ti ti-cloud — Cloud
Media and Multimedia:

ti ti-video-camera — Video Camera
ti ti-music — Music
ti ti-headphone — Headphone
ti ti-volume-up — Volume Up
ti ti-volume-down — Volume Down
ti ti-volume-off — Volume Off
File Management:

ti ti-download — Download
ti ti-upload — Upload
ti ti-trash — Trash
ti ti-folder-open — Open Folder
Interface and Design:

ti ti-paint — Paint
ti ti-font — Font
ti ti-brush — Brush
ti ti-text — Text
Alerts and Notifications:

ti ti-bell — Bell
ti ti-bell-off — Bell Off
ti ti-alert — Alert
ti ti-alert-alt — Alert Alternative
Miscellaneous:

ti ti-search — Search
ti ti-close — Close
ti ti-check — Check
ti ti-close-circle — Close Circle
ti ti-refresh — Refresh
ti ti-reload — Reload
ti ti-time — Time -->