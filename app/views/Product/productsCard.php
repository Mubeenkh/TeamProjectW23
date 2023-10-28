<link rel="stylesheet" type="text/css" href="/css/card.css">

<?php
foreach ($data as $product) { ?>
    <div class="col">
      <a class="no-underline" href="/Product/productDetails/<?= htmlentities($product->product_id) ?>">
      <div class="card card-glow">
        <div id="ingredientIMG">
          <div class="image">
              <img style="width: 172px; height: 199.6px;" src="/productImages/<?= htmlentities($product->picture) ?>">
          </div>
        </div>
        <span class="title"><?= htmlentities($product->name) ?></span>
      </div>
    </a>
    </div>
<?php } ?>
