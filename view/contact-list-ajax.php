<?php // if (!empty($result)) {   ?>
<table>
    <thead>
        <tr class="search-row">
            <th class="priority-1">
                <div class="input-addon">
                    <input name="uname" id="uname" value="<?php echo empty($_GET['uname']) ? '' : $_GET['uname'] ?>" placeholder="Name" form="frmFilter">
                    <button type="submit" form="frmFilter" onclick="doSearch(this)">
                        <img src="<?php echo WORK_ROOT; ?>view/image/search.png">
                    </button>
                </div>
            </th>
            <th class="priority-2">
                <div class="input-addon">
                    <input name="POR" id="POR" value="<?php echo empty($_GET['POR']) ? '' : $_GET['POR'] ?>" placeholder="Phone, Office, Residential" form="frmFilter">
                    <button type="submit" form="frmFilter" onclick="doSearch(this)">
                        <img src="<?php echo WORK_ROOT; ?>view/image/search.png">
                    </button>
                </div>
            </th>
            <th class="priority-4">
                <div class="input-addon">
                    <input name="email" id="email" value="<?php echo empty($_GET['email']) ? '' : $_GET['email'] ?>" placeholder="Email" form="frmFilter">
                    <button type="submit" form="frmFilter" onclick="doSearch(this)">
                        <img src="<?php echo WORK_ROOT; ?>view/image/search.png">
                    </button>
                </div>
            </th>
            <th class="priority-5">
                <div class="input-addon">
                    <input name="EDG" id="EDG" value="<?php echo empty($_GET['EDG']) ? '' : $_GET['EDG'] ?>" placeholder="Employee Type, Department, Designation" form="frmFilter">
                    <button type="submit" form="frmFilter" onclick="doSearch(this)">
                        <img src="<?php echo WORK_ROOT; ?>view/image/search.png">
                    </button>
                </div>
            </th>
        </tr>
        <tr>
            <th class="priority-1"><?php echo $u->getSortHead("name", "Name", $_q); ?></th>
            <th class="priority-2" style="width:150px;padding-left: 8px;">Phone<br>Office<br>Residential</th>
            <th class="priority-4" style="width:160px;"><?php echo $u->getSortHead("user_email", "Email", $_q); ?></th>
            <th class="priority-5" style="width:150px;padding-left: 8px;">Employee Type<br>Department<br>Designation</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!$result)
            $result = array();
        foreach ($result as $k => $v) {
            ?>
            <tr>
                <td class="priority-1" style="width:auto!important;;">
                    <span class="text-decoration"
                          title="View"
                          onclick="openDialog('<?php echo WORK_ROOT; ?>', 'contact/view/modal/<?php $u->xecho($result[$k]["id"]); ?>/'
                                              , '<?php $u->xecho($result[$k]["name"]); ?>');">

                        <?php
                        if (empty($result[$k]["user_photo"])) {
                            ?><img class="profile-image"
                                 src='<?php echo WORK_ROOT; ?>view/image/defaultavatar.png'
                                 alt="Photo"><?php
                             } else {
                                 ?><img class="profile-image"
                                 src='<?php echo WORK_ROOT; ?>data/<?php $u->xecho($result[$k]["user_photo"]) ?>'
                                 alt="Photo"><?php
                             }$u->xecho($result[$k]["name"]);
                             ?></span>
                    <span style="float:right;">
                        <button type="button"
                                style="background: none; border:0; padding:6px 0;"
                                title="Edit" onclick="openDialog('<?php echo WORK_ROOT; ?>', 'contact/edit/<?php $u->xecho($result[$k]["id"]); ?>/', 'Edit Contact', '', true, true);">
                            <img src="<?php echo WORK_ROOT; ?>view/image/icon-edit.png">
                        </button>
                        <button type="button"
                                style="background: none; border:0; padding:0;"
                                title="Delete"
                                onclick="openDialog('<?php echo WORK_ROOT; ?>', 'contact/delete/<?php $u->xecho($result[$k]["id"]); ?>/', 'Delete', 'auto', true, false)">
                            <img
                                src="<?php echo WORK_ROOT; ?>view/image/icon-delete.png">
                        </button>
                    </span>
                </td>
                <td class="priority-2">
                    <div class="dv-number">
                        <span class="circle-text">P</span>
                        <a href="tel:<?php $u->xecho($result[$k]["user_mobile_no"]); ?>"><?php $u->xecho($result[$k]["user_mobile_no"]); ?></a>
                    </div>
                    <div class="dv-number">
                        <span class="circle-text">O</span>
                        <a href="tel:<?php $u->xecho($result[$k]["user_office_no"]); ?>"><?php $u->xecho($result[$k]["user_office_no"]); ?></a>
                    </div>
                    <div class="dv-number">
                        <span class="circle-text">R</span>
                        <a href="tel:<?php $u->xecho($result[$k]["user_residential_no"]); ?>"><?php $u->xecho($result[$k]["user_residential_no"]); ?></a>
                    </div>
                </td>
                <td class="priority-4"><nobr><a href="mailto:<?php $result[$k]["user_email"] ? $u->xecho($result[$k]["user_email"] . '@xlri.ac.in') : ''; ?>"><?php $result[$k]["user_email"] ? $u->xecho($result[$k]["user_email"] . '@xlri.ac.in') : ''; ?></a></nobr></td>
                <td class="priority-5">

                    <div class="dv-number">
                        <span>E - </span>
                        <?php $u->xecho($result[$k]["relationship"]); ?>
                    </div>
                    <div class="dv-number">
                        <span>D - </span>
                        <?php $u->xecho($result[$k]["destination"]); ?>
                    </div>
                    <div class="dv-number">
                        <span>DG - </span>
                        <?php $u->xecho($result[$k]["company"]); ?>
                    </div>
            </td>
        </tr>
    <?php } ?>
</tbody>
</table>
<?php require_once "view/framework/pagination.php"; ?>
<input type="hidden" id="queryString"
       value="<?php
       if (!empty($queryString)) {
           echo $queryString;
       }
       ?>" />
<input type="hidden" id="contact-list-tag"
       value="<?php
       if (!empty($_GET["tag"])) {
           echo $_GET["tag"];
       }
       ?>" />
       <?php // }  ?>
<script type="text/javascript">
    function doSearch(el){
        var searchVal = $(el).prev().val();
        $('.input-addon input').val('');
        $(el).prev().val(searchVal);
    }
</script>
<style>
    .search-container{
        padding: 0;
    }
    .input-addon{
        width: 95%;
        margin: 0 auto;
        position: relative;
    }

    .input-addon input{
        width: 100%;
        padding: 5px 30px 5px 10px;
        margin: 0;
        border: 1px solid #ddd;
        border-radius: .25rem;
        -webkit-border-radius: .25rem;
        -moz-border-radius: .25rem;
        -ms-border-radius: .25rem;
    }
    .input-addon button{
        position: absolute;
        right:0;
        top: 0;
        display: inline-block;
        cursor: pointer;
        background-color: #fff;
        background-image: none;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        margin: 0;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: .25rem;
        -webkit-border-radius: .25rem;
        -moz-border-radius: .25rem;
        -ms-border-radius: .25rem;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        -webkit-appearance: button;
        -moz-appearance: button;
        -ms-appearance: button;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    .input-addon button:hover{
        background: #dfdfdf;
    }
    
    .circle-text{
        width: 18px;
        height: 18px;
        display: inline-block;
        background: #ececec;
        border: solid 1px #777;
        border-radius: 50%;
        text-align: center;
    }
</style>