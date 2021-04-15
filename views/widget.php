<div class="ccal-wrapper">
  <div class="ccal-list">
    <h3 class="widget-title">
      Events
      <?php if (current_user_can( 'edit_posts' )) { ?>
      <a href="<?php echo get_admin_url( $blog_id = null, $path = 'post-new.php?post_type=ccal_event', $scheme = 'admin' ); ?>">
        <span class="dashicons dashicons-plus"></span>
      </a>
      <?php } ?>
    </h3>

    <ul>
      <?php while ($upcoming_events->have_posts()) { $upcoming_events->the_post();?>
      <?php $event_date = get_post_custom(get_the_ID()); ?>
      <li onclick="ccal_viewEvent('<?php echo admin_url('admin-ajax.php');?>', <?php echo get_the_ID(); ?>)"><?php the_title(); ?><small> - <?php echo CCalEvent::format_timestamp($event_date['event_date'][0]); ?></small></li>
      <?php } ?>
    </ul>
  </div>

  <div class="ccal-loading">
    <h3 style="text-align:left;" class="widget-title">Events</h3>
    <span class="dashicons dashicons-image-rotate"></span>
  </div>

  <div class="ccal-event">
    <h3 onclick="ccal_viewList();" class="widget-title">
      <span class="dashicons dashicons-arrow-left-alt"></span>
      <span id="ccale_title"></span>
    </h3>
    <p id="ccale_date"></p>
    <?php if (is_user_logged_in()) { ?>
    <p><a onclick="ccal_setAvailability('<?php echo admin_url('admin-ajax.php');?>', 1);return false;" class="green" href="#">Teilnehmen</a> - <a onclick="ccal_setAvailability('<?php echo admin_url('admin-ajax.php');?>', 2);return false;" class="amber" href="#">Weiß nicht</a> - <a onclick="ccal_setAvailability('<?php echo admin_url('admin-ajax.php');?>', 3);return false;" class="red" href="#">Nicht Teilnehmen</a></p>
    <p>Antwort: <span id="ccale_answer">keine</span> </p>
    <?php } ?>
    <p>Antworten: <span id="ccale_users"><span class="green">Fire</span>, <span class="amber">Bowie</span></span></p>
    <?php if (current_user_can( 'edit_posts' )) { ?>
    <p><a style="text-decoration:none;" onclick="window.location.href=this.dataset.baseUrl+ccal_current_event_id;return false;" data-base-url="<?php echo get_admin_url( $blog_id = null, $path = 'post.php?action=edit&post=', $scheme = 'admin' ); ?>" href="#"><span class="dashicons dashicons-welcome-write-blog"></span> Event bearbeiten</a></p>
    <?php } ?>
    <br>
    <p id="ccale_content"></p>
  </div>
</div>
