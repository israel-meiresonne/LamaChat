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
                // echo $this->generateFile('view/Admin/files/userTable.php', $datas);
                ?>
                <!-- <table class="user-table">
                    <tr>
                        <th class="image"><span>photo</span></th>
                        <th><span>pseudo</span></th>
                        <th><span>prénom</span></th>
                        <th><span>nom</span></th>
                        <th><span>date de naissance</span></th>
                        <th><span>permission</span></th>
                        <th colspan="2"><span></span></th>
                    </tr>
                    <tr>
                        <td>
                            <button class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/user-test2.png" onclick="openProfile('pseudo', 'pseudo2')">
                            </button>
                        </td>
                        <td><span>pseudo2</span></td>
                        <td><span>pseudo2</span></td>
                        <td><span>pseudo2</span></td>
                        <td><span>pseudo2</span></td>
                        <td><span>pseudo2</span></td>
                        <td><button id="removeContact8r01304j04151x02n0233y467" data-window="contact_window" onclick="removeContact('removeContact8r01304j04151x02n0233y467', 'pseudo', 'pseudo2')" class="standard-button red-button remove-button-default-att">supprimer</button></td>
                        <td><button id="relationStatusaw0e0r2493rw37p000q41421r" onclick="blockContact('relationStatusaw0e0r2493rw37p000q41421r', 'pseudo', 'pseudo2')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
                    </tr>
                    <tr>
                        <td>
                            <button class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/30aw08002570160o7j25.jpeg" onclick="openProfile('pseudo', 'pseudo5')">
                            </button>
                        </td>
                        <td><span>pseudo5</span></td>
                        <td><span>pseudo5</span></td>
                        <td><span>pseudo5</span></td>
                        <td><span>pseudo5</span></td>
                        <td><span>pseudo5</span></td>
                        <td><button id="removeContact0m04042kb2133j0z74040vph1" data-window="contact_window" onclick="removeContact('removeContact0m04042kb2133j0z74040vph1', 'pseudo', 'pseudo5')" class="standard-button red-button remove-button-default-att">supprimer</button></td>
                        <td><button id="relationStatus1j2002b5j23404064037rq431" onclick="blockContact('relationStatus1j2002b5j23404064037rq431', 'pseudo', 'pseudo5')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
                    </tr>
                    <tr>
                        <td>
                            <button class="img-button remove-button-default-att">
                                <img src="content/images/user-profile/00729011022pc96d72aj.jpg" onclick="openProfile('pseudo', 'skryska')">
                            </button>
                        </td>
                        <td><span>skryska</span></td>
                        <td><span>skryska</span></td>
                        <td><span>skryska</span></td>
                        <td><span>skryska</span></td>
                        <td><span>skryska</span></td>
                        <td><button id="removeContactyt610xm0t4731c3o02ig240o0" data-window="contact_window" onclick="removeContact('removeContactyt610xm0t4731c3o02ig240o0', 'pseudo', 'skryska')" class="standard-button red-button remove-button-default-att">supprimer</button></td>
                        <td><button id="relationStatusbt02ot301vh47l0a22010f324" onclick="blockContact('relationStatusbt02ot301vh47l0a22010f324', 'pseudo', 'skryska')" class="standard-button orange-button remove-button-default-att">bloquer</button></td>
                    </tr>
                </table> -->
            </div>
            <div id="chat_board" class="panel-board"></div>
            <div id="message_board" class="panel-board"></div>
        </div>
    </div>
</body>

<!-- </html> -->