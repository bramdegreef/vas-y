<?php

include_once("../php_includes/check_login_status.php");

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
                <h2>Leerkrachten:</h2>

                <table id="teacherFilter">
                    <tr>
                        <th colspan="2">
                            Vind je leerkracht:
                        </th>
                    </tr>
                    <tr>
                        <td>Naam:</td>
                        <td>
                            <input type="text" id="leerkrachtSearch">
                        </td>
                    </tr>
                    <tr>
                        <td>School:</td>
                        <td>
                            <select>
                                <option selected>
                                    Sint-Guido-Instituut
                                </option>
                                <option>
                                    Imelda-Instituut
                                </option >
                                <option>
                                    Maria-Boodschaplyceum
                                </option>
                                <option>
                                    Regina Pacisinstituut
                                </option>
                                <option>
                                    ...
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Vak:</td>
                        <td>
                            <select>
                                <option selected>
                                    Wiskunde
                                </option>
                                <option>
                                    Nederlands
                                </option >
                                <option>
                                    Frans
                                </option>
                                <option>
                                    Godsdienst
                                </option>
                                <option>
                                    ...
                                </option>
                            </select>
                        </td>
                    </tr>
                    
                </table>
                <button>Zoek leerkracht</button><br><br>


                <table id="leerkrachten">
                    <tr>
                        <td align="center">
                            Leerkracht 1
                            <br>
                            <img src="../img/teacher.png">
                            <br> School x
                            <br> <button>Stuur bericht</button>
                        </td>
                        <td align="center">
                            Leerkracht 2
                            <br>
                            <img src="../img/teacher.png">
                            <br> School x<br>
                            <button>Stuur bericht</button>
                        </td>
                        <td align="center"> Leerkracht 3
                            <br>
                            <img src="../img/teacher.png">
                            <br> School x
                            <br> <button>Stuur bericht</button>
                        </td>
                        <td align="center"> Leerkracht 4
                            <br>
                            <img src="../img/teacher.png">
                            <br> School x
                            <br> <button>Stuur bericht</button>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            Leerkracht 5
                            <br>
                            <img class="" src="../img/teacher.png">
                            <br> School x
                            <br> <button>Stuur bericht</button>
                        </td>
                        <td align="center">
                            Leerkracht 6
                            <br>
                            <img src="../img/teacher.png">
                            <br> School x
                            <br> <button>Stuur bericht</button>
                        </td>
                        <td align="center"> Leerkracht 7
                            <br>
                            <img src="../img/teacher.png">
                            <br> School x
                            <br> <button>Stuur bericht</button>
                        </td>
                        <td align="center"> Leerkracht 8
                            <br>
                            <img src="../img/teacher.png">
                            <br> School x
                            <br> <button>Stuur bericht</button>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>


</body>

</html>