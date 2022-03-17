<?= $this->extend('Views/layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />

<script>
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';  
  </script>
<br><br><br>

<main class="flex-shrink-0">
<input type="hidden" id="selected" value="">
<div class="row" style="width:98%;margin:0 auto">
<div class="col-md-7">
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
  <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true">All</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false" onclick="navfunction('L')">Lunas</a>
  </div>
</nav> <br>
<div class="tab-content" id="nav-tabContent">
<div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
<table id="mydatatable3" class="table table-paginate table-bordered">
        <thead>
            <th>No</th>
            <th>Order ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Transaksi</th>

            <th>Total Transaction</th>
            <th>Total Paid</th>
            <th>Total Unpaid</th>

        </thead>
        <tbody id="mainbonhutang">
        <?php
        $count = 0;

        $countttt = 0;
            foreach($all as $x){
                $count ++;
                $countttt ++;

          ?>
            <tr onclick="button(0);anotherfunc(<?=$count?>);test(<?=$count?>)" value="0" id="tr<?=$count?>">    
                <td><?= $countttt ?></td>
                <td id="orderid<?=$count?>"><?= $x->order_id ?></td>
                <td><?= $x->date ?></td>
                <td id="supplier<?=$count?>"><?= $x->customer ?></td>
                <td id="status<?=$count?>"><?= $x->status ?></td>
                <td id="transaction<?=$count?>"><?= $x->transaction ?></td>

                <td id="total<?=$count?>"><?= $x->total ?></td>
                <td id="paid<?=$count?>"><?= $x->paid ?></td>
                <td id="unpaid<?=$count?>"><?= $x->unpaid ?></td>
            </tr>
        <?php
            }
        ?>

        </tbody>

   </table>



</div>










<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
<table id="mydatatable2" class="table table-paginate table-bordered">
        <thead>
        <th>No</th>
            <th>Order ID</th>
            <th>Date</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Transaksi</th>

            <th>Total Transaction</th>
            <th>Total Paid</th>
            <th>Total Unpaid</th>

        </thead>
        <tbody id="lunastable">
       

        </tbody>

   </table>

</div>


</div>
</div>


<div class="col-md-5">
<h3>Detail Angsuran</h3>
<hr>
<div class="row">
<div class="col-sm-6">
<div class="mb-1">
            <div class="form-group row">
                <label for="total" class="col-sm-4 col-form-label">Total</label>

                <div class="col-sm-6">
                 <input type="text" class="form-control" id="total" name="total" readonly>
                </div>
            </div>
        </div>
        <div class="mb-1">
            <div class="form-group row">
                <label for="paid" class="col-sm-4 col-form-label">Paid</label>

                <div class="col-sm-6">
                 <input type="text" class="form-control" id="paid" name="paid" readonly>
                </div>
            </div>
        </div>
        <div class="mb-1">
            <div class="form-group row">
                <label for="sisa" class="col-sm-4 col-form-label">Remaining</label>

                <div class="col-sm-6">
                 <input type="text" class="form-control" id="sisa" name="sisa" readonly>
                </div>
            </div>
        </div>
        </div>

<div class="col-sm-6"> 
<table class="table table-sm table-borderless" style="margin-top:-2%">
<thead>
<th style="width: 45%"></th>
<th></th>
<th style="width: 35%"></th>
</thead>
<tbody>
    <tr>
        <td>Name</td>
        <td>:</td>
        <td id="named"></td>
    </tr>
    <tr>
        <td>address</td>
        <td>:</td>
        <td id="addressd"></td>
    </tr>
    <tr>
        <td>Phone</td>
        <td>:</td>

        <td id="phoned"></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td>Total Transaction</td>
        <td>:</td>

        <td id="totall"></td>
    </tr>
    <tr>
        <td>Total Hutang</td>
        <td>:</td>

        <td id="unpaidd"></td>
    </tr>
    <tr>
        <td>Total Hutang Dibayar</td>
        <td>:</td>

        <td id="paidd"></td>
    </tr>
 
</tbody>
</table>
</div>

</div> <!--for first row-->
<div>
<table class="table table-bordered">
    <thead>
        <th style="width:1%">No</th>
        <th style="width:1%">Tanggal</th>
        <th style="width:20%">IMG</th>
        <th style="width:2%">Bayar</th>
        <th style="width:2%">Action</th>

    </thead>
            <tbody id="paytable">
              

            </tbody>
    <tfoot>
        <!-- <td colspan="4">Total</td>
        <td colspan="2">test</td> -->

    </tfoot>
</table>
</div><!--for table-->
<div class="row">
<div class="col text-center">
      <button type="button" class="btn btn-outline-secondary"  onclick="completeform(this)" value="aa" data-id="xx" id="formbutton">Secondary</button>
    </div>

</div><!--for class row-->
<br><br>
<div class="row">

</div>
</div><!--for col-sm5-->
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Complete Transaction Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="<?= base_url(); ?>/salereceivables/addtemp/ " enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <input type="hidden" class="form-control" id="paymentidhidden" name="paymentidhidden" value="">
      <input type="hidden" class="form-control" id="orderidhidden" name="orderidhidden" value="">

            <div class="row">
                <div class="col-sm-6">
                <div class="mb-4">
            <div class="form-group row">
                <label for="modaldate" class="col-sm-5 col-form-label">Date</label>

                <div class="col-sm-7">
                 <input type="text" class="form-control" id="modaldate" name="modaldate">
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="form-group row">
                <label for="amount" class="col-sm-5 col-form-label">Amount</label>

                <div class="col-sm-7">
                 <input type="text" class="form-control" id="amount" name="amount" onkeyup="keyip()">
                </div>
            </div>
        </div>

        <div class="mb-4">
            <div class="form-group row">
                <label for="modalorderid" class="col-sm-5 col-form-label">Order ID</label>

                <div class="col-sm-7">
                 <input type="text" class="form-control" id="modalorderid" name="modalorderid">
                </div>
            </div>
        </div>
                </div>

                <div class="col-sm-6">
                <div class="mb-3">
            <div class="form-group row">
                <label for="comment" class="col-sm-3 col-form-label">Detail Transaction</label>

                <div class="col-sm-9">
                <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"></textarea></pre>                </div>
            </div>

           
                </div>

                
                </div> <!--end of col sm 6-->
            </div>
            <div class="row">
            <div>
          <div class="input-field">
<!-- <label class="active">Photos</label> -->
<div class="input-images" style="padding-top: .5rem;"></div>
</div>
    </div>
                <div class="container">
  <div class="row">
   
  </div>
</div>    
            </div>
            <button type="submit" class="btn btn-primary" id="submitbutton">Create</button>

      <div class="modal-footer">
                <!-- <button type="submit" class="btn btn-primary" id="submitbutton">Create</button> -->

      </div>
      </form>
    </div>
  </div>
</div></div>
<!--edit modal-->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <iframe src="" id="myframe" width="100%" height="100%" frameborder="0" allowtransparency="true"></iframe>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closemodal()">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


</main>
<script>
$(function () {
  $('.input-images').imageUploader({

  });
});


</script>
<script>
  $('#mydatatable2').DataTable();
  $('#mydatatable3').DataTable();

</script>
<script>
var counter = 0;
setInterval(function(){
    var paymentid = document.getElementById("paymentidhidden").value;
    var orderid = document.getElementById("orderidhidden").value;

    if(counter == 0){
        
    }else{
    getdata(paymentid,orderid);
    };
    //  alert(document.getElementById("paymentidhidden").value); 
     
     
     }, 1000);

function closemodal(){

    $('#editmodal').modal('hide');

}
function testfunction(x){
    // var imagecontent = document.getElementById("imagetable"+x).innerHTML;
    // var paymentid = document.getElementById("paymentid"+x).value;
    // var amount = document.getElementById("amounttable"+x).innerHTML;
    // var date = document.getElementById("datetable"+x).innerHTML;
var orderids = document.getElementById("orderids"+x).value;
var paymentid = document.getElementById("paymentid"+x).value;

// alert(document.getElementById("orderid1").value);
document.getElementById("paymentidhidden").value = paymentid;
document.getElementById("orderidhidden").value = orderids;

    // document.getElementById("editmodaldate").value = date;
    // document.getElementById("editamount").value = amount;

    document.getElementById('myframe').src ='http://localhost:8080/salereceivables/editsalesreceivables/'+paymentid;
    // alert();
    $('#editmodal').modal('show')

    // alert(paymentid);
}




var idarray = [];
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd ;
document.getElementById("modaldate").value = today;
function completeform(objButton){
// alert(objButton.value);
document.getElementById('modalorderid').value=objButton.value;

    $('#exampleModal').modal('show')
}
function keyip(){
    document.getElementById("amount").value = document.getElementById("amount").value.replaceAll(/\D/g, "").replaceAll(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
function button(x){
    if(x==1){
        document.getElementById('formbutton').setAttribute("disabled", "true");
    }else{
        document.getElementById('formbutton').removeAttribute("disabled");

    }
}

function test(x){
   
    var tablelength2 = document.getElementById("mydatatable2").rows.length;
    var tablelength3 = document.getElementById("mydatatable3").rows.length;

    var length = tablelength2 + tablelength3;
    // alert(length);
    for (i = 1; i <= length; i++) {
        if(i == x){
            document.getElementById('tr'+i).style.cssText = "background-color: #7FFFD4";
        }else{
            if(document.getElementById('tr'+i).style.cssText == null){
            }else{
                document.getElementById('tr'+i).style.cssText = "background-color: white";

            }
        }

    }
}
document.getElementById('formbutton').setAttribute("disabled", "true");
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function anotherfunc(x){
    var orderid = document.getElementById('orderid'+x).innerHTML;
    var customer = document.getElementById('supplier'+x).innerHTML;
    document.getElementById('formbutton').value=orderid;
    document.getElementById('selected').value=x;

    var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
          orderid:orderid,
          customer: customer
          };
    $.ajax({
  url : "<?php echo base_url("salereceivables/getdata"); ?>",
              type: "GET",
                data: dataJson, 
                dataType: "json",
              success: function(data)
              {
                //   alert(data.total);
                document.getElementById('named').innerHTML = data.customer;
                document.getElementById('addressd').innerHTML = data.address;
                document.getElementById('phoned').innerHTML = data.phone;
                document.getElementById('totall').innerHTML = numberWithCommas(data.total);
                document.getElementById('paidd').innerHTML = numberWithCommas(data.paid);
                  document.getElementById('unpaidd').innerHTML = numberWithCommas(data.unpaid);
                  document.getElementById('total').value = numberWithCommas(document.getElementById('total'+x).innerHTML);
                  document.getElementById('paid').value = numberWithCommas(document.getElementById('paid'+x).innerHTML);
                  document.getElementById('sisa').value = numberWithCommas(document.getElementById('unpaid'+x).innerHTML);
                  document.getElementById('paytable').innerHTML = data.table;



            }
})
}


function navfunction(objButton){
var index = "";
if(objButton == "BL"){
    index = 'Belum-Lunas';
}
if(objButton == "SL"){
    index = "Sebagian-Lunas";
}
if(objButton == "L"){
    index = "Lunas";
}

loadtable(index);
}

function loadtable(x){
var table = "";
if(x=='Belum-Lunas'){
    table = 'belumlunastable';
}
if(x=='Sebagian-Lunas'){
    table = 'sebagianlunastable';
}
if(x=='Lunas'){
    table = 'lunastable';
    
}

var counter  = <?=$count?>;
var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
          transaction: x,
          counter: counter
          };
          $.ajax({
  url : "<?php echo base_url("salereceivables/gettable"); ?>",
              type: "GET",
                data: dataJson, 
                dataType: "json",
              success: function(data)
              {
            
                document.getElementById(table).innerHTML = data.table;


            }
});

}
function changecounter(){
counter = 1;
// alert(counter);
}
function getdata(y,x){
    var paymentid = y;
    var orderid = x;
    var selected = document.getElementById('selected').value;
    var dataJson = { 
            [csrfName]: csrfHash, // adding csrf here
          paymentid: y,
          orderid: x
          };
          $.ajax({
  url : "<?php echo base_url("salereceivables/getdataiframe"); ?>",
              type: "GET",
                data: dataJson, 
                dataType: "json",
              success: function(data)
              {
            // alert(data.unpaid);
            document.getElementById('total').value = numberWithCommas(data.total);
            document.getElementById('paid').value = numberWithCommas(data.paid);
            document.getElementById('sisa').value = numberWithCommas(data.unpaid);

            document.getElementById('mainbonhutang').innerHTML = data.maintable;
document.getElementById('tr'+selected).style.cssText = "background-color: #7FFFD4";
                document.getElementById('paytable').innerHTML = data.table;
                counter = 0;


            }
});
}
</script>

<?= $this->endSection('content') ?>
