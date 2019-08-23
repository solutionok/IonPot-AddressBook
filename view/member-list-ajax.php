
<div class="margin-zero-auto float-right contemt-width add-member">
    <a id="member-add" class="cursor-pointer"
        onClick="openDialog('<?php echo WORK_ROOT; ?>','contact/member/add/','Member Add','auto',true)"><button
            class="btn-outline btn-save cursor-pointer">Add</button></a>
</div>

<table>
    <thead>
        <tr>
            <th class="priority-1">
            <?php echo $u->getSortHead("username", "Username");?></th>
            <th class="priority-2"><?php echo $u->getSortHead("email", "Email");?></th>
            <th class="priority-3">Role</th>
            <th class="text-center priority-1">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $k => $v) { ?>
            <tr>
            <td class="priority-1"><span> <?php $u->xecho($result[$k]["username"]); ?></span></td>
            <td class="priority-2"><?php $u->xecho($result[$k]["email"]); ?></td>
            <td class="priority-3"><?php $u->xecho($result[$k]["role"]); ?></td>
            <td class="text-center priority-1">
                <div class="action">
        <?php
        if ($result[$k]['id'] != $_SESSION['member_id']) {
            ?>
                    <button type="button"
                        style="background: none; border: 0; padding-right: 0;"
                        title="Edit" onclick="openDialog('<?php echo WORK_ROOT; ?>', 'contact/member/edit/<?php echo $result[$k]["id"]; ?>/', 'Edit Member', 'auto', true);">
                        <img src="<?php echo WORK_ROOT; ?>view/image/icon-edit.png">
                    </button>
                    <!-- <button type="button"
                        style="background: none; border: 0; padding-right: 0;"
                        title="Delete"
                        onclick="viewDelete('<?php echo WORK_ROOT; ?>'
                        ,<?php $u->xecho($result[$k]["id"]); ?>,'deleteMember');">
                        <img
                            src="<?php echo WORK_ROOT; ?>view/image/icon-delete.png">
                    </button>  -->
                    <button type="button"
                        style="background: none; border: 0; padding-right: 0;"
                        title="Delete"
                        onclick="openDialog('<?php echo WORK_ROOT; ?>','member/delete/<?php $u->xecho($result[$k]["id"]); ?>/','Delete','auto',true,false)">
                        <img
                            src="<?php echo WORK_ROOT; ?>view/image/icon-delete.png">
                    </button>
                    <?php
        }
        ?>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<?php require_once 'view/framework/pagination.php';?>
<input type="hidden" id="queryString"
    value="<?php
    if (! empty($queryString)) {
        echo $queryString;
    }
    ?>" />
<input type="hidden" id="contact-list-tag"
    value="<?php
    if (! empty($_GET["tag"])) {
        echo $_GET["tag"];
    }
    ?>" />
