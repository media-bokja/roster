# scripts

워드프레스에서 스크립트의 등록, 삽입을 위한 모듈

이 모듈을 사용하여 보다 명시적으로 스크립트 파일을 관리하고 조정합니다.

## 설정방법

다음은 설정 배열의 예시입니다. 설정 파일에서 가져온다고 가정합니다.

```php
<?php

// No direct access
if (!defined('ABSPATH')) {
    exit;
}

return [
    'scripts' => [
        'items' => [
            [ /* item */ ],
            [ /* item */ ],
        ],
        'enqueue' => function (string $handle): bool { return 'foo' === $handle; }, // As a callback function
        'admin_enqueue' => fn (string $handle, string $hook): bool => 'post.php' === $hook && 'foo' === $handle, // As a callback
        'enqueue_priority' => 10,
        'admin_enqueue_priority' => 10,
    ],
    'styles'  => [
        'items' => [
            [ /* item */ ],
            [ /* item */ ],
        ],
        'enqueue' => [
            // Per-handle callback functions
            'foo' => function(string $handle): bool { return true; },
            'bar,baz' => function (string $handle): bool { return true; }, // Be sure 'bar' and 'baz' appear only once
        ],
        'admin_enqueue' => [
            // Per-handle callback functions
            'adm_foo' => function(string $handle, $hook): bool { return true; },
            'adm_bar,adm_baz' => fn (string $handle, $hook): bool => true, // Be sure 'bar' and 'baz' appear only once
        ],
        'enqueue_priority' => 10,
        'admin_enqueue_priority' => 10,
    ],
];

```

배열의 각 키를 설명합니다.

- `scripts`: JavaScript의 등록과 삽입을 담당합니다.
    - `scripts.items`: 스크립트 항목을 나열합니다. 각 항목은 연관 배열입니다.
        - 키 목록: `handle`, `src`, `deps`, `ver`, `args`
        - 각 키는 [`wp_enqueue_script()`](https://developer.wordpress.org/reference/functions/wp_enqueue_script/) 인수와
          대응됩니다.
        - `handle`, `src` 항목은 필수입니다.
- `styles`: CSS의 등록과 삽입을 담당합니다.
    - `styles.items`: 스타일 항목을 나열합니다. 각 항목은 연관 배열입니다.
        - 키 목록: `handle`, `src`, `deps`, `ver`, `media`
        - 각 키는 [`wp_enqueue_style()`](https://developer.wordpress.org/reference/functions/wp_enqueue_style/) 인수와 대응됩니다.
        - `handle`, `src` 항목은 필수입니다.
- `items`이외의 키는 `scripts`, `styles` 공통입니다.
    - `*.enqueue_priority`: `enqueue_scripts` 액션을 등록하는 우선순위입니다. 기본값은 10입니다.
    - `*.admin_enqueue_priority`: `admin_enqueue_scripts` 액션을 등록하는 우선순위입니다. 기본값은 10입니다.
    - `*.enqueue`: 스크립트의 프론트엔드측 삽입을 판단합니다.
        - 키의 값으로 콜백, 혹은 연관배열을 지정할 수 있습니다.
        - **콜백**: 모듈이 등록한 모든 핸들에 대해 하나의 콜백이 대응하는 형태입니다.
        - **연관배열**: 각 핸들별로 세밀하게 콜백을 지정 가능합니다. 키는 핸들입니다. 콤마를 사용하여 여러 핸들을 지정할 수 있습니다.
          이 때 키가 중복으로 입력되지 않도록 주의하시기 바랍니다. 한번 판단을 거친 핸들은 즉시 등록되며, 번복되지 않기 때문입니다.
    - `*.admin_enqueue`: 스크립트의 관리자화면측 삽입을 판단답니다.
        - 키의 값으로 콜백, 혹은 연관배열을 지정할 수 있습니다.
        - **콜백**: 모듈이 등록한 모든 핸들에 대해 하나의 콜백이 대응하는 형태입니다.
        - **연관배열**: 각 핸들별로 세밀하게 콜백을 지정 가능합니다. 키는 핸들입니다. 콤마를 사용하여 여러 핸들을 지정할 수 있습니다.
          이 때 키가 중복으로 입력되지 않도록 주의하시기 바랍니다. 한번 판단을 거친 핸들은 즉시 등록되며, 번복되지 않기 때문입니다.
    - **주의**: `enqueue`와 `admin_enqueue`의 콜백의 시그니쳐가 조금 다릅니다.

## 사용방법

### 모듈의 인스턴스화

모듈의 인스턴스를 생성하고, 생성자에 설정 배열 또는 섧정 배열을 담은 파일의 경로를 던져 주면 됩니다.

```php
$instance = new Scripts([/* ... 설정 배열 ... */]);
// 또는
$instance = new Scripts('/path/to/config/path');
```

인스턴스는 'init' 액션의 콜백에서 생성하는 것을 권장합니다.
