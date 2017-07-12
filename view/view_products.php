<div class="wrapper row2">

	<div id="container" class="clear">
		<!-- content body -->
	</div>

	<div class="container">

		<ul class="tabs">
      <?php
        echo "<li class=\"tab-link current\" data-tab=\"tab-".$categories[0]['id']."\">".$categories[0]['name']."</li>";
        for ($cnt = 1; $cnt < count($categories); $cnt++) {
            echo "<li class=\"tab-link\" data-tab=\"tab-".$categories[$cnt]['id']."\">".$categories[$cnt]['name']."</li>";
        }
      ?>
		</ul>

    <?php

      echo "<div id=\"tab-". $categories[0]['id'] ."\" class=\"tab-content current\">";
      for ($prod = 0; $prod < count($products); $prod++) {
        if ( strcmp($products[$prod]['quantity_type'], $categories[0]['name']) == 0 ) { ?>
          <div class="product">
                <img src="/images/uploads/<?php echo str_replace(" ", "_", $products[$prod]['quantity_type']); ?>/<?php echo $products[$prod]['image']; ?>" alt="">
                <div style="clear:both;"></div>
                <span> <?php echo $products[$prod]['name']; ?></span>
            </div>
      <?php  }
      }
      echo "</div>";
      for ($cat = 1; $cat < count($categories); $cat++) {
        echo "<div id=\"tab-". $categories[$cat]['id'] ."\" class=\"tab-content\">";
        for ($prods = 0; $prods < count($products); $prods++) {
          if ( strcmp($products[$prods]['quantity_type'], $categories[$cat]['name']) == 0 ) { ?>
            <div class="product">
                  <img src="/images/uploads/<?php echo str_replace(" ", "_", $products[$prods]['quantity_type']); ?>/<?php echo $products[$prods]['image']; ?>"  alt="">
                  <div style="clear:both;"></div>
                  <span> <?php echo $products[$prods]['name']; ?></span>
              </div>
        <?php
          }
        }
        echo "</div>";
      }

     ?>


    </div>
</div>
<script>

$(document).on('click', '.tabs .tab-link', function(){
 var tab_id = $(this).data('tab');
  $('.tabs .tab-link').removeClass('current');
   $(this).addClass('current');
    $('.container .tab-content').removeClass('current');
     $('#' + tab_id).addClass('current');
});

</script>
