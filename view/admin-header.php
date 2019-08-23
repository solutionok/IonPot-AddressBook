<script src="<?php echo WORK_ROOT; ?>view/js/member.js"></script>
<div id="header" class="default-primary-color">
    <div class="content-width res-content-width">
        <a class="float-left" href="<?php echo WORK_ROOT; ?>contact/"><span
            class="logo-text"><img src="https://www.virtu.co/demos/teledir/logo-xlri.jpg" /> <?php echo APP_NAME; ?></span></a>
        <div id="navigation">
            <div class="col" id="addbtn">
                <span class="btn mat-btn"
                    onClick="openDialog('<?php echo WORK_ROOT; ?>','contact/add/','Add Contact','',true,true)">+
                </span>
            </div>
            <div class="right-dropdown">
                <img id="menu" class="cursor-pointer"
                    src="<?php echo WORK_ROOT;?>view/image/menu.png">
                <div id="right-myDropdown"
                    class="right-dropdown-content dialog-header-bg">
                    <div class="cols2">

                        <a id="about" class="cursor-pointer"
                            onClick="openDialog('<?php echo WORK_ROOT; ?>','contact/version/modal/'
                            ,'About','auto',false)"> <span> <img
                                class="dropdown-menu-item" alt="About"
                                src="<?php echo WORK_ROOT;?>view/image/about.png">
                        </span><span>About</span>
                        </a><a id="import" class="cursor-pointer"
                            onClick="openDialog('<?php echo WORK_ROOT; ?>','contact/import/'
                            ,'Import','auto',true)">
                            <span> <img class="dropdown-menu-item"
                                alt="Import from CSV"
                                src="<?php echo WORK_ROOT;?>view/image/import.png">
                        </span><span> Import (CSV) </span>
                        </a> <a id="export" class="cursor-pointer"
                            href="<?php echo WORK_ROOT; ?>contact/export/">
                            <span> <img class="dropdown-menu-item"
                                alt="Export as CSV"
                                src="<?php echo WORK_ROOT;?>view/image/export.png">
                        </span><span> Export (CSV) </span>
                        </a> <a id="settings" class="cursor-pointer"
                            onClick="openDialog('<?php echo WORK_ROOT; ?>','contact/admin/edit/'
                            ,'Profile Edit','auto',true)"><span> <img
                                class="dropdown-menu-item"
                                alt="Settings"
                                src="<?php echo WORK_ROOT;?>view/image/setting.png">
                        </span><span>Settings</span></a>


                    <?php if ($_SESSION["role"] == "Admin") { ?>
                    <a id="member" class="cursor-pointer"
                            href="<?php echo WORK_ROOT; ?>member/"><span>
                                <img class="dropdown-menu-item"
                                alt="Member"
                                src="<?php echo WORK_ROOT;?>view/image/member.png">
                        </span><span>Member</span></a>
                    <?php } ?>
                        <a id="logout" class="cursor-pointer"
                            href="<?php echo WORK_ROOT; ?>logout/"><span>
                                <img class="dropdown-menu-item"
                                alt="Logout"
                                src="<?php echo WORK_ROOT;?>view/image/logout.png">
                        </span><span>Logout</span></a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function showAddDialog() {
    document.getElementById("right-myDropdown").classList.toggle("right-show");
}
</script>