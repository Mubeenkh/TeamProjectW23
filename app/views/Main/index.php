<?php $this->view('shared/header', _('Home Page')); ?>
<?php $this->view('shared/navigation/nav'); ?>

<div class="split-screen">
    <!-- Left content -->
    <div class="left_side">
        <p style="font-size: 50px; font-size: clamp(1.25rem, 0.0481rem + 5.1282vw, 4.375rem);" id="home_header"><?= _('Welcome Sweemory Team!') ?></p>
    </div>

    <!-- Right content -->
    <div class="right_side">
      <img class="menu-image" src="/resources/sweemory1.png" height="563px" width="100%">
    </div>
</div>
 
<h1 style="font-size: clamp(1.25rem, 0.7692rem + 2.0513vw, 2.5rem); margin-left: 20px;"><?= _('What would you like to do today?') ?></h1>


<div class="home_links">
  <div class="container text-center">
    <div class="row align-items-start">
      <div class="col">
        <a class="btn-general" id="home_links" href="/Message/index" role="button" style="background-color: #e8c8e7;"><?= _('Messages') ?></a>
      </div>
      <div class="col">
        <a class="btn-general" id="home_links" href="/Product/index" role="button" style="background-color: #e8c8e7;"><?= _('Inventory') ?></a>
      </div>
      <div class="col">
        <a class="btn-general" id="home_links" href="/Recipe/index" role="button" style="background-color: #e8c8e7;"><?= _('Recipes') ?></a>
      </div>
    </div>
  </div>
</div>


<?php $this->view('shared/footer'); ?>