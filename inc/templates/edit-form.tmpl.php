<?php

use Bokja\Roster\Vendor\Bojaghi\Template\Template;
use Bojka\Roster\Objects\Profile;

/**
 * @var Template $this
 * @var Profile  $profile
 */

$profile = $this->get('profile');
?>

<table class="form-table" role="presentation">
    <tbody>
    <tr>
        <th scope="row"><label for="roster-name">이름</label></th>
        <td>
            <input id="roster-name"
                   name="bokja_roster[name]"
                   type="text"
                   class="text regular-text"
                   required="required"
                   value="<?php
                   echo esc_attr($profile->name); ?>" />

            <p class="description"><?php
                esc_html_e('이름은 필수입니다.', 'roster');
                ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-profile_image">사진</label></th>
        <td>
            <div class="roster-current-profile_image">
                <?php $profileImage = $profile->profileImage; ?>
                <?php if (!empty($profileImage)) : ?>
                    <?php
                    $url    = wp_get_upload_dir()['baseurl'] . '/' . $profileImage['thumbnail']['path'];
                    $width  = $profileImage['thumbnail']['width'];
                    $height = $profileImage['thumbnail']['height'];
                    $alt    = sprintf(__('%s %s 명부 사진', 'roster'), $profile->name, $profile->baptismalName);
                    ?>
                    <img class="profile-image-thumbnail"
                         src="<?php echo esc_url($url); ?>"
                         width="<?php echo esc_attr($width); ?>"
                         height="<?php echo esc_attr($height); ?>"
                         title="<?php echo esc_attr($alt); ?>"
                         alt="<?php echo esc_attr($alt); ?>" />
                <?php else : ?>
                    <?php esc_html_e('사진이 첨부되지 않았습니다.', 'roster'); ?>
                <?php endif; ?>
            </div>
            <div class="roster-attach-profile_image">
                <input id="roster-profile_image"
                       name="bokja_roster_profile_image"
                       type="file"
                       value="" />
                <p class="description">
                    <?php esc_html_e('파일을 새로 첨부하면 새 이미지로 갱신됩니다.', 'roster'); ?>
                </p>
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="roster-baptismal_name">세례명</label></th>
        <td>
            <input id="roster-baptismal_name"
                   name="bokja_roster[baptismal_name]"
                   type="text"
                   class="text regular-text"
                   value="<?php
                   echo esc_attr($profile->baptismalName); ?>" />
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
        <th scope="row"><label for="roster-date_of_death">사망일</label></th>
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
        <th scope="row"><label for="roster-initial_profession_date">첫 서원일</label></th>
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
    <tr>
        <th scope="row"><label for="roster-departure_date">퇴회일</label></th>
        <td>
            <input id="roster-departure_date"
                   name="bokja_roster[departure_date]"
                   type="date"
                   class="text date-picker"
                   value="<?php
                   echo esc_attr($profile->departureDate); ?>" />
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
        <th scope="row"><label for="roster-former_assignments">전소임지</label></th>
        <td>
            <textarea id="roster-former_assignments"
                      name="bokja_roster[former_assignments]"
                      class=""
                      rows="5"
                      cols="38"><?php echo esc_textarea($profile->formerAssignments); ?></textarea>
            <p class="description">
                <?php esc_html_e('한 줄에 하나씩 입력하세요.', 'roster'); ?></p>
        </td>
    </tr>
    </tbody>
</table>
<input type="hidden"
       name="bokja_roster[id]"
       value="<?php
       echo esc_attr($profile->id); ?>" />
