<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/icons/admin/bdlogo.png')}}" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('project/common/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('project/common/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/ionicons.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('project/backend/css/jquery-ui.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{ asset('project/backend/css/_all-skins.min.css')}}">
  <!-- sweet alert style -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/sweetalert.css')}}">
  <!-- select 2 style -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/select2.min.css')}}">
  <!-- Custome style -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/style.css')}}">
  <!-- Step css style -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/jquery.steps.css')}}">
  <!-- Calculator css style -->
  <link rel="stylesheet" href="{{ asset('project/backend/css/jquery.calculator.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ route('dashbord')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>DB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Dashboard</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    @include('backend.layout.top_menu')
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      @include('backend.layout.left_menu')
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  @include('backend/layout/footer')
  <!-- Control Sidebar -->
  @include('backend/layout/control_sidebar')
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@section('footer_js_scrip_area')
<script src="{{ asset('project/common/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('project/common/js/bootstrap.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ asset('project/backend/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('project/backend/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('project/backend/js/jquery-ui.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('project/backend/js/adminlte.min.js')}}"></script>
<!--select 2 js-->
<script src="{{ asset('project/backend/js/select2.full.min.js')}}"></script>
<!--select 2 js-->
<script src="{{ asset('project/backend/js/sweetalert.min.js')}}"></script>

<script src="{{ asset('project/backend/js/commonjs.js')}}"></script>
<!--step js-->
<script src="{{ asset('project/backend/js/jquery.steps.min.js')}}"></script>
<!--calculator js-->
<script src="{{ asset('project/backend/js/jquery.plugin.js')}}"></script>
<script src="{{ asset('project/backend/js/jquery.calculator.js')}}"></script>
<script src="{{ asset('js/pdfobject.min.js')}}"></script>
<script>
    function viewTheDocFile(fileName) {
        $('#pdf_viwer_section').show();
        var options = {
            height: "400px",
            pdfOpenParams: { view: 'Fit', page: '2' }
        };
        PDFObject.embed(fileName, "#example1",options);
    }
    function hide_pdf_viewer(){
        $('#pdf_viwer_section').hide();
    }
