<?php

function generateAvatar()
{
    $avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();
    $image = $avatar->name('Albert Magnum')->generate();
    return $image;
}