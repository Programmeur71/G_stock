<?php date_default_timezone_set('Africa/Douala');?>
<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="assets/datatable/css/adminlte.min.css">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="Controller/droit/style.css" />

</head>

<body>
    <div class="sucess">
        <h1 id="user">Bienvenue <?php echo $_SESSION['Pharmacie']; ?>!</h1>
        <p id="page">Gestion de licence du proget de pharmacie.</p>
        <a href="Controller/droit/logout.php">Déconnexion</a>
    </div><br><br>

    <div class="container-fluid">
        <div style="color:white" class="row">

            <div class="col-12 col-lg-4">
            </div>

            <div class="col-12 col-lg-4">

                <div id="select">
                    <center>
                        <h2>Ajouter une licence</h2>
                    </center><br>

                    selectionner la duré <select id="selectionss">
                        <option></option>
                        <option>5 minutes</option>
                        <option>10 minutes</option>
                        <option>15 minutes</option>
                        <option>2 semaines</option>
                        <option>1 an</option>
                        <option>2 ans</option>
                        <option>3 ans</option>
                    </select><br><br>
                </div>


                <div style="display:none;" id="selection">
                    <center>
                        <h2>Ajouter une licences</h2>
                    </center><br>

                    selectionner la duré <select id="selections">
                        <option></option>
                        <option>5 minutes</option>
                        <option>10 minutes</option>
                        <option>15 minutes</option>
                        <option>2 semaines</option>
                        <option>1 an</option>
                        <option>2 ans</option>
                        <option>3 ans</option>
                    </select><br><br>
                </div>

            </div>

            <div class="col-12 col-lg-4">
                <br><br><br>
                <input style="display:none" type="submit" value="effacer la licence"
                    class="btn btn btn-lg btn-danger rase">
            </div>
        </div>
    </div>

    <script src="assets/datatable/js/jquery.min.js"></script>

    <script src="assets/sweetalert/sweetalert2.all.min.js"></script>



    <script type="text/javascript">
    $(document).ready(function() {

        $(".rase").click(function() {
            $.post("Controller/Personnel.php", {
                action: "rase"
            }, function(rase) {
                if (rase == 1) {
                    alert('ok');
                } else {
                    alert('non');
                }
            });
        });

        /***************************************tours*************************************************/

        $("#selectionss").change(function() {

            temps = this.value;
            /*********************************5 minutes**************************************/
            if (temps == '5 minutes') {
                t5 = '';
                $.post("Controller/droit/calcule.php", {
                    temps: temps,
                    t5: t5
                }, function(calcul) {

                    swal.fire({
                        title: 'êtes-vous sûr !',
                        html: " D'ajouter <b>" + temps + "</b> a la licence",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui'
                    }).then((result) => {
                        if (result.value) {
                            sup5 = '';

                            alert('licence valider avec succes');

                        }
                    });


                });
            }
            /**************************************10 minutes*************************************/
            if (temps == '10 minutes') {
                t10 = '';
                $.post("Controller/droit/calcule.php", {
                    temps: temps,
                    t10: t10
                }, function(calcul) {


                    swal.fire({
                        title: 'êtes-vous sûr !',
                        html: " D'ajouter <b>" + temps + "</b> a la licence",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui'
                    }).then((result) => {
                        if (result.value) {
                            sup10 = '';

                            alert('licence valider avec succes');

                        }
                    });


                });
            }
            /********************************15 minutes***********************************/
            if (temps == '15 minutes') {
                t15 = '';
                $.post("Controller/droit/calcule.php", {
                    temps: temps,
                    t15: t15
                }, function(calcul) {

                    swal.fire({
                        title: 'êtes-vous sûr !',
                        html: " D'ajouter <b>" + temps + "</b> a la licence",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui'
                    }).then((result) => {
                        if (result.value) {
                            sup15 = '';


                            alert('licence valider avec succes');

                        }
                    });


                });
            }
            /********************************2 semaines****************************/
            if (temps == '2 semaines') {
                t2sm = '';
                $.post("Controller/droit/calcule.php", {
                    temps: temps,
                    t2sm: t2sm
                }, function(calcul) {

                    swal.fire({
                        title: 'êtes-vous sûr !',
                        html: " D'ajouter <b>" + temps + "</b> a la licence",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui'
                    }).then((result) => {
                        if (result.value) {
                            sup2sm = '';
                            alert('licence valider avec succes');
                        }
                    });


                });
            }
            /*********************************1 an*****************************************/
            if (temps == '1 an') {
                t1n = '';
                $.post("Controller/droit/calcule.php", {
                    temps: temps,
                    t1n: t1n
                }, function(calcul) {

                    swal.fire({
                        title: 'êtes-vous sûr !',
                        html: " D'ajouter <b>" + temps + "</b> a la licence",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui'
                    }).then((result) => {
                        if (result.value) {
                            sup1n = '';
                            alert('licence valider avec succes');

                        }
                    });


                });
            }
            /*******************************2 ans*************************************/
            if (temps == '2 ans') {
                t2n = '';
                $.post("Controller/droit/calcule.php", {
                    temps: temps,
                    t2n: t2n
                }, function(calcul) {

                    swal.fire({
                        title: 'êtes-vous sûr !',
                        html: " D'ajouter <b>" + temps + "</b> a la licence",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui'
                    }).then((result) => {
                        if (result.value) {
                            sup2n = '';
                            alert('licence valider avec succes');

                        }
                    });


                });
            }
            /******************************3 ans***********************************/
            if (temps == '3 ans') {
                t3n = '';
                $.post("Controller/droit/calcule.php", {
                    temps: temps,
                    t3n: t3n
                }, function(calcul) {

                    swal.fire({
                        title: 'êtes-vous sûr !',
                        html: " D'ajouter <b>" + temps + "</b> a la licence",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui'
                    }).then((result) => {
                        if (result.value) {
                            sup3n = '';
                            alert('licence valider avec succes');

                        }
                    });


                });
            }
            /**************************************************************************/
            if (temps == '') {
                /*alert("vous n'avez rien selectionner");*/
            }

        });

        /***************************************tours************************************************/

        $("#user").dblclick(function() {
            $("#page").dblclick(function() {
                $("#selection").show();
                $("#select").hide();

                $(".rase").show();


                $("#selections").change(function() {

                    temps = this.value;
                    /*********************************5 minutes**************************************/
                    if (temps == '5 minutes') {
                        t5 = '';
                        $.post("Controller/droit/calcule.php", {
                            temps: temps,
                            t5: t5
                        }, function(calcul) {

                            swal.fire({
                                title: 'êtes-vous sûr !',
                                html: " D'ajouter <b>" + temps +
                                    "</b> a la licence",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui'
                            }).then((result) => {
                                if (result.value) {
                                    sup5 = '';
                                    $.post("Controller/droit/calcule.php", {
                                        calcul: calcul,
                                        sup5: sup5
                                    }, function(data) {

                                        window.location =
                                            "Controller/droit/logout.php";

                                    });
                                    return false;

                                }
                            });


                        });
                    }
                    /**************************************10 minutes*************************************/
                    if (temps == '10 minutes') {
                        t10 = '';
                        $.post("Controller/droit/calcule.php", {
                            temps: temps,
                            t10: t10
                        }, function(calcul) {


                            swal.fire({
                                title: 'êtes-vous sûr !',
                                html: " D'ajouter <b>" + temps +
                                    "</b> a la licence",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui'
                            }).then((result) => {
                                if (result.value) {
                                    sup10 = '';
                                    $.post("Controller/droit/calcule.php", {
                                        calcul: calcul,
                                        sup10: sup10
                                    }, function(data) {

                                        window.location =
                                            "Controller/droit/logout.php";

                                    });
                                    return false;

                                }
                            });


                        });
                    }
                    /********************************15 minutes***********************************/
                    if (temps == '15 minutes') {
                        t15 = '';
                        $.post("Controller/droit/calcule.php", {
                            temps: temps,
                            t15: t15
                        }, function(calcul) {

                            swal.fire({
                                title: 'êtes-vous sûr !',
                                html: " D'ajouter <b>" + temps +
                                    "</b> a la licence",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui'
                            }).then((result) => {
                                if (result.value) {
                                    sup15 = '';
                                    $.post("Controller/droit/calcule.php", {
                                        calcul: calcul,
                                        sup15: sup15
                                    }, function(data) {

                                        window.location =
                                            "Controller/droit/logout.php";

                                    });
                                    return false;

                                }
                            });


                        });
                    }
                    /********************************2 semaines****************************/
                    if (temps == '2 semaines') {
                        t2sm = '';
                        $.post("Controller/droit/calcule.php", {
                            temps: temps,
                            t2sm: t2sm
                        }, function(calcul) {

                            swal.fire({
                                title: 'êtes-vous sûr !',
                                html: " D'ajouter <b>" + temps +
                                    "</b> a la licence",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui'
                            }).then((result) => {
                                if (result.value) {
                                    sup2sm = '';
                                    $.post("Controller/droit/calcule.php", {
                                        calcul: calcul,
                                        sup2sm: sup2sm
                                    }, function(data) {

                                        window.location =
                                            "Controller/droit/logout.php";

                                    });
                                    return false;

                                }
                            });


                        });
                    }
                    /*********************************1 an*****************************************/
                    if (temps == '1 an') {
                        t1n = '';
                        $.post("Controller/droit/calcule.php", {
                            temps: temps,
                            t1n: t1n
                        }, function(calcul) {

                            swal.fire({
                                title: 'êtes-vous sûr !',
                                html: " D'ajouter <b>" + temps +
                                    "</b> a la licence",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui'
                            }).then((result) => {
                                if (result.value) {
                                    sup1n = '';
                                    $.post("Controller/droit/calcule.php", {
                                        calcul: calcul,
                                        sup1n: sup1n
                                    }, function(data) {

                                        window.location =
                                            "Controller/droit/logout.php";

                                    });
                                    return false;

                                }
                            });


                        });
                    }
                    /*******************************2 ans*************************************/
                    if (temps == '2 ans') {
                        t2n = '';
                        $.post("Controller/droit/calcule.php", {
                            temps: temps,
                            t2n: t2n
                        }, function(calcul) {

                            swal.fire({
                                title: 'êtes-vous sûr !',
                                html: " D'ajouter <b>" + temps +
                                    "</b> a la licence",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui'
                            }).then((result) => {
                                if (result.value) {
                                    sup2n = '';
                                    $.post("Controller/droit/calcule.php", {
                                        calcul: calcul,
                                        sup2n: sup2n
                                    }, function(data) {

                                        window.location =
                                            "Controller/droit/logout.php";

                                    });
                                    return false;

                                }
                            });


                        });
                    }
                    /******************************3 ans***********************************/
                    if (temps == '3 ans') {
                        t3n = '';
                        $.post("Controller/droit/calcule.php", {
                            temps: temps,
                            t3n: t3n
                        }, function(calcul) {

                            swal.fire({
                                title: 'êtes-vous sûr !',
                                html: " D'ajouter <b>" + temps +
                                    "</b> a la licence",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui'
                            }).then((result) => {
                                if (result.value) {
                                    sup3n = '';
                                    $.post("Controller/droit/calcule.php", {
                                        calcul: calcul,
                                        sup3n: sup3n
                                    }, function(data) {

                                        window.location =
                                            "Controller/droit/logout.php";

                                    });
                                    return false;

                                }
                            });


                        });
                    }
                    /**************************************************************************/
                    if (temps == '') {
                        /*alert("vous n'avez rien selectionner");*/
                    }

                });
            });

        });



    });
    </script>
</body>

</html>