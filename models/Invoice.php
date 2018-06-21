<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%invoice}}".
 *
 * @property int $inv_id
 * @property string $inv_number
 * @property string $inv_data
 *
 * @property Zakaz[] $zakazs
 * @property Product[] $zakProducts
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inv_number', 'inv_data', 'inv_seller_id'], 'required'],
            [['inv_data'], 'safe'],
            [['inv_number'], 'string', 'max' => 128],
            [['inv_seller_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'inv_id' => 'Код',
            'inv_number' => 'Номер',
            'inv_data' => 'Дата',
            'inv_seller_id' => 'Код продавца'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakazs()
    {
        return $this->hasMany(Zakaz::className(), ['zak_invoice_id' => 'inv_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZakProducts()
    {
        return $this->hasMany(Product::className(), ['prod_id' => 'zak_product_id'])->viaTable('{{%zakaz}}', ['zak_invoice_id' => 'inv_id']);
    }
}
