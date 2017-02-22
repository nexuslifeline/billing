
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from avenxo.kaijuthemes.com/ui-typography.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2016 12:09:25 GMT -->
<head>
    <meta charset="utf-8">
    <title>JCORE - <?php echo $title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">


    <link type="text/css" href="assets/css/bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/css/animate.css" rel="stylesheet">
    <link type="text/css" href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link type="text/css" href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">        <!-- Font Awesome -->
    <link type="text/css" href="assets/fonts/themify-icons/themify-icons.css" rel="stylesheet">              <!-- Themify Icons -->
    <link type="text/css" href="assets/css/styles.css" rel="stylesheet">                                     <!-- Core CSS with all styles -->

    <link type="text/css" href="assets/plugins/codeprettifier/prettify.css" rel="stylesheet">                <!-- Code Prettifier -->

    <link href="assets/plugins/notify/pnotify.core.css" rel="stylesheet"> <!-- notification -->

    <link rel="stylesheet" href="assets/plugins/pace/themes/blue/pace-theme-loading-bar.css" /><!-- progress bar -->


    <style>
        table.custom-design{
            width: 100%;
        }

        table.custom-design > tbody > tr > td{
            border:1px solid #acb8b1;
            padding: 7px;
        }

        table.custom-design > thead > tr > th{
            border:1px solid #acb8b1;
            padding: 7px;

        }

        table.custom-design > tfoot > tr > td{
            border:1px solid #acb8b1;
            padding: 7px;

        }

        .custom-design-header{
            background-color: #4f9f63;
        }

    </style>

    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/datatables/dataTables.themify.css" rel="stylesheet">

    <link type="text/css" href="assets/plugins/zTree/zTreeStyle.css" rel="stylesheet">

    <style>
        html{
            zoom: 0.85;
            zoom: 85%;
        }

        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        .select2-container{
            min-width: 100%;
        }


        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .zTreeDemoBackground {
            overflow: auto;
        }

        div.zTreeDemoBackground {width:100%;height:500px;text-align:left;margin: 2%;overflow: hidden;border: 0px solid white;}

        ul.ztree {margin-top: 10px;background: white;width:100%;height:100%;}
        ul.ztree li span{font-size: 11pt;}
        ul.log {border: 1px solid #617775;background: #f0f6e4;width:300px;height:100%;overflow: hidden;}
        ul.log.small {height:45px;}
        ul.log li {color: #666666;list-style: none;padding-left: 10px;}
        ul.log li.dark {background-color: #E3E3E3;}



    </style>
</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">
        <?php echo $_side_bar_navigation;?>



        <div class="static-content-wrapper white-bg">


            <div class="static-content"  >
                <div class="page-content"><!-- #page-content -->

                    <ol class="breadcrumb" style="margin:0;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="Accomplishments">Process Accomplishments</a></li>
                    </ol>
                    <div class="container-fluid">
                        <div data-widget-group="group1">

                            <div class="row">

                                <div class="col-md-12">
                                    <div id="div_chart_list">
                                        <div class="panel panel-default" style="border-top: 3px solid #2196f3;">

                                            <a data-toggle="collapse" data-parent="#accordionA" href="#collapseTwo"><div class="panel-heading" style="background: #2ecc71;border-bottom: 1px solid lightgrey;"><b style="color: white; font-size: 12pt;"><i class="fa fa-bars"></i> Accomplishments</b></div></a>

                                            <div class="row">

                                                <div class="col-xs-12 col-lg-2">
                                                    <div class="zTreeDemoBackground" style="margin-left: 10px;margin-top: 10px;margin-bottom: 20px;border: 0px solid black;">
                                                        <ul id="treeDemo" class="ztree"></ul>
                                                    </div>
                                                </div>


                                                <div class="col-xs-12 col-lg-10">
                                                    <div class="panel-body table-responsive" style="padding-left: 1px!important;">
                                                        <div style="border:1px solid gray;padding: 1%;">
                                                            <span style="font-size: 14pt;">Accomplishments as of <b id="lbl_date">February 2017</b></span><span style="font-size: 9pt;"> (Please tick mark all accomplished services on <b>Completed Column</b>.)</span><hr />

                                                            <table id="tbl_customers" class="custom-design table-striped" cellspacing="0" width="100%">
                                                                <thead class="">
                                                                <tr>
                                                                    <th>&nbsp;&nbsp;</th>
                                                                    <th>Code</th>
                                                                    <th>Company / Client</th>
                                                                    <th>Trade Name</th>
                                                                    <th>Office Address</th>
                                                                    <th>Contact No</th>
                                                                    <th>Contact Person</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="panel-footer"></div> -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> <!-- .container-fluid -->

                </div> <!-- #page-content -->
            </div>


            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content"><!---content--->
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>

                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div><!---content---->
                </div>
            </div><!---modal-->




            <footer role="contentinfo">
                <div class="clearfix">
                    <ul class="list-unstyled list-inline pull-left">
                        <li><h6 style="margin: 0;">&copy; 2016 - Paul Christian Rueda</h6></li>
                    </ul>
                    <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                </div>
            </footer>




        </div>
    </div>


</div>


<?php echo $_switcher_settings; ?>
<?php echo $_def_js_files; ?>

<script src="assets/plugins/spinner/dist/spin.min.js"></script>
<script src="assets/plugins/spinner/dist/ladda.min.js"></script>


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


<!-- touchspin -->
<script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>


<script type="text/javascript" src="assets/plugins/zTree/jquery.ztree.core.js"></script>


<script>
    $(document).ready(function(){
        var dt; var _txnMode; var _selectedID; var _selectRowObj; var _cboClasses; var _cboParentAccounts; var zNodes; var setting; var _cboTypes;


        var reInitializeTreeView=function(){
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        };



        var initializeControls=function(){

            dt= $('#tbl_customers').DataTable({
                "dom": '<"toolbar">frtip',
                "bLengthChange":false,
                "language": {
                    "searchPlaceholder": "Search Customer"
                },
                "ajax" : "Accomplishments/transaction/list",
                "columns": [
                    {
                        "targets": [0],
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { targets:[1],data: "customer_code" },
                    { targets:[2],data: "company_name" },
                    { targets:[3],data: "trade_name" },
                    { targets:[4],data: "office_address" },
                    { targets:[5],data: "contact_no" },
                    { targets:[6],data: "contact_person" }

                ]
            });

            var createToolBarButton=function() {
                var _btnNew='<button class="btn btn-primary"  id="btn_refresh" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;" data-toggle="modal" data-target="" data-placement="left" title="Refresh" >'+
                    '<i class="fa fa-refresh"></i> Reload </button>';


                $("div.toolbar").html(_btnNew);
            }();


            //**************************************************************************************************************
            setting= {
                view: {

                    addDiyDom: addDiyDom
                },
                data: {
                    key: {
                        title: "title"
                    },
                    simpleData: {
                        enable: true
                    }
                },
                callback: {
                    onClick:function(){

                    }
                }

                };


            zNodes=[

                <?php foreach($years as $year){ ?>
                    {"id":"<?php echo $year; ?>","pId":"","name":"<?php echo $year; ?><?php echo ($year==date("Y")?"(Current Year)":""); ?>","title":"<?php echo $year; ?>","open":"<?php echo ($year==date("Y")?"true":false); ?>","icon":"assets\/plugins\/zTree\/img\/diy\/4.png"},
                    <?php foreach($months as $month){ ?>
                            {"id":"<?php echo $year; ?>-<?php echo $month; ?>","pId":"<?php echo $year; ?>","name":"<?php echo $month; ?>","title":"<?php echo $month; ?>","open":"<?php echo ($year==date("Y")?"true":false); ?>","icon":"assets\/plugins\/zTree\/img\/diy\/11.png"},
                    <?php } ?>
                <?php } ?>




            ];

            reInitializeTreeView();






        }();






        var bindEventHandlers=(function(){
            var detailRows = [];

            $('#tbl_customers tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );
                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();
                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    var d=row.data();
                    $.ajax({
                        "dataType":"html",
                        "type":"POST",
                        "url":"Accomplishments/transaction/expand-view?id="+ d.customer_id,
                        "beforeSend" : function(){
                            row.child( '<center><br /><img src="assets/img/loader/ajax-loader-lg.gif" /><br /><br /></center>' ).show();
                        }
                    }).done(function(response){
                        row.child( response ).show();
                        reInitializeServiceDataTable($('#tbl_services_'+ d.customer_id));

                        if ( idx === -1 ) {
                            detailRows.push( tr.attr('id') );
                        }
                    });
                }
            });



            $('.zTreeDemoBackground').on('click','ul.ztree li span',function(){
                var sMonth=$(this).closest('li').text();
                var sYear=$(this).closest('ul').closest('li').find('a').attr('title');
                $('#lbl_date').html(sMonth+" "+sYear);
            });




        })();


        var showNotification=function(obj){
            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title:  obj.title,
                text:  obj.msg,
                type:  obj.stat
            });
        };

        function addDiyDom(treeId, treeNode) {
            var aObj = $("#" + treeNode.tId);

            if(!isNaN(treeNode.id)){

                //aObj.closest('a').text("Test");


            }
        };

        var reInitializeServiceDataTable=function(tbl){
            var dtService;
            dtService=tbl.DataTable({
                "bLengthChange":false,
                "language": {
                    "searchPlaceholder": "Search Services"
                },
                "pageLength":8
            });

            tbl.on('click','a#link_accomplished',function(){
                alert("dd");
            });
        };




    });




</script>


</body>


</html>