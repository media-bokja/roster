# Search Meta

이 모듈은 워드프레스에서 검색의 범위를 커스텀 필드까지 확장시켜 줍니다.

포스트 검색시 기본적으로 제목, 본문, 발췌 (excerpt) 이 세 필드만을 대상으로 검색 쿼리를 작성합니다.
워드프레스의 WP_Query가 지원하는 일반적인 방법으로는
커스텀 필드까지 고려한 검색 쿼리를 작성할 수 가 없어, 별도로 SQL을 직접 짜야 합니다.

이 모듈은 WP_Query 클래스에서 생성하는 SQL 쿼리문을 수정하여
커스텀 필드가 검색에 반영되도록 처리합니다.

## 사용방법

WP_Query의 설정 배열에 'search_meta' 키를 추가하면 됩니다.

```php
$query = new WP_Query(
    [
        'post_type' => 'post',
        /* ... */
        's' => 'foo',
        'search_meta' => [ /* ... */ ],  
    ]
);
```

`search_meta`키의 값으로 순차 배열이며 각 요소는 검색을 진행할 커스텀 필드 이름, 즉 postmeta.meta_key 값을 입력하면 됩니다.
모듈이 동작 하면 이 키가 설정되어 있을 때 커스텀 필드도 검색되도록 쿼리를 수정합니다.

아래는 간단한 'search_meta'의 예입니다.
``` 
'search_meta' => [
    'custom_field_1',
    'custom_field_2',
]
```

`SearchMeta` 객체는 init 액션의 콜백이에서, 또는 플러그인이나 테마 초기화 코드에서 적당히 인스턴스화 시키면 됩니다.

```php
new SearchMeta();
```

## 설정 방법 

`SearchMeta` 클래스의 생성자 인자로 설정의 배열이나, 설정을 배열하는 파일의 경로를 입력합니다.

```php
new SearchMeta([ /* ... */]);
// 또는
new SearchMeta('/path/to/setup');
```

아래는 설정 파일의 예시입니다.

```php
if (!defined('ABSPATH')) {
    exit;
}

return [
    'postmeta_alias' => '_smeta',
];
```

- `postmeta_alias`: 포스트메타 테이블의 별명을 지정합니다. 기본값은 '_smeta'입니다.


## 주의할 점

WP_Query에 's'로 검색어를 넣을 경우 공백을 기준으로 단어를 나눠 각 단어별로 LIKE 검색을 시도합니다. 공백까지 한 단어로 간주하려면 따옴표로 감쌉니다.
커스텀 필드를 검색할 때에도 이와 동일한 동작을 합니다.
