<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>

        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
  Master Data
  </a>
  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
  <a class="dropdown-item"  href="<?= base_url('/users') ?>">Users</a>
  <a class="dropdown-item" href="<?= base_url('/employee') ?>">Employees</a>
  <a class="dropdown-item" href="<?= base_url('/customer') ?>">Customer</a>
  <a class="dropdown-item" href="<?= base_url('/stock') ?>">Barang</a>
  <a class="dropdown-item" href="<?= base_url('/supplier') ?>">Supplier</a>

 
  </li>
 
  <li class="nav-item dropdown active">
    <a class="nav-link dropdown-toggle" href="#" id="transactionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Transaction
  </a>
  <div class="dropdown-menu" aria-labelledby="transactionDropdown">
    <a class="dropdown-item"  href="<?= base_url('/purchase') ?>">Purchase</a>
    <a class="dropdown-item" href="<?= base_url('/sales') ?>">Sales</a>
    <a class="dropdown-item" href="<?= base_url('/expense') ?>">Expense</a>
    <a class="dropdown-item" href="<?= base_url('/other-sales') ?>">Other-Sales</a>

   
</li>
<li class="nav-item dropdown active">
    <a class="nav-link dropdown-toggle" href="#" id="reportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Reports
  </a>
  <div class="dropdown-menu" aria-labelledby="reportDropdown">
    <a class="dropdown-item"  href="<?= base_url('/sales-report') ?>">Sales Report</a>
    <a class="dropdown-item" href="<?= base_url('/purchase-report') ?>">Purchase Report</a>
</li>


<li class="nav-item dropdown active">
    <a class="nav-link dropdown-toggle" href="#" id="reportDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Installment
  </a>
  <div class="dropdown-menu" aria-labelledby="reportDropdown">
    <a class="dropdown-item"  href="<?= base_url('/purchase-receivables') ?>">Purchase Receivables</a>
    <a class="dropdown-item"  href="<?= base_url('/sales-receivables') ?>">Sales Receivables</a>

</li>
  <li class="nav-item">
      <a class="nav-link" href="<?= base_url(); ?>/logout">Logout</a>
  </li>
</ul>
</div>
</div>
</nav>
