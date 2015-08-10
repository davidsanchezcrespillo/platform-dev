<figure>
  <?php if($zoomable): ?>
    <div class="picContainer zoomable">
      <?php echo l($image_output . "<span class='zoomIcon'></span>", $path_to_original, array('html' => TRUE, 'attributes' => array('class' => 'fancybox'))); ?>
    </div>
  <?php else: ?>
    <div class="picContainer">
      <?php echo $image_output; ?>
    </div>
  <?php endif; ?>
  <?php if ($title || $copyright): ?>
    <figcaption>
      <?php if ($title): ?>
      <div class="legend">
          <?php echo $title; ?>
      </div>
      <?php endif; ?>
      <?php if ($copyright): ?>
        <div class="copyright">&copy;
          <?php echo $copyright; ?>
        </div>
      <?php endif; ?>
    </figcaption>
  <?php endif; ?>
</figure>
