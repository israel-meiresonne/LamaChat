<?php
require_once 'model/Chart.php';

$this->title = "Dashboard";
echo $msgChart->getChart();
echo $chatChart->getChart();
?>


<body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
        <span class="w3-bar-item w3-right">Logo</span>
    </div>

    <!-- !PAGE CONTENT! -->
    <div class="page-content">
        <!-- Header -->
        <header class="w3-container" style="padding-top:22px">
            <a href="home" class="standard-button green-button remove-button-default-att" style="padding:5px">baculer vers Lamachat</a>
            <hr>
            <h5><b><i class="fa fa-dashboard"></i> Dashboard</b></h5>
        </header>

        <div class="dashboard-menu w3-row-padding w3-margin-bottom">
            <div class="dashboard-menu-btn piano_btn w3-third" data-sound="user_board" data-soundclass="panel-board">
                <div class="w3-container w3-orange w3-text-white w3-padding-16">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3><?= $nbUser ?></h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Users</h4>
                </div>
            </div>
            <div class="dashboard-menu-btn piano_btn w3-third" data-sound="chat_board" data-soundclass="panel-board">
                <div class="w3-container w3-red w3-padding-16">
                    <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3><?= $nbDiscussion ?></h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Chats</h4>
                </div>
            </div>
            <div class="dashboard-menu-btn piano_btn w3-third" data-sound="message_board" data-soundclass="panel-board">
                <div class="w3-container w3-blue w3-padding-16">
                    <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3><?= $nbMessage ?></h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Messages</h4>
                </div>
            </div>
        </div>

        <div id="user_profile" class="w3-modal" style="z-index:4">
            <div class="w3-modal-content">
                <div class="w3-container w3-padding w3-red">
                    <span id="profile_close_button" class="w3-button w3-red w3-right w3-xxlarge"><i class="fa fa-remove"></i></span>
                    <h2>profile</h2>
                </div>
                <div class="w3-panel">

                </div>
            </div>
        </div>

        <div class="panel-container w3-panel">
            <div id="user_board" class="panel-board">
                <?php
                $datas = [
                    "users" => $users
                ];
                ob_start();
                require 'view/Admin/files/userTable.php';
                echo ob_get_clean();
                ?>
            </div>
            <div id="chat_board" class="panel-board"></div>
            <div id="message_board" class="panel-board"></div>
        </div>
    </div>
</body>