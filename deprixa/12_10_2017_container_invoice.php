<?php
// *************************************************************************
// *                                                                       *
// * CARGO v10.0 -  logistics Worldwide Software                           *
// * Copyright (c) CNSWARE INC. All Rights Reserved                        *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: INFO@CNSWARE.COM                                               *
// * Website: http://www.cnsware.com                                       *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.                              *
// *                                                                       *
// *                                                                       *
// *                                                                       *
// *************************************************************************

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once('database.php');
require_once('library.php');
isUser();

if (isset($_POST['reset'])) {
     $getdata = "";
}
if (isset($_POST['submit'])) {
    

    $getdata = $_POST['container_num'];

    //$rs = " SELECT c.cid,c.ship_name,c.rev_name, co.container_number FROM `courier` c LEFT JOIN `courier_container` co ON (c.container_id = co.container_id)  where c.cid > 0 ";
    if (!empty($getdata)) {
        $rs = " SELECT cid,ship_name,rev_name, container_number FROM `courier` WHERE container_id='$getdata' ";
    } else {
        $rs = " SELECT cid,ship_name,rev_name, container_number FROM `courier` ";
    }
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Page Description and Author -->
        <meta name="description" content="Cargo V10.1"/>
        <meta name="keywords" content="Cargo Web System" />
        <meta name="author" content="CNSWARE INC">

        <!-- App Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App title -->
        <title>CARGO v10.1 | Container Invoice  </title>

        <!-- Switchery css -->
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- App CSS -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/animate.css/animate.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css" type="text/css" />
        <link rel="stylesheet" href="bower_components/simple-line-icons/css/simple-line-icons.css" type="text/css" />
        <link rel="stylesheet" href="css/footer-basic-centered.css">

    </head>
    <body>
        <?php include("header.php"); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <?php
                include("icon_settings.php");
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">                            
                            <h4 class="header-title m-t-0 m-b-20"> Container Invoice </h4>

                            <!-- =========================my Code========================= -->



                            <!-- ========================= End my Code========================= -->
                            <form  name="formulario" method="post" id="formulario" >

                                <div class="row" >

                                    <div class="col-sm-3 form-group">                                      
                                        <select name="container_num" id="container_num" class="form-control">
                                            <option value="" >Select All</option>
                                            <?php
                                            $co_num = mysql_query("SELECT * FROM `courier_container` ORDER BY `container_number` ASC ");
                                            while ($row = mysql_fetch_array($co_num)) {
                                                  $selected = "";
                                                if ($row['container_id'] == $getdata) {
                                                    $selected = 'selected = "selected"';
                                                }
                                                ?>
                                                <option value="<?php echo $row['container_id']; ?>" <?php echo $selected ?> ><?php echo $row['container_number']; ?></option>                                              
                                            <?php } ?>
                                        </select>
                                    </div>                                    
                                
                                        <input type="submit" class="btn btn-md btn-info" value="Search" name="submit"  id="submit">
                                  
                                        <span style="margin-left: 10px;"><input type="submit" name="reset" class="btn btn-md btn-secondary" value="Reset"></span>
                                  

                                </div>
                                <!-- -------------------------------       ----------------------------------- -->
                            </form>  

                            <form  action="print-invoice/invoice-print-old.php" name="formulario" method="post" id="formulario" target="_blank">                                                                                

                                <input type="submit" name="submit" id="check1" onclick="return checkdata();" class="btn btn-md print-btn btn-secondary" value="Print Invoice"> 

                                <br><br>   
                                <table border='1 solid #ddd;' width="100%">   

                                    <thead>
                                        <tr>
                                            <th style="height: 30px; width:110px;padding: 6px;">  &nbsp;&nbsp;<input type="checkbox" name="pinvoice" onchange="checkAll(this)" >&nbsp;&nbsp;SELECT</th>
                                            <th style="padding: 10px;">Order Id</th>
                                            <th style="padding: 10px;">Container Number</th>
                                            <th style="padding: 10px;">Sender Name</th>
                                            <th style="padding: 10px;">Receiver Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $getresult = mysql_query($rs);
                                        if ($getresult) {
                                            while ($row = mysql_fetch_array($getresult)) {
                                                ?>
                                                <tr>                                            
                                                    <td style="padding: 10px;"><input type="checkbox" name="pinvoice[]" id="pinvoice" value="<?php echo $row['cid']; ?>">&nbsp;&nbsp;SELECT</td>
                                                    <td style="padding: 6px;"><?php echo $row['cid']; ?></td>
                                                    <td style="padding: 6px;"><?php echo $row['container_number']; ?></td>
                                                    <td style="padding: 6px;"><?php echo $row['ship_name']; ?></td>  
                                                    <td style="padding: 6px;"><?php echo $row['rev_name']; ?></td>
                                                </tr>
                                            <?php }
                                        }
                                        ?>
                                    </tbody>
                                </table>  
                            </form>             
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <!-- Footer -->
                <?php
                include("footer.php");
                ?>
                <!-- End Footer -->

            </div> <!-- container -->
        </div> <!-- End wrapper -->



        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/tether.min.js"></script><!-- Tether for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <!-- Required datatable js -->
<!--        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
         Buttons examples 
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
         Responsive examples 
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>-->

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script type="text/javascript">
                                               
                                                    function checkAll(ele) {
                                                        var checkboxes = document.getElementsByTagName('input');
                                                        if (ele.checked) {
                                                            for (var i = 0; i < checkboxes.length; i++) {
                                                                if (checkboxes[i].type == 'checkbox') {
                                                                    checkboxes[i].checked = true;
                                                                }
                                                            }
                                                        } else {
                                                            for (var i = 0; i < checkboxes.length; i++) {
                                                                console.log(i)
                                                                if (checkboxes[i].type == 'checkbox') {
                                                                    checkboxes[i].checked = false;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    function checkdata() {
                                                        var inputElems = document.getElementsByTagName("input"),
                                                                count = 0;
                                                        for (var i = 0; i < inputElems.length; i++) {
                                                            if (inputElems[i].type === "checkbox" && inputElems[i].checked === true) {
                                                                count++;
                                                                return true;
                                                            }
                                                        }
                                                        alert('Please select atleast one Inovice checkbox.');
                                                        return false;
                                                    }
                                                    
                                                

        </script>

        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="js/myjava.js"></script>
        <script src="js/payments_list.js"></script>
        <style>
            .button4 {background-color: #e7e7e7; color: black;} /* Gray */ 
            a.btn.btn-md.print-btn.btn-secondary {
                position: absolute;
                z-index: 9;
            }           
        </style>      
    </body>
</html>