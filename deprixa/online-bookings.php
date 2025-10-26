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
	<title>CARGO v10.1 | ONLINE BOOKINGS </title>
	
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
							
							<table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
							 <style> .Approved {background: #00D96D;} .Delivered {background: #363C56;} .Pending { background: #FF5D48; } .label{padding: 6px;} .Cancelled{   background: #D9534F;} </style>
                                <thead align="center">
                                    <tr>
										<th> # Trancking</th>
                                        <th> Booking Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Booking Status</th>
										<th>Action</th>
                                    </tr>
                                </thead>
								  
                                <tbody>
								<?php  					
									$result3 = mysql_query("SELECT * FROM online_booking order by status");
									while($row = mysql_fetch_array($result3)) {					
								?>
                                    <tr>
									 <td><?php echo $row ["tracking"]; ?></td>
                                      <td><?php echo $row ["booking_date"]; ?></td>
									  <td><?php echo $row ["sstate"]; ?>,<?php echo $row ["scountry"]; ?></td>
									  <td><?php echo $row ["dstate"]; ?>,<?php echo $row ["dcountry"]; ?></td>
									  <td><?php echo $row ["name"]; ?></td>
									  <td><?php echo $row ["email"]; ?></td>
									  <td align="center"><span class="label <?php echo $row ["status"]; ?> label-large"> <?php echo $row ["status"]; ?></span>
									  </br> <?php echo $row ["reasons"]; ?></td>								  
									  <td align="center">
									  <?php if($row ["status"] !='Cancelled' AND $row ["status"] !='Approved'){?>
									  <a href="approve.php?id=<?php echo $row ["id"]; ?>">
									  <img src="images/update.png" border="0" height="20" width="20"></a>
									  <?php } ?>
									  
									    <?php
											if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
										?>
									  &nbsp;&nbsp;  
									   <a href="#" onclick="del_list_online(<?php echo $row['id']; ?>);">
									   <img src="images/delete.png" border="0" height="20" width="18"></a>	
										<?php } ?>															  																  
									  </td>
                                    </tr>
								<?php } ?>	
                                </tbody>								
                            </table>
							  
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

		<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/tether.min.js"></script><!-- Tether for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').DataTable();

                //Buttons examples
                var table = $('#datatable-buttons').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                });

                table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            } );

        </script>
		<script type="text/javascript">
			function del_list_online(id) {
				if (window.confirm("Aviso:\n Sure you want to delete the selected  file?")) {
					window.location = "deletes/delete-online-bookings.php?action=del&id="+id;  
				}
			}
		</script>
	
	<!-- App js -->
	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>


</body>
</html>
