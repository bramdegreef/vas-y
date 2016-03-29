<?php
    require_once('../php_includes/class-insert.php');
    require_once('../php_includes/class-query.php');
    include_once("../php_includes/check_login_status.php");

    $send_success = false;

    if ( !empty ( $_POST ) ) {
            if($send_message = $insert->send_message($_POST)){
                $send_success = true;
            }
    }

    $friend_ids = $query->get_friends($log_id);
    foreach ( $friend_ids as $friend_id ) {
		$friend_objects[] = $query->load_user_object($friend_id);
	}

?>
    <!doctype html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Vas-y</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
        <script src="../js/bootstrap.js"></script>
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/dashboard.css" rel="stylesheet">
        <script type="text/javascript">
            $("document").ready(function () {
                var right = document.getElementById('messagesDiv').style.height;
                var left = document.getElementById('profileInfoDiv').style.height;
                if (left > right) {
                    document.getElementById('profileInfoDiv').style.height = left;
                } else {
                    document.getElementById('messagesDiv').style.height = right;
                }
            });
        </script>
    </head>

    <body>

        <!--Nav bar-->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="user.php?id=<?php echo $log_id;?>">Vas-y</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right navbarDashboard">
                        <li>
                            <a href="berichten.php"><span class="glyphicon glyphicon-envelope"></span> Berichten</a>
                        </li>
                        <li>
                            <a href="account.php"><img src="../img/user.png" class="img-circle" width="20" height="20"> Mijn account</a>
                        </li>
                        <li>
                            <a href="#" onclick="tryLogout()"><span class="glyphicon glyphicon-log-out"></span> Uitloggen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="row">
            <div class="col-sm-3" id="leftDash">
                <ul id="menu">
                    <li><a href="user.php?id=<?php echo $log_id;?>">Dashboard</a></li>
                    <li><a href="berichten.php">Berichten</a></li>
                    <li><a href="leerkrachten.php">Leerkrachten</a></li>
                    <li><a href="#Afspraken">Jouw afspraken</a></li>
                </ul>
            </div>

            <div class="col-sm-8" id="rightDash">

                <div class="pressedDiv rightPressedDiv col-sm-11" id="messagesDiv">
                    <h2>Berichten:</h2>

                    <button data-toggle="modal" data-target="#messageComposer">Stuur een nieuw bericht</button>
                    <input type="text" id="messageFilter" style="float: right;">
                    <button style="float: right;">Zoek</button>
                    <br>
                    <br>
                    <div style="display:<?php echo $send_success==true ? 'block':'none' ?>">
                        <div class="alert alert-success">
                            <strong>Gelukt!</strong> Je bericht werd verzonden.
                        </div>
                    </div>
                    <br>
                    <table id="messages">
                        <tr>
                            <th> Van </th>
                            <th> Onderwerp </th>
                            <th> Bericht </th>
                            <th> Datum </th>
                        </tr>
                        <?php $query->do_inbox($log_id); ?>
                    </table>
                </div>

            </div>

            <div class="modal fade" id="messageComposer" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <span id="formTitle">Nieuw bericht:</span>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <input name="message_time" type="hidden" value="<?php echo time(); ?>" />
                                <input name="message_sender_id" type="hidden" value="<?php echo $log_id; ?>" />
                                <p>
                                    <label for="message_recipient_id">Naar:</label>
                                    <select name="message_recipient_id">
                                        <option value="" disabled>--Select a Friend--</option>
                                        <?php foreach ( $friend_objects as $friend ) : ?>
                                            <option value="<?php echo $friend->id; ?>">
                                                <?php echo $friend->Voornaam; echo " "; echo $friend->Familienaam ?>
                                            </option>
                                            <?php endforeach; ?>
                                    </select>
                                </p>
                                <p>
                                    <label class="labels" for="message_subject">Onderwerp:</label>
                                    <input name="message_subject" type="text" />
                                </p>
                                <p>
                                    <label for="message_content">Bericht:</label>
                                    <textarea name="message_content"></textarea>
                                </p>
                                <p>
                                    <input type="submit" value="Submit" />
                                </p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Sluit venster</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </body>

    </html>