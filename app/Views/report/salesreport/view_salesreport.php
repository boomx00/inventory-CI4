<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />
<br><br><br>
<main class="flex-shrink-0">
    <div class="row" >
    <div class="col-sm-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Select Period</h5>
      <form>

      <div class="form-group row">
    <label for="inputEmail3" class="col-sm-1 col-form-label">Period:</label>
    <div class="col-sm-2">
      <input type="date" class="form-control" id="date1" > 
    </div>
S/D
    <div class="col-sm-2">
      <input type="date" class="form-control" id="date2" style="align:left">
    </div>
  </div>


<br>
<button type="button" class="btn btn-primary" onclick="getdata()">Submit</button>

      </form>
      </div>
      </div>
    </div>

    </div>
<hr>
<div class="col-sm-11 mx-auto">
    <table class="table table-bordered">
        <thead>
            <th style="width:1%">Counter</th>
            <th style="width:2%">Date</th>
            <th style="width:2%">Order ID</th>
            <th style="width:2%">Status</th>
            <th style="width:10%">Detail</th>
            <th style="width:2%">Paid</th>
            <th style="width:2%">Unpaid</th>
            <th style="width:2%">Total</th>

        </thead>
        <tbody id="maintable">


        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th> </th>
                <th></th>
                <th>Total:</th>
                <th><div id="total"></div></th>
            </tr>
        </tfoot>
    </table>

</div>
</main>
<script>
  $('#mydatatable').DataTable();
</script>
<script>
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd ;
todaystring = yyyy + mm  + dd ;
document.getElementById("date1").value = today;

function getdata(){
    var from = document.getElementById("date1").value;
    var to = document.getElementById("date2").value;
    var blank = "";

    if(to == ""){
        $.ajax({
      url : "<?php echo base_url("salesreport/getsales/"); ?>",
                  type: "GET",
                  data: {from: from, to:to },
                  success: function(data)
                  {
                    var str=data;
                 var res=str.split('!');
                  document.getElementById("maintable").innerHTML = res[0];
                  document.getElementById("total").innerHTML = res[1];

      }
                })    
                }

    else if(to>from){
        $.ajax({
      url : "<?php echo base_url("salesreport/getsales/"); ?>",
                  type: "GET",
                  data: {from: from,to:to},
                  success: function(data)
                  {
                    var str=data;
                 var res=str.split('!');
                  document.getElementById("maintable").innerHTML = res[0];
                  document.getElementById("total").innerHTML = res[1];

      }
                })    
    }else{
        alert("invalid date inputs");
    }
}

</script>

</main>
<?= $this->endSection('content') ?>
