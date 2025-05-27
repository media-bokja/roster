<?php

use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use Bokja\Roster\Objects\Profile;

/**
 * @var Template $this
 *
 * Context
 * profile: Profile
 * thumbnail: array
 */

/** @var Profile $profile */
$profile    = $this->get('profile');
$full_image = $profile->profileImage['full'] ?? [];
$thumbnail  = $profile->profileImage['thumbnail'] ?? [];

$exploded_name_day = explode('-', $profile->nameDay, 2);
if (2 === count($exploded_name_day)) {
    $nd_month = $exploded_name_day[0];
    $nd_day   = $exploded_name_day[1];
} else {
    $nd_month = '';
    $nd_day   = '';
}

?>
<table id="roster-edit-form" class="form-table" role="presentation">
    <tbody>
    <tr>
        <th scope="row"><label for="roster-profile_image">사진</label></th>
        <td>
            <div class="roster-current-profile_image">
                <?php if (!empty($thumbnail['path'])) : ?>
                    <div class="profile-image-wrap">
                        <h5 class="description label"><?php esc_html_e('현재 사진', 'roster'); ?></h5>
                        <img
                            class="profile-image profile-image-thumbnail"
                            src="<?php echo esc_url($thumbnail['path']); ?>"
                            width="<?php echo esc_attr($thumbnail['width'] ?? ''); ?>"
                            height="<?php echo esc_attr($thumbnail['height'] ?? ''); ?>"
                            alt="<?php echo esc_attr(sprintf('%s의 프로필 이미지 섬네일', $profile->name)); ?>"
                        />
                    </div>
                <?php else : ?>
                    <?php esc_html_e('사진이 첨부되지 않았습니다.', 'roster'); ?>
                <?php endif; ?>

                <div class="profile-image-wrap hidden">
                    <h5 class="description label"><?php esc_html_e('새로 첨부할 사진', 'roster'); ?></h5>
                    <img
                        class="profile-image profile-image-preview"
                        src=""
                        alt="<?php echo esc_attr('이미지 미리보기', 'roster'); ?>"
                    />
                </div>

            </div>
            <div class="roster-attach-profile_image">
                <input
                    id="roster-profile_image"
                    accept="image/jpeg, image/png, image/webp"
                    name="bokja_roster_profile_image"
                    type="file"
                    value=""
                />
                <a
                    id="roster-remove-profile-image"
                    href="#"
                    style="display:none;"
                ><?php esc_html_e('첨부 취소', 'roster'); ?></a>
                <p class="description">
                    <?php esc_html_e('파일을 새로 첨부하고 업데이트 버튼을 눌러야 새 이미지로 갱신됩니다.', 'roster'); ?>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-name">이름</label></th>
        <td>
            <input
                id="roster-name"
                name="bokja_roster[name]"
                type="text"
                class="text regular-text"
                required="required"
                value="<?php echo esc_attr($profile->name); ?>"
            />

            <p class="description"><?php
                esc_html_e('이름은 필수입니다.', 'roster');
                ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-nationality">국적</label></th>
        <td>
            <input
                id="roster-nationality"
                name="bokja_roster[nationality]"
                type="text"
                class="text regular-text"
                value="<?php echo esc_attr($profile->nationality); ?>"
            />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-baptismal_name">세례명, 축일</label></th>
        <td>
            <div class="baptismal-name_day">
                <input
                    id="roster-baptismal_name"
                    name="bokja_roster[baptismal_name]"
                    type="text"
                    class="text"
                    value="<?php echo esc_attr($profile->baptismalName); ?>"
                />

                <div>
                    <label>축일</label>
                    <label for="roster_name_day-month">
                        <input
                            id="roster_name_day-month"
                            class="text tiny-text"
                            type="number"
                            min="0"
                            max="12"
                            value="<?php echo esc_attr($nd_month); ?>"
                        />
                        월
                    </label>
                    <label for="roster_name_day-day">
                        <input
                            id="roster_name_day-day"
                            class="text tiny-text"
                            type="number"
                            min="0"
                            max="31"
                            value="<?php echo esc_attr($nd_day); ?>"
                        />
                        일
                    </label>
                    <input
                        id="roster_name_day"
                        type="hidden"
                        name="bokja_roster[name_day]"
                        value="<?php echo esc_attr($profile->nameDay); ?>"
                    />
                </div>
            </div>
            <p class="description field-error-message">
                <span class="dashicons dashicons-info"></span>
                축일을 정확히 입력하세요.
                생략하려면 월/일을 모두 0 또는 공백으로 채우세요.
            </p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-monastic_name">수도명</label></th>
        <td>
            <input
                id="roster-monastic_name"
                name="bokja_roster[monastic_name]"
                type="text"
                class="text regular-text"
                value="<?php
                echo esc_attr($profile->monasticName); ?>"
            />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-current_assignment">현소임지</label></th>
        <td>
            <input
                id="roster-current_assignment"
                name="bokja_roster[current_assignment]"
                type="text"
                class="text regular-text"
                value="<?php
                echo esc_attr($profile->currentAssignment); ?>"
            />
        </td>
    </tr>
    <tr>
        <?php echo $this->template('part-date-field', [
            'id'    => 'roster-birthday',
            'label' => __('생일', 'roster'),
            'name'  => 'bokja_roster[birthday]',
            'value' => $profile->birthday,
        ]); ?>
    </tr>
    <tr>
        <?php echo $this->template('part-date-field', [
            'id'    => 'roster-date_of_death',
            'label' => __('선종일', 'roster'),
            'name'  => 'bokja_roster[date_of_death]',
            'value' => $profile->dateOfDeath,
        ]); ?>
    </tr>
    <tr>
        <?php echo $this->template('part-date-field', [
            'id'    => 'roster-entrance_date',
            'label' => __('입회일', 'roster'),
            'name'  => 'bokja_roster[entrance_date]',
            'value' => $profile->entranceDate,
        ]); ?>
    </tr>
    <tr>
        <?php echo $this->template('part-date-field', [
            'id'    => 'roster-initial_profession_date',
            'label' => __('첫서원일', 'roster'),
            'name'  => 'bokja_roster[initial_profession_date]',
            'value' => $profile->initialProfessionDate,
        ]); ?>
    </tr>
    <tr>
        <?php echo $this->template('part-date-field', [
            'id'    => 'roster-perpetual_profession_date',
            'label' => __('종신서원일', 'roster'),
            'name'  => 'bokja_roster[perpetual_profession_date]',
            'value' => $profile->perpetualProfessionDate,
        ]); ?>
    </tr>
    <tr>
        <?php echo $this->template('part-date-field', [
            'id'    => 'roster-ordination_date',
            'label' => __('서품일', 'roster'),
            'name'  => 'bokja_roster[ordination_date]',
            'value' => $profile->ordinationDate,
        ]); ?>
    </tr>
    </tbody>
</table>

<input
    type="hidden"
    name="bokja_roster[id]"
    value="<?php
    echo esc_attr($profile->id); ?>"
/>

<div class="image-popup hidden">
    <div class="image-popup-inner">
        <img
            class="profile-image-full"
            src=""
            data-src="<?php echo esc_url($full_image['path']); ?>"
            width="<?php echo esc_attr($full_image['width'] ?? ''); ?>"
            height="<?php echo esc_attr($full_image['height'] ?? ''); ?>"
            alt="<?php echo esc_attr(sprintf('%s의 프로필 이미지', $profile->name)); ?>"
        />
        <?php /* <div class="image-popup-close">
            <span class="dashicons dashicons-no-alt"></span>
        </div> */ ?>
    </div>
</div>
