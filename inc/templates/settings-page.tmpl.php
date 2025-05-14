<?php

use Bokja\Roster\Vendor\Bojaghi\Template\Template;

/**
 * @var Template $this
 */
?>

<div class="wrap">
    <h1><?php $this->get('page_title'); ?></h1>

    <hr class="wp-header-end">

    <form action="<?php echo esc_url(admin_url('options.php')); ?>" method="post">
        <?php do_settings_sections($this->get('page_slug')); ?>
        <?php settings_fields($this->get('option_group')); ?>
        <?php submit_button(); ?>
    </form>
</div>
