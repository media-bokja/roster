# 명부 데이터 명세

명부에 필요한 데이터 필드를 명세합니다.
현재 필드는 총 13개이고, 이름을 제외한 모든 필드는 커스텀 필드로 저장합니다.

## 상세, 매핑

필드 나열은 메타 키 값의 사전 순서를 취하세요.

| 항목        | 타입      | 매핑                                    |
|-----------|---------|---------------------------------------|
| 이름        | 텍스트, 필수 | posts.post_title                      |
| **세레명**   | 텍스트     | meta.roster_baptismal_name            |
| **생일**    | 연월일     | meta.roster_birthday                  |
| **현소임지**  | 텍스트     | meta.roster_current_assignment        |
| **선종일**   | 연월일     | meta.roster_date_of_death             |
| **입회일**   | 연월일     | meta.roster_entrance_date             |
| **첫서원일**  | 연월일     | meta.roster_initial_profession_date   |
| **수도명**   | 텍스트     | meta.roster_monastic_name             |
| **축일**    | 텍스트     | meta.name_day                         |
| **국적**    | 텍스트     | meta.roster_nationality               |
| **서품일**   | 연월일     | meta.roster_ordination_date           |
| **종신서원일** | 연월일     | meta.roster_perpetual_profession_date |
| **사진**    | 이미지     | meta.roster_profile_image             |

## 이미지 처리

회원 명부는 제한된 데이터이기 때문에 별도로 관리할 필요가 있습니다. 따라서 이미지는 미디어 관리자에 넣지 않습니다.

이미지 제한은 아래처럼 처리합니다.

- JPEG, PNG, WEBP 만 가능
- 가로 세로 각각 720 픽셀 이내. 아닐 경우 강제로 리사이징됨.
- 저장시 WEBP 형식으로 자동 변환
- 업로드시 파일 이름은 무시되며 적절한 패턴으로 변경
- 중간 크기를 위한 최대 480픽셀 길이의 리사이징된 이미지 생성
- 섬네일을 위한 최대 240픽셀 길이의 리사이징된 이미지 생성
