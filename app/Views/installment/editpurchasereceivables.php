<?= $this->extend('Views/layout/page_layout') ?>
<?= $this->section('content') ?>
<br><br><br>
<script>
    var csrfName = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';  
  </script>
<main> 
<div style="width:80%;margin:0 auto">
<form id="theform" method="post" action="<?= base_url() ?>/purchasereceivables/editprocess/" enctype="multipart/form-data"> 
<?= csrf_field(); ?>
<div class="row">
                <div class="col-sm-5">
                <div class="mb-4">
            <div class="form-group row">
                <label for="modaldate" class="col-sm-2   col-form-label">Date</label>

                <div class="col-sm-5">
                 <input type="text" class="form-control" id="modaldate" name="modaldate" value="<?=$sql->date?>">
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="form-group row">
                <label for="amount" class="col-sm-2 col-form-label">Amount</label>

                <div class="col-sm-5">
                 <input type="text" class="form-control" id="amount" name="amount"  value="<?=$sql->amount?>">
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="form-group row">
                <label for="modalorderid" class="col-sm-2 col-form-label">Order ID</label>

                <div class="col-sm-5">
                 <input type="text" class="form-control" id="modalorderids" name="modalorderids" value="<?=$sql->order_id?>" readonly>
                </div>
            </div>
        </div>


                </div><!--for col-sm6-->

                <div class="col-sm-6">
                <div class="mb-3">
            <div class="form-group row">
                <label for="comment" class="col-sm-3 col-form-label">Detail Transaction</label>

                <div class="col-sm-9">
                <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"><?=$sql->detail?></textarea></pre>                </div>
            </div>

           
                </div>
                </div>

</div>

<div class="row">
<div class="input-field">
<!-- <label class="active">Photos</label> -->
<div class="input-images" style="padding-top: .5rem;"></div>
</div>
</div>
<br>
<?php
        $count = 0;
        $output= "";
        $link =  base_url('/uploadtrans/');
        foreach($result as $x){
            echo '<input type="hidden" id="original" name="original[]" value=" '.$x->gambar.' ">';
            $count++;
        }
      ?>
<input type="hidden" id="paymentid" name="paymentid" value="<?=$sql->paymentid?>" >

<button type="submit" class="btn btn-primary">Edit</button>
<button type="button" class="btn btn-primary" onclick="parent.closemodal();" >Cancel</button>

</form>
</div>
</main>
<script>
let preloaded = [
    <?php
        $count = 0;
        $link =  base_url('/uploadpreceivables/');
        foreach($image->getResult() as $x){
            echo '{id:'.$count.', src:" '.$link."/".$x->gambar.' "},';
            $count++;
        }
      ?>
  
];


$(function () {
  $('.input-images').imageUploader({
    preloaded: preloaded,
    imagesInputName: 'photoz',
    preloadedInputName: 'old'
  });
});


</script>

<script>
window.closeModal = function(){
    $('#editmodal').modal('hide');
};



$(document).ready(function(){
$("#theform").submit(function(){
    // parent.changecounter();
    // parent.closemodal();
});
});
function editbutton(){}
//   var amount = document.getElementById("amount").value;
//   if(amount == ""){

//   }
//     else{
//     document.getElementById("theform").submit();
// //     var dataJson = { 
// //         [csrfName]: csrfHash, // adding csrf here
// //         dates: document.getElementById("modaldate").value,
// //           amount: document.getElementById("amount").value,
// //           detail: document.getElementById("comment").value,
// //           paymentid:'<?=$sql->paymentid?>'

// //           };
// //           $.ajax({
// //   url : "<?php echo base_url("salereceivables/editprocess"); ?>",
// //               type: "POST",
// //                 data: dataJson, 
// //                 dataType: "json",
// //               success: function(data)
// //               {
// //             // alert(data.unpaid);
// //                 // document.getElementById('paytable').innerHTML = data.table;



// //             }
// // });

   

    

//   }
  
// }

</script>
<?= $this->endSection('content') ?>
