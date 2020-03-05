<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $color
 * @property string $createdAt
 * @property string|null $fallAt
 * @property int|null $eaten
 */
class Apples extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color'], 'required'],
            [['createdAt', 'fallAt'], 'safe'],
            [['eaten'], 'integer'],
            [['color'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'createdAt' => 'Дата создания',
            'fallAt' => 'Дата падения',
            'eaten' => 'Съедено %',
        ];
    }
}
