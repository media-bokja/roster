<?php

use Bokja\Roster\Vendor\Bojaghi\Template\Template;

/**
 * @var Template $this
 *
 * Context
 * - id: string
 * - label: string
 * - name: string
 * - value: string
 */

if (!defined('ABSPATH')) {
    exit;
}

$value = $this->get('value');

if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
    $exact_date  = $value;
    $approx_date = '';
} else {
    $exact_date  = '';
    $approx_date = $value;
}

$is_correct_date = !!$exact_date || (!$exact_date && !$approx_date);
?>
<th scope="row">
    <label for="<?php echo esc_attr($this->get('id')); ?>">
        <?php echo esc_html($this->get('label')); ?>
    </label>
</th>
<td>
    <div class="date-picker-wrapper">
        <input
            id="<?php echo esc_attr($this->get('id')); ?>"
            name="<?php echo esc_attr($this->get('name')); ?>"
            type="date"
            class="text date-picker"
            value="<?php echo esc_attr($exact_date); ?>"
            <?php disabled(!$is_correct_date); ?>
        />
        <label for="<?php echo esc_attr($this->get('id')); ?>--approx-checkbox">
            <input
                id="<?php echo esc_attr($this->get('id')); ?>--approx-checkbox"
                class="approx-date"
                type="checkbox"
                <?php checked(!$is_correct_date); ?>
            /><?php esc_html_e('날짜가 부정확합니다.', 'roster'); ?>
        </label>
    </div>
    <div class="date-approx-wrapper<?php echo $exact_date ? ' hidden' : ''; ?>">
        <label
            for="<?php echo esc_attr($this->get('id')); ?>--approx"
            class="screen-reader-text"
            aria-hidden="true"
        >
            <?php esc_html_e('서품일 (추정)', 'roster'); ?>
        </label>
        <input
            id="<?php echo esc_attr($this->get('id')); ?>--approx"
            type="text"
            name="<?php echo esc_attr($this->get('name')); ?>"
            class="text approx-date"
            value="<?php echo esc_attr($approx_date); ?>"
            maxlength="6"
            <?php disabled($is_correct_date); ?>
        />
        <span class="description">
            <?php esc_html_e('날짜가 정확하지 않다면, 알고 있는 연도와 월을 숫자로만 입력하세요.', 'roster'); ?>
        </span>
    </div>
</td>
