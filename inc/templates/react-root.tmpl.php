<?php
/**
 * @var Template $this
 *
 * Context:
 * - id: string
 * - class: string
 * - inner_content: string
 */

use Bokja\Roster\Vendor\Bojaghi\Template\Template;

if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="<?php echo esc_attr($this->get('id', 'bokja-roster-root')); ?>"
     class="<?php echo esc_attr($this->get('class', 'bokja-roster roster-root')); ?>"
     data-roster-root="true"><?php echo esc_html($this->get('inner_content')); ?></div>
