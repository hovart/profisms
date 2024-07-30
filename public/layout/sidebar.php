<?php $current_page = $_SERVER['PHP_SELF']; ?>
<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiar">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?php echo $current_page == '/index.php'?'active':''?>" aria-current="page" href="/">
                        <svg class="bi"><use xlink:href="#house-fill"/></svg>
                        Dashboard
                    </a>
                </li>
            </ul>
            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?php echo $current_page == '/pages/files.php'?'active':''?>" href="../pages/files.php">
                        <svg class="bi"><use xlink:href="#file"/></svg>
                        Files
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?php echo $current_page == '/pages/lists.php'?'active':''?>" href="../pages/lists.php">
                        <svg class="bi"><use xlink:href="#file"/></svg>
                        Lists
                    </a>
                </li>
            </ul>
            <hr class="my-3">
            <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="/Task.pdf" target="_blank">
                        <svg class="bi"><use xlink:href="#pdf"/></svg>
                        Task
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="/data/examples/example_correct_and_empty.csv" target="_blank">
                        <i class="bi bi-filetype-csv"></i>
                        Example Correct CSV
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="/data/examples/example_wrong_and_empty.csv" target="_blank">
                        <i class="bi bi-filetype-csv"></i>
                        Example Wrong CSV
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>