</script>
<script>
  $(function () {
    $('#example2').dataTable( {
        "searching": false
      } );    
    $('#permission').select2();
    $('#roles').select2();
  })
    function common_delete(id, table_name){
        swal({
            title: "Are you sure,want to delete this?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Confirm",
            closeOnConfirm: false
          },
          function(){   
            $.ajax({
                url:'{{url("admin/dashbord/common_delete")}}',
                type:'get',
                dataType:'json',
                data:'id='+id+'&table='+table_name,
                success: function(response){
                    $('.alert').hide();
                    $('.json_alert_message').hide();
                    if(response.status=='success'){
                        swal.close();
                        $('tr#data_entry_id_'+id).remove();
                        $('#success_message').show();
                        $('#success_message > span').html(response.message);
                    }else{
                        swal("Cancelled", response.message, "error");
                    }
                    //example2
                    var dataTable = $('#example2').DataTable();
                    location.reload();
                }
            });
          });
    }
    
    function onPageEditData(id, table_name){
        $.ajax({
            url:'{{url("admin/dashbord/on_page_edit_data")}}',
            type:'get',
            dataType:'json',
            data:'id='+id+'&table='+table_name,
            success: function(response){
                if(response.status == "success"){
                    if(table_name == "project_fas"){
                        $("#submit_button").val("Update");
                        $("#pfa_update_id").val(id);
                        $("#fa_country").val(response.data.fa_country);
                        $("#fa_donor").val(response.data.fa_donor);
                        $("#fa_mof").val(response.data.fa_mof);
                        $("#fa_amount").val(response.data.fa_amount);
                    }else if(table_name == "projectlocations"){                        
                        if(response.data.district_id){
                        $.ajax({
                            url:'{{url("admin/dashbord/getDivisionByDistrict")}}',
                            type:'get',
                            dataType:'json',
                            data:'district_id='+response.data.district_id,
                            success: function(divisionResponse){
                                var division_id = divisionResponse.data.id
                                $("#div_id").val(division_id);
                                if (division_id) {
                                    disableOtherLocationInput(1);
                                    //location_type_div
                                    $("#location_type_div").prop("checked", true);
                                    $("#location_type_city").prop("checked", false);
                                    $.ajax({
                                        url: '{{url("admin/dashbord/loadDivisionByDistrict")}}',
                                        type: "get",
                                        dataType: "JSON",
                                        data: "division_id=" + division_id,
                                        success: function (dis_response) {
                                            $("#district_id").html(dis_response);
                                            $("#district_id").val(response.data.district_id);
                                            if(response.data.district_id){    
                                                $.ajax({
                                                        url         :'{{url("admin/dashbord/loadUpazilaByDistrict")}}',
                                                        type        :"get",
                                                        dataType    :"JSON",
                                                        data        :"district_id="+response.data.district_id,
                                                        success     :function(upzresponse){
                                                            $("#upz_id").html(upzresponse);
                                                            $("#upz_id").val(response.data.upz_id);
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }else{
                            disableOtherLocationInput(2);
                            $("#location_type_div").prop("checked", false);
                            $("#location_type_city").prop("checked", true);
                        }
                        
                        $("#pla_update_id").val(id);                        
                        $("#roadno").val(response.data.roadno);                        
                        $("#constituency").val(response.data.constituency);                        
                        $("#ward_id").val(response.data.ward_id);                        
                        $("#city_corp_id").val(response.data.city_corp_id);                        
                        $("#union_id").val(response.data.union_id);                        
                        $("#gisobject_id").val(response.data.gisobject_id);
                        $("#loc_x").val(response.data.loc_x);
                        $("#loc_y").val(response.data.loc_y);
                        $("#estmcost").val(response.data.estmcost);
                    }else if(table_name=="projectagencies"){
                        if(response.data.lead_agency){
                            $('#lead_agency').prop('checked', true);
                            $('#lead_agency').prop('disabled', true);
                            //lead_agency_edit_id
                            $("#lead_agency_edit_id").val(1);
                        }else{
                            $('#lead_agency').prop('checked', false);
                            $('#lead_agency').prop('disabled', false);
                        }
                        //agency_id
                        $("#agency_id").val(response.data.agency_id);  
                        $("#agency_edit_id").val(response.data.id);  
                    }
                }
            }
        });
    }
    
    function disableOtherLocationInput(locationType){
            if(locationType == 1){
                //--------------------all disable area--------------------------
                $('#city_corp_id option[value=""]').attr("selected",true);
                $('#city_corp_id').prop('disabled', 'disabled');
                
                $('#ward_id option[value=""]').attr("selected",true);
                $('#ward_id').prop('disabled', 'disabled');
                
                $("#roadno").val("");
                $("#roadno").prop('disabled', true);
                //--------------------------------------------------------------
                
                //---------------------all enable area--------------------------
                $('#div_id').prop('disabled', false);                
                $('#district_id').prop('disabled', false);                
                $('#upz_id').prop('disabled', false);                
                $("#area").prop('disabled', false);
                //--------------------------------------------------------------
            }
            
            if(locationType == 2){
               
                //---------------------all enable area--------------------------
                $('#city_corp_id').prop('disabled', false);                
                $('#ward_id').prop('disabled', false);                
                $("#roadno").prop('disabled', false);
                //--------------------------------------------------------------
                
                //--------------------all disable area--------------------------
                $('#div_id option[value=""]').attr("selected",true);
                $('#div_id').prop('disabled', 'disabled');
                
                $('#district_id option[value=""]').attr("selected",true);
                $('#district_id').prop('disabled', 'disabled');
                
                $('#upz_id option[value=""]').attr("selected",true);
                $('#upz_id').prop('disabled', 'disabled');
                
                $("#area").val("");
                $("#area").prop('disabled', true);
                //--------------------------------------------------------------
            }
        }
    
    function nextPageConfirmation(urlAddress, text){
        swal({
            title: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: 'No',
            closeOnConfirm: false
          },
          function(){ 
            window.location = urlAddress;
          });
    }
    
    function searchFilterData(urlAddress, formId, tableSelector){
        $.ajax({
                url:urlAddress,
                type:'POST',
                dataType:'json',
                data:$("#"+formId).serialize(),
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response){
                    $(".json_alert_message").hide();
                    if(response.status=='success'){
                        $(".box-body").empty();
                        $(".box-body").append(response.data);
                        $('#'+tableSelector).DataTable({"searching": false});
                    }else{
                        $("#info_message").show();
                        $("#info_message").html(response.message);
                        $(".box-body").empty();
                        $(".box-body").append(response.data);
                        $('#'+tableSelector).DataTable({"searching": false});
                    }
                }
            });
    }
</script>

@show 
</body>
</html>
