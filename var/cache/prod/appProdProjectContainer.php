<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerMwnh6kq\appProdProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerMwnh6kq/appProdProjectContainer.php') {
    touch(__DIR__.'/ContainerMwnh6kq.legacy');

    return;
}

if (!\class_exists(appProdProjectContainer::class, false)) {
    \class_alias(\ContainerMwnh6kq\appProdProjectContainer::class, appProdProjectContainer::class, false);
}

return new \ContainerMwnh6kq\appProdProjectContainer(array(
    'container.build_hash' => 'Mwnh6kq',
    'container.build_id' => '0117fb27',
    'container.build_time' => 1546647721,
), __DIR__.\DIRECTORY_SEPARATOR.'ContainerMwnh6kq');
