<?php

namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;
use yii\image\drivers\Image;

class FileBehavior extends Behavior
{
    public $options;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveUploads',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveUploads',
        ];
    }

    public function saveUploads()
    {
        foreach ($this->options as $key => $value) {
            if ($this->owner->$key) {
                $name = $value['name'];
                $type = $value['type'];

                BaseFileHelper::createDirectory(Yii::getAlias('@frontend/web') . '/upload/' . $this->getDirName() . '/' . Yii::$app->user->getId());
                $this->owner->$key->saveAs(Yii::getAlias('@frontend/web') . $this->owner->$name, true);
                $this->owner->$key = null;

                if($type == 'image'){
                    $image = Yii::$app->image->load(Yii::getAlias('@frontend/web') . $this->owner->$name);

                    if ($image->mime == 'image/jpeg') {
                        if (function_exists("exif_read_data")) {
                            $fp = fopen(Yii::getAlias('@frontend/web') . $this->owner->$name, 'rb');
                            if ($fp) {
                                $exif = @exif_read_data(Yii::getAlias('@frontend/web') . $this->owner->$name);
                                if (!empty($exif['Orientation'])) {
                                    switch ($exif['Orientation']) {
                                        case 3:
                                            $image->rotate(180);
                                            break;
                                        case 6:
                                            $image->rotate(90);
                                            break;
                                        case 8:
                                            $image->rotate(-90);
                                            break;
                                    }

                                    $image->save(Yii::getAlias('@frontend/web') . $this->owner->$name, 100);
                                }
                            }
                        }
                    }

                    //создадим миниатюру
                    BaseFileHelper::createDirectory(Yii::getAlias('@frontend/web') . '/upload/' . $this->getDirName() . '/' . Yii::$app->user->getId()."/mini");
                    if(isset($value['width']) || isset($value['height'])){
                        $tmp_array = explode('/', $this->owner->$name);
                        $name = $tmp_array[count($tmp_array)-1];
                        if(isset($value['width']) && isset($value['height'])){
                            $image->resize($value['width'], $value['height'], Image::CROP);
                        }elseif(isset($value['width'])){
                            $image->resize($value['width'], NULL, Image::WIDTH, 100);
                        }else{
                            $image->resize($value['height'], NULL, Image::HEIGHT, 100);
                        }
                    }else{
                        $image->resize(200, NULL, Image::WIDTH, 100);
                    }
                    $image->save(Yii::getAlias('@frontend/web') . '/upload/' . $this->getDirName() . '/' . Yii::$app->user->getId() . "/mini/" . $name, 100);
                }
            }
        }
    }

    public function beforeValidate()
    {
        if (isset(Yii::$app->user)) {
            if (!Yii::$app->user->getIsGuest()) {
                if (Yii::$app->request->isPost) {
                    $post = Yii::$app->request->post();

                    $modelClass = $this->owner;
                    $name = str_replace("\\", "/", $modelClass::className());
                    $array = explode('/', $name);
                    $class = $array[count($array) - 1];

                    foreach ($this->options as $key => $value){
                        $name = $value['name'];

                        //удаление фото
                        if (isset($post[$class][$key])) {
                            if ($post[$class][$key] == 'delete') $this->owner->$name = null;
                        }

                        //добавление фото
                        $this->owner->$key = UploadedFile::getInstance($this->owner, $key);
                        if ($this->owner->$key) {
                            $time = substr(time(), 0, -2);
                            $this->owner->$name = '/upload/' . $this->getDirName() . '/' . Yii::$app->user->getId() . "/" . strtolower($this->owner->$key->basename) . $time . '.' . $this->owner->$key->extension;
                        }
                    }


                }
            }
        }
    }

    protected function getDirName()
    {
        $modelClass = $this->owner;
        $name = str_replace("\\", "/", $modelClass::className());
        $array = explode('/', $name);

        return strtolower($array[count($array) - 1]);
    }


}