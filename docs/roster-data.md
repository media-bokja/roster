# 명부 데이터 명세

명부에 필요한 데이터 필드를 명세합니다.
현재 필드는 총 13개이고, 이름을 제외한 모든 필드는 커스텀 필드로 저장합니다.

- 이름
- 세례명
- 수도명
- 생일
- 사망일
- 입회일
- 초(初)서원일
- 종신서원일
- 서품일
- 퇴회일
- 사진
- 현소임지
- 전소임지

## 상세

- **이름**: 텍스트. 필수.
- **세레명**: 텍스트
- **수도명**: 텍스트
- **생일**: 연월일
- **사망일**: 연월일
- **입회일**: 연월일
- **초(初)서원일**: 연월일
- **종신서원일**: 연월일
- **서품일**: 연월일
- **퇴회일**: 연월일
- **사진**: 이미지
- **현소임지**: 텍스트
- **전소임지**: 텍스트

## 필드 매핑

필드와 워드프레스 테이블 내에서의 매핑을 설정

- **이름**: posts.post_title
- **세레명**: meta.roster_baptismal_name
- **수도명**: meta.roster_monastic_name
- **생일**: meta.roster_birthday
- **사망일**: meta.roster_date_of_death
- **입회일**: meta.roster_entrance_date
- **초(初)서원일**: meta.roster_initial_profession_date
- **종신서원일**: meta.roster_perpetual_profession_date
- **서품일**: meta.roster_ordination_date
- **퇴회일**: meta.roster_departure_date
- **사진**: meta.roster_profile_image
- **현소임지**: meta.roster_current_assignment
- **전소임지**: meta.roster_former_assignments

## 이미지 처리

이미지를 별도의 사진으로 사용하고 미디어 관리자에 넣지 않는 이유는
이미 미디어 파일에 너무 많은 이미지가 있고,
회원 명부는 소수를 위한 제한적인 접근을 위한 데이터이기 때문에
이미지를 별도로 관리하여 저장하기 때문.

- JPEG, PNG, WEBP 만 가능
- 가로 세로 각각 720 픽셀 이내. 아닐 경우 강제로 리사이징됨. 
- 저장시 WEBP 형식으로 자동 변환
- 업로드시 파일 이름은 무시되며 적절한 패턴으로 변경
- 섬네일을 위한 최대 200픽셀 길이의 리사이징된 이미지 한벌 생성
