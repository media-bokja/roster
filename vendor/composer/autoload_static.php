<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaf6eb2ac7a8f9e951512039a3d76ddf8
{
    public static $files = array (
        'a1d0faff99be8b8dfbecd731475c4a58' => __DIR__ . '/../..' . '/inc/facade.php',
        'd4a8e011848eb3eaf79e1b165101c06b' => __DIR__ . '/../..' . '/inc/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'B' => 
        array (
            'Bokja\\Roster\\' => 13,
            'Bojaghi\\ViteScripts\\' => 20,
            'Bojaghi\\Template\\' => 17,
            'Bojaghi\\SearchMeta\\' => 19,
            'Bojaghi\\Scripts\\' => 16,
            'Bojaghi\\Helper\\' => 15,
            'Bojaghi\\Fields\\' => 15,
            'Bojaghi\\FieldsRender\\' => 21,
            'Bojaghi\\CustomPosts\\' => 20,
            'Bojaghi\\Contract\\' => 17,
            'Bojaghi\\Continy\\' => 16,
            'Bojaghi\\CleanPages\\' => 19,
            'Bojaghi\\AdminAjax\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Bokja\\Roster\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
        'Bojaghi\\ViteScripts\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/vite-scripts/src',
        ),
        'Bojaghi\\Template\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/template/src',
        ),
        'Bojaghi\\SearchMeta\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/search-meta/src',
        ),
        'Bojaghi\\Scripts\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/scripts/src',
        ),
        'Bojaghi\\Helper\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/helper/src',
        ),
        'Bojaghi\\Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/fields/src',
        ),
        'Bojaghi\\FieldsRender\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/fields-render/src',
        ),
        'Bojaghi\\CustomPosts\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/custom-posts/src',
        ),
        'Bojaghi\\Contract\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/contract/src',
        ),
        'Bojaghi\\Continy\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/continy/src',
        ),
        'Bojaghi\\CleanPages\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/clean-pages/src',
        ),
        'Bojaghi\\AdminAjax\\' => 
        array (
            0 => __DIR__ . '/..' . '/bojaghi/admin-ajax/src',
        ),
    );

    public static $classMap = array (
        'Bokja\\Roster\\Modules\\AdminAjax' => __DIR__ . '/../..' . '/inc/Modules/AdminAjax.php',
        'Bokja\\Roster\\Modules\\AdminEdit' => __DIR__ . '/../..' . '/inc/Modules/AdminEdit.php',
        'Bokja\\Roster\\Modules\\AdminMenu' => __DIR__ . '/../..' . '/inc/Modules/AdminMenu.php',
        'Bokja\\Roster\\Modules\\AdminPost' => __DIR__ . '/../..' . '/inc/Modules/AdminPost.php',
        'Bokja\\Roster\\Modules\\Options' => __DIR__ . '/../..' . '/inc/Modules/Options.php',
        'Bokja\\Roster\\Modules\\PostMeta' => __DIR__ . '/../..' . '/inc/Modules/PostMeta.php',
        'Bokja\\Roster\\Modules\\ProfileImage' => __DIR__ . '/../..' . '/inc/Modules/ProfileImage.php',
        'Bokja\\Roster\\Modules\\RosterApi' => __DIR__ . '/../..' . '/inc/Modules/RosterApi.php',
        'Bokja\\Roster\\Modules\\UserMeta' => __DIR__ . '/../..' . '/inc/Modules/UserMeta.php',
        'Bokja\\Roster\\Objects\\Profile' => __DIR__ . '/../..' . '/inc/Objects/Profile.php',
        'Bokja\\Roster\\Supports\\EditForm' => __DIR__ . '/../..' . '/inc/Supports/EditForm.php',
        'Bokja\\Roster\\Supports\\FrontPage' => __DIR__ . '/../..' . '/inc/Supports/FrontPage.php',
        'Bokja\\Roster\\Supports\\ImageSupport' => __DIR__ . '/../..' . '/inc/Supports/ImageSupport.php',
        'Bokja\\Roster\\Supports\\RosterList' => __DIR__ . '/../..' . '/inc/Supports/RosterList.php',
        'Bokja\\Roster\\Supports\\SettingsPage' => __DIR__ . '/../..' . '/inc/Supports/SettingsPage.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\AdminAjax\\AdminAjax' => __DIR__ . '/..' . '/bojaghi/admin-ajax/src/AdminAjax.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\AdminAjax\\AdminPost' => __DIR__ . '/..' . '/bojaghi/admin-ajax/src/AdminPost.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\AdminAjax\\SubmitBase' => __DIR__ . '/..' . '/bojaghi/admin-ajax/src/SubmitBase.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\CleanPages\\CleanPages' => __DIR__ . '/..' . '/bojaghi/clean-pages/src/CleanPages.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Continy\\Continy' => __DIR__ . '/..' . '/bojaghi/continy/src/Continy.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Continy\\ContinyException' => __DIR__ . '/..' . '/bojaghi/continy/src/ContinyException.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Continy\\ContinyFactory' => __DIR__ . '/..' . '/bojaghi/continy/src/ContinyFactory.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Continy\\ContinyNotFoundException' => __DIR__ . '/..' . '/bojaghi/continy/src/ContinyNotFoundException.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Contract\\Container' => __DIR__ . '/..' . '/bojaghi/contract/src/Container.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Contract\\Module' => __DIR__ . '/..' . '/bojaghi/contract/src/Module.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Contract\\Support' => __DIR__ . '/..' . '/bojaghi/contract/src/Support.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\CustomPosts\\CustomPosts' => __DIR__ . '/..' . '/bojaghi/custom-posts/src/CustomPosts.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\FieldsRender\\AdminCompound' => __DIR__ . '/..' . '/bojaghi/fields-render/src/AdminCompound.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\FieldsRender\\AdminFormTable' => __DIR__ . '/..' . '/bojaghi/fields-render/src/AdminFormTable.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\FieldsRender\\Filter' => __DIR__ . '/..' . '/bojaghi/fields-render/src/Filter.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\FieldsRender\\Render' => __DIR__ . '/..' . '/bojaghi/fields-render/src/Render.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Fields\\Meta\\Meta' => __DIR__ . '/..' . '/bojaghi/fields/src/Meta/Meta.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Fields\\Meta\\MetaFactory' => __DIR__ . '/..' . '/bojaghi/fields/src/Meta/MetaFactory.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Fields\\Modules\\CustomFields' => __DIR__ . '/..' . '/bojaghi/fields/src/Modules/CustomFields.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Fields\\Modules\\Options' => __DIR__ . '/..' . '/bojaghi/fields/src/Modules/Options.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Fields\\Option\\Option' => __DIR__ . '/..' . '/bojaghi/fields/src/Option/Option.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Fields\\Option\\OptionFactory' => __DIR__ . '/..' . '/bojaghi/fields/src/Option/OptionFactory.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Helper\\Facades' => __DIR__ . '/..' . '/bojaghi/helper/src/Facades.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Helper\\Helper' => __DIR__ . '/..' . '/bojaghi/helper/src/Helper.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Scripts\\Script' => __DIR__ . '/..' . '/bojaghi/scripts/src/Script.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\SearchMeta\\SearchMeta' => __DIR__ . '/..' . '/bojaghi/search-meta/src/SearchMeta.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\Template\\Template' => __DIR__ . '/..' . '/bojaghi/template/src/Template.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\ViteScripts\\Localize' => __DIR__ . '/..' . '/bojaghi/vite-scripts/src/Localize.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\ViteScripts\\MountNode' => __DIR__ . '/..' . '/bojaghi/vite-scripts/src/MountNode.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\ViteScripts\\TagHelper' => __DIR__ . '/..' . '/bojaghi/vite-scripts/src/TagHelper.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\ViteScripts\\ViteManifest' => __DIR__ . '/..' . '/bojaghi/vite-scripts/src/ViteManifest.php',
        'Bokja\\Roster\\Vendor\\Bojaghi\\ViteScripts\\ViteScript' => __DIR__ . '/..' . '/bojaghi/vite-scripts/src/ViteScript.php',
        'Bokja\\Roster\\Vendor\\Psr\\Container\\ContainerExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerExceptionInterface.php',
        'Bokja\\Roster\\Vendor\\Psr\\Container\\ContainerInterface' => __DIR__ . '/..' . '/psr/container/src/ContainerInterface.php',
        'Bokja\\Roster\\Vendor\\Psr\\Container\\NotFoundExceptionInterface' => __DIR__ . '/..' . '/psr/container/src/NotFoundExceptionInterface.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaf6eb2ac7a8f9e951512039a3d76ddf8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaf6eb2ac7a8f9e951512039a3d76ddf8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitaf6eb2ac7a8f9e951512039a3d76ddf8::$classMap;

        }, null, ClassLoader::class);
    }
}
