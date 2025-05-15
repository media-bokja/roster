<?php

use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use Bojka\Roster\Objects\Profile;

/**
 * @var Template $this
 *
 * Context
 * - icon32: string
 * - icon180: string
 * - icon192: string
 * - icon270: string
 */
?>

<?php if ($this->get('icon32')) : ?>
    <link rel="icon" href="<?php echo esc_url($this->get('icon32')); ?>" sizes="32x32" />
<?php endif; ?>
<?php if ($this->get('icon192')) : ?>
    <link rel="icon" href="<?php echo esc_url($this->get('icon192')); ?>" sizes="192x192" />
<?php endif; ?>
<?php if ($this->get('icon180')) : ?>
    <link rel="apple-touch-icon" href="<?php echo esc_url($this->get('icon180')); ?>" />
<?php endif; ?>
<?php if ($this->get('icon270')) : ?>
    <meta name="msapplication-TileImage" content="<?php echo esc_url($this->get('icon270')); ?>" />
<?php endif; ?>

<title>
    <?php echo esc_html($this->get('title')); ?>
</title>
