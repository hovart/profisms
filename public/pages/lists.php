<?php
include '../layout/header.php';

use Multi\MsisdnListMsisdn;

$mls = new MsisdnListMsisdn();

$lists = $mls->Db->select('msisdn_list')->orderBy('created_at', 'DESC')->all();
?>
<div class="row">
    <?php include '../layout/sidebar.php' ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Lists</h1>
            <?php include '../layout/toolbar.php' ?>
        </div>
        <div class="table-responsive small ">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($lists as $key => $list){ ?>
                    <tr>
                        <td><?=$key+1 ?></td>
                        <td><?=$list['id'] ?></td>
                        <td><?=$list['title'] ?></td>
                        <td><?=$list['created_at'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</div>
<?php include '../layout/footer.php' ?>
