<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
  <link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="stockCreateContainer">
            <h1 class="mt-5">Edit Expense Data</h1>
            <hr />
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Periksa Entrian Form</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" action="<?= base_url(); ?>/othersales/editprocess/<?=$id?>">
             <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
            <div class="form-group row">
                <label for="date" class="col-sm-3 col-form-label">Date</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="date" name="date" value="<?=$expense->date?>">
                </div>
            </div>
        </div>
        <div class="mb-3">
        <div class="form-group row">
                <label for="category" class="col-sm-3 col-form-label">Category</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="category" name="category" value="<?=$expense->category?>">
                </div>
            </div>
        </div>
        <div class="mb-3">
          <div class="form-group row">
                <label for="amount" class="col-sm-3 col-form-label">Amount</label>

                <div class="col-sm-9">
                 <input type="text" class="form-control" id="amount" name="amount" value="<?=$expense->amount?>">
                </div>
            </div>
          </div>
         
        
            <div class="mb-3">
            <div class="form-group row">
                <label for="comment" class="col-sm-3 col-form-label">Detail</label>

                <div class="col-sm-9">
                <pre><textarea class="form-control" style="white-space: pre-wrap;" rows="5" id="comment" name="comment"><?=$expense->detail?></textarea></pre>                </div>
            </div>

           
                </div>


            </div>



      </div>
        <div class="col-sm-6">
        
      </div>

      <div>
      <div class="input-field">
    <label class="active"><h3>Photos</h3></label>
    <div class="input-images-2" style="padding-top: .5rem;"></div>
</div>
                </div>
      <?php
        $count = 0;
        $output= "";
        $link =  base_url('/uploadothersales/');
        foreach($image as $x){
            echo '<input type="hidden" id="original" name="original[]" value=" '.$x->gambar.' ">';
            $count++;
        }
      ?>

      <br>
      <div class="mb-3">
          <button type="submit" class="btn btn-primary">Edit</button>
</button>

      </div>

            </form>
            <hr />

        </div>
    </main>
    <script>
let preloaded = [
    <?php
        $count = 0;
        $link =  base_url('/uploadothersales/');
        foreach($image as $x){
            echo '{id:'.$count.', src:" '.$link."/".$x->gambar.' "},';
            $count++;
        }
      ?>
  
];



$(function () {
$('.input-images-2').imageUploader({
    preloaded: preloaded,
    imagesInputName: 'photos',
    preloadedInputName: 'old'
});
});


</script>
    <?= $this->endSection('content') ?>
