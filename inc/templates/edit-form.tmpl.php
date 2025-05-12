<?php

use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use Bojka\Roster\Objects\Profile;

/**
 * @var Template $this
 *
 * Context
 * profile: Profile
 * thumbnail: array
 */

/** @var Profile $profile */
$profile   = $this->get('profile');
$full_iage = $profile->profileImage['full'] ?? [];
$thumbnail = $profile->profileImage['thumbnail'] ?? [];

$explodedNameDay = explode('-', $profile->nameDay, 2);
if (2 === count($explodedNameDay)) {
    $nd_month = $explodedNameDay[0];
    $nd_day   = $explodedNameDay[1];
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
                    <img class="profile-image-thumbnail"
                         src="<?php echo esc_url($thumbnail['path']); ?>"
                         width="<?php echo esc_attr($thumbnail['width'] ?? ''); ?>"
                         height="<?php echo esc_attr($thumbnail['height'] ?? ''); ?>"
                         alt="<?php echo esc_attr(sprintf('%s의 프로필 이미지 섬네일', $profile->name)); ?>" />
                <?php else : ?>
                    <?php esc_html_e('사진이 첨부되지 않았습니다.', 'roster'); ?>
                <?php endif; ?>
            </div>
            <div class="roster-attach-profile_image">
                <input id="roster-profile_image"
                       accept="image/jpeg, image/png, image/webp"
                       name="bokja_roster_profile_image"
                       type="file"
                       value="" />
                <p class="description">
                    <?php esc_html_e('파일을 새로 첨부하고 업데이트 버튼을 눌러야 새 이미지로 갱신됩니다.', 'roster'); ?>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-name">이름</label></th>
        <td>
            <input id="roster-name"
                   name="bokja_roster[name]"
                   type="text"
                   class="text regular-text"
                   required="required"
                   value="<?php echo esc_attr($profile->name); ?>" />

            <p class="description"><?php
                esc_html_e('이름은 필수입니다.', 'roster');
                ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-nationality">국적</label></th>
        <td>
            <input id="roster-nationality"
                   name="bokja_roster[nationality]"
                   type="text"
                   class="text regular-text"
                   value="<?php echo esc_attr($profile->nationality); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-baptismal_name">세례명, 축일</label></th>
        <td>
            <div class="baptismal-name_day">
                <input id="roster-baptismal_name"
                       name="bokja_roster[baptismal_name]"
                       type="text"
                       class="text"
                       value="<?php echo esc_attr($profile->baptismalName); ?>" />

                <div>
                    <label>축일</label>
                    <label for="roster_name_day-month">
                        <input id="roster_name_day-month"
                               class="text tiny-text"
                               type="number"
                               min="0"
                               max="12"
                               value="<?php echo esc_attr($nd_month); ?>" />
                        월
                    </label>
                    <label for="roster_name_day-day">
                        <input id="roster_name_day-day"
                               class="text tiny-text"
                               type="number"
                               min="0"
                               max="31"
                               value="<?php echo esc_attr($nd_day); ?>" />
                        일
                    </label>
                    <input id="roster_name_day"
                           type="hidden"
                           name="bokja_roster[name_day]"
                           value="<?php echo esc_attr($profile->nameDay); ?>" />
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
            <input id="roster-monastic_name"
                   name="bokja_roster[monastic_name]"
                   type="text"
                   class="text regular-text"
                   value="<?php
                   echo esc_attr($profile->monasticName); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-current_assignment">현소임지</label></th>
        <td>
            <input id="roster-current_assignment"
                   name="bokja_roster[current_assignment]"
                   type="text"
                   class="text regular-text"
                   value="<?php
                   echo esc_attr($profile->currentAssignment); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-birthday">생일</label></th>
        <td>
            <input id="roster-birthday"
                   name="bokja_roster[birthday]"
                   type="date"
                   class="text date-picker"
                   value="<?php
                   echo esc_attr($profile->birthday); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-date_of_death">선종일</label></th>
        <td>
            <input id="roster-date_of_death"
                   name="bokja_roster[date_of_death]"
                   type="date"
                   class="text date-picker"
                   value="<?php
                   echo esc_attr($profile->dateOfDeath); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-entrance_date">입회일</label></th>
        <td>
            <input id="roster-entrance_date"
                   name="bokja_roster[entrance_date]"
                   type="date"
                   class="text date-picker"
                   value="<?php
                   echo esc_attr($profile->entranceDate); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-initial_profession_date">첫서원일</label></th>
        <td>
            <input id="roster-initial_profession_date"
                   name="bokja_roster[initial_profession_date]"
                   type="date"
                   class="text date-picker"
                   value="<?php
                   echo esc_attr($profile->initialProfessionDate); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-perpetual_profession_date">종신서원일</label></th>
        <td>
            <input id="roster-perpetual_profession_date"
                   name="bokja_roster[perpetual_profession_date]"
                   type="date"
                   class="text date-picker"
                   value="<?php
                   echo esc_attr($profile->perpetualProfessionDate); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-ordination_date">서품일</label></th>
        <td>
            <input id="roster-ordination_date"
                   name="bokja_roster[ordination_date]"
                   type="date"
                   class="text date-picker"
                   value="<?php
                   echo esc_attr($profile->ordinationDate); ?>" />
        </td>
    </tr>
    </tbody>
</table>

<input type="hidden"
       name="bokja_roster[id]"
       value="<?php
       echo esc_attr($profile->id); ?>" />

<div class="image-popup hidden">
    <div class="image-popup-inner">
        <img class="profile-image-full"
             src=""
             data-src="<?php echo esc_url($full_iage['path']); ?>"
             width="<?php echo esc_attr($full_iage['width'] ?? ''); ?>"
             height="<?php echo esc_attr($full_iage['height'] ?? ''); ?>"
             alt="<?php echo esc_attr(sprintf('%s의 프로필 이미지', $profile->name)); ?>" />
        <?php /* <div class="image-popup-close">
            <span class="dashicons dashicons-no-alt"></span>
        </div> */ ?>
    </div>
</div>
