<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
  <link rel="stylesheet" href="<?= base_url('css/stock.css') ?>" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="stockCreateContainer">
            <h1 class="mt-5">Edit Stock Data</h1>
            <hr />
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h4>Periksa Entrian Form</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
            <form method="post" action="<?= base_url(); ?>/stock/update" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="row">
        <div class="col-sm-6"><div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" id="code" name="code" value="<?= $item->code ?>">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $item->name ?>">
        </div>
      </div>
        <div class="col-sm-6">
          <div class="mb-3">
              <label for="price" class="form-label">Price</label>
              <input type="text" class="form-control" id="price" name="price" value="<?= $item->price ?>">
          </div>
          <div class="mb-3">
              <label for="stock" class="form-label">Stock</label>
              <input type="text" class="form-control" id="stock" name="stock" value="<?= $item->stock ?>">
          </div>
        </div>
      </div>

      <div>

            </div>
      <div>
      <div class="input-field">
    <label class="active">Photos</label>
    <div class="input-images-2" style="padding-top: .5rem;"></div>
</div>
                </div>
                <?php
        $count = 0;
        $output= "";
        $link =  base_url('/uploads/');
        foreach($image as $x){
            echo '<input type="hidden" id="original" name="original[]" value=" '.$x->gambar.' ">';
            $count++;
        }
      ?>
      <div class="mb-3">
          <button type="submit" class="btn btn-primary">Create</button>
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
        $link =  base_url('/uploads/');
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
