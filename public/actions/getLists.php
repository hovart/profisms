<?php
require __DIR__ . '/../../vendor/autoload.php';

use Multi\MsisdnListMsisdn;

$mls = new MsisdnListMsisdn();

$lists = $mls->Db->select('msisdn_list')->all();
if(sizeof($lists)){ ?>
    <ul class="list-group">
        <?php foreach ($lists as $list) { ?>
            <li class="list-group-item list-group-item-action" id="item-<?php echo $list['id'] ?>">
                <input class="form-check-input me-1" name="msisdnlists[]" type="checkbox" value="<?php echo $list['id'] ?>" id="check-<?php echo $list['id'] ?>">
                <label class="form-check-label" for="check-<?php echo $list['id'] ?>"><?php echo $list['title'] ?></label>
                <a href="#" class="float-end px-1 delete" title="Delete" data-id="<?php echo $list['id'] ?>">
                    <i class="bi bi-trash3"></i>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php }else{ ?>
    <div id="noDataMessage" class="alert alert-info">
        No data available to display.
    </div>
<?php } ?>
