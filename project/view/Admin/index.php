<?php
$this->title = "Dashboard";
?>

<body class="w3-light-grey">

    <!-- Top container -->
    <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
        <!-- <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button> -->
        <span class="w3-bar-item w3-right">Logo</span>
    </div>

    <!-- Sidebar/menu -->
    <!-- <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
        <div class="w3-container w3-row">
            <div class="w3-col s4">
                <img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
            </div>
            <div class="w3-col s8 w3-bar">
                <span>Welcome, <strong>Mike</strong></span><br>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
                <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
            </div>
        </div>
        <hr>
        <div class="w3-container">
            <h5>Dashboard</h5>
        </div>
        <div class="w3-bar-block">
            <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
            <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Overview</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Views</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Traffic</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Geo</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-diamond fa-fw"></i>  Orders</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bell fa-fw"></i>  News</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bank fa-fw"></i>  General</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  History</a>
            <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a><br><br>
        </div>
    </nav> -->


    <!-- Overlay effect when opening sidebar on small screens -->
    <!-- <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div> -->

    <!-- !PAGE CONTENT! -->
    <!-- <div class="w3-main" style="margin-left:300px;margin-top:43px;"> -->
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
                        <h3>50</h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Users</h4>
                </div>
            </div>
            <div class="dashboard-menu-btn piano_btn w3-third" data-sound="chat_board" data-soundclass="panel-board">
                <div class="w3-container w3-blue w3-padding-16">
                    <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>99</h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Chats</h4>
                </div>
            </div>
            <div class="dashboard-menu-btn piano_btn w3-third" data-sound="message_board" data-soundclass="panel-board">
                <div class="w3-container w3-red w3-padding-16">
                    <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>52</h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Messages</h4>
                </div>
            </div>
        </div>

        <div class="w3-panel">
            <div id="user_board"  class="panel-board">
                <table class="user-table">
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
                </table>
            </div>
            <div id="chat_board" class="panel-board"></div>
            <div id="message_board" class="panel-board"></div>
            <!-- <div class="w3-row-padding" style="margin:0 -16px">
                <div class="w3-third">
                    <h5>Regions</h5>
                    <img src="/w3images/region.jpg" style="width:100%" alt="Google Regional Map">
                </div>
                <div class="w3-twothird">
                    <h5>Feeds</h5>
                    <table class="w3-table w3-striped w3-white">
                        <tr>
                            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
                            <td>New record, over 90 views.</td>
                            <td><i>10 mins</i></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
                            <td>Database error.</td>
                            <td><i>15 mins</i></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
                            <td>New record, over 40 users.</td>
                            <td><i>17 mins</i></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
                            <td>New comments.</td>
                            <td><i>25 mins</i></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
                            <td>Check transactions.</td>
                            <td><i>28 mins</i></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
                            <td>CPU overload.</td>
                            <td><i>35 mins</i></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
                            <td>New shares.</td>
                            <td><i>39 mins</i></td>
                        </tr>
                    </table>
                </div>
            </div> -->
        </div>

        <!-- <hr>
        <div class="w3-container">
            <h5>General Stats</h5>
            <p>New Visitors</p>
            <div class="w3-grey">
                <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
            </div>

            <p>New Users</p>
            <div class="w3-grey">
                <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
            </div>

            <p>Bounce Rate</p>
            <div class="w3-grey">
                <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
            </div>
        </div>
        <hr>

        <div class="w3-container">
            <h5>Countries</h5>
            <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <tr>
                    <td>United States</td>
                    <td>65%</td>
                </tr>
                <tr>
                    <td>UK</td>
                    <td>15.7%</td>
                </tr>
                <tr>
                    <td>Russia</td>
                    <td>5.6%</td>
                </tr>
                <tr>
                    <td>Spain</td>
                    <td>2.1%</td>
                </tr>
                <tr>
                    <td>India</td>
                    <td>1.9%</td>
                </tr>
                <tr>
                    <td>France</td>
                    <td>1.5%</td>
                </tr>
            </table><br>
            <button class="w3-button w3-dark-grey">More Countries  <i class="fa fa-arrow-right"></i></button>
        </div>
        <hr>
        <div class="w3-container">
            <h5>Recent Users</h5>
            <ul class="w3-ul w3-card-4 w3-white">
                <li class="w3-padding-16">
                    <img src="/w3images/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                    <span class="w3-xlarge">Mike</span><br>
                </li>
                <li class="w3-padding-16">
                    <img src="/w3images/avatar5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                    <span class="w3-xlarge">Jill</span><br>
                </li>
                <li class="w3-padding-16">
                    <img src="/w3images/avatar6.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
                    <span class="w3-xlarge">Jane</span><br>
                </li>
            </ul>
        </div>
        <hr>

        <div class="w3-container">
            <h5>Recent Comments</h5>
            <div class="w3-row">
                <div class="w3-col m2 text-center">
                    <img class="w3-circle" src="/w3images/avatar3.png" style="width:96px;height:96px">
                </div>
                <div class="w3-col m10 w3-container">
                    <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
                    <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
                </div>
            </div>

            <div class="w3-row">
                <div class="w3-col m2 text-center">
                    <img class="w3-circle" src="/w3images/avatar1.png" style="width:96px;height:96px">
                </div>
                <div class="w3-col m10 w3-container">
                    <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
                    <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
                </div>
            </div>
        </div>
        <br>
        <div class="w3-container w3-dark-grey w3-padding-32">
            <div class="w3-row">
                <div class="w3-container w3-third">
                    <h5 class="w3-bottombar w3-border-green">Demographic</h5>
                    <p>Language</p>
                    <p>Country</p>
                    <p>City</p>
                </div>
                <div class="w3-container w3-third">
                    <h5 class="w3-bottombar w3-border-red">System</h5>
                    <p>Browser</p>
                    <p>OS</p>
                    <p>More</p>
                </div>
                <div class="w3-container w3-third">
                    <h5 class="w3-bottombar w3-border-orange">Target</h5>
                    <p>Users</p>
                    <p>Active</p>
                    <p>Geo</p>
                    <p>Interests</p>
                </div>
            </div>
        </div> -->

        <!-- Footer -->
        <!-- <footer class="w3-container w3-padding-16 w3-light-grey">
            <h4>FOOTER</h4>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </footer> -->

        <!-- End page content -->
    </div>

    <script>
        // // Get the Sidebar
        // var mySidebar = document.getElementById("mySidebar");

        // // Get the DIV with overlay effect
        // var overlayBg = document.getElementById("myOverlay");

        // // Toggle between showing and hiding the sidebar, and add overlay effect
        // function w3_open() {
        //     if (mySidebar.style.display === 'block') {
        //         mySidebar.style.display = 'none';
        //         overlayBg.style.display = "none";
        //     } else {
        //         mySidebar.style.display = 'block';
        //         overlayBg.style.display = "block";
        //     }
        // }

        // // Close the sidebar with the close button
        // function w3_close() {
        //     mySidebar.style.display = "none";
        //     overlayBg.style.display = "none";
        // }
    </script>

</body>

<!-- </html> -->