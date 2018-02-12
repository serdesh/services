<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $prod_id
 * @property string $prod_name
 * @property int $prod_div_id
 *
 * @property Division $prodDiv
 * @property Zakaz[] $zakazs
 * @property Invoice[] $zakInvoices
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prod_name', 'prod_div_id'], 'required'],
            [['prod_div_id'], 'integer'],
            [['prod_name'], 'string', 'max' => 128],
            [['prod_div_id'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['prod_div_id' => 'div_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prod_id' => 'ID',
            'prod_name' => 'Наименование',
            'prod_div_id' => 'Код подразделения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getProdDiv()
    {
        return $this->hasOne(Division::className(), ['div_id' => 'prod_div_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getZakazs()
    {
        return $this->hasMany(Zakaz::className(), ['zak_product_id' => 'prod_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getZakInvoices()
    {
        return $this->hasMany(Invoice::className(), ['inv_id' => 'zak_invoice_id'])->viaTable('{{%zakaz}}', ['zak_product_id' => 'prod_id']);
    }
}
