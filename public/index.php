<?php include 'layout/header.php'; ?>
  <div class="row">
      <?php include 'layout/sidebar.php' ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
          <?php include 'layout/toolbar.php' ?>
      </div>
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
            <div class="col-lg-6 px-0">
                <h1 class="display-4 fst-italic">Steps to use the tool</h1>
                <p class="lead my-3">Click import button above</p>
                <ul>
                    <li>Create or choose the lists </li>
                    <li>Upload CSV file. You can use CSV examples from the sidebar</li>
                </ul>
            </div>
        </div>
    </main>
  </div>
</div>
<?php include 'layout/footer.php' ?>
