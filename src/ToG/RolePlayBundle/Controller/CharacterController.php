<?php

namespace ToG\RolePlayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CharacterController extends Controller
{
    public function updateAvatarByAjaxAction(Request $request) {
        // $avatar = new UploadedFile($_FILES['avatar'], $_FILES['avatar']['name']);

        // $data = $_FILES['avatar'];
        $avatar = $request->files->get('avatar');

        $x   = $_POST['x'];
        $y   = $_POST['y'];
        $w   = $_POST['w'];
        $h   = $_POST['h'];

        $avatar_directory = $this->container->getParameter('characters_avatars_directory');
        $avatar_name = $this->get('app.characters_avatar_uploader')->upload($avatar);

        $src = $avatar_directory . '/' . $avatar_name;

        $targ_w = $targ_h = 150;
        $jpeg_quality = 90;

        $img_r = imagecreatefromstring(file_get_contents($src));
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

        imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);

        unlink($src);

        imagejpeg($dst_r, $src, $jpeg_quality);

        return new JsonResponse($avatar_name);
    }
}
