<?php include '../layout/header.php';
$files = glob(SAVED . '/*.csv');
?>
<div class="row">
    <?php include '../layout/sidebar.php' ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">FIles</h1>
            <?php include '../layout/toolbar.php' ?>
        </div>
        <div class="table-responsive small ">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>

                        <th scope="col">File</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($files as $file){ ?>
                <tr>
                    <td><?php echo  basename($file); ?></td>
                    <td>
                        <a href="/data/saved/<?php echo basename($file) ?>" title="Export to CSV">
                            <i class="bi bi-download"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</div>
<?php include '../layout/footer.php' ?>
