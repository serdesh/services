<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%zakaz}}".
 *
 * @property int $zak_invoice_id
 * @property int $zak_product_id
 * @property double $zak_price
 * @property int $zak_count
 *
 * @property Invoice $zakInvoice
 * @property Product $zakProduct
 */
class Zakaz extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zakaz}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zak_invoice_id', 'zak_product_id', 'zak_price'], 'required'],
            [['zak_invoice_id', 'zak_product_id', 'zak_count'], 'integer'],
            [['zak_price'], 'number'],
            [['zak_invoice_id', 'zak_product_id'], 'unique', 'targetAttribute' => ['zak_invoice_id', 'zak_product_id']],
            [['zak_invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['zak_invoice_id' => 'inv_id']],
            [['zak_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['zak_product_id' => 'prod_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zak_invoice_id' => 'Код счета фактуры',
            'zak_product_id' => 'Код продукта',
            'zak_price' => 'Цена',
            'zak_count' => 'Кол-во',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakInvoice()
    {
        return $this->hasOne(Invoice::className(), ['inv_id' => 'zak_invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakProduct()
    {
        return $this->hasOne(Product::className(), ['prod_id' => 'zak_product_id']);
    }
}
