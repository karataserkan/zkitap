<?php

/**
 * This is the model class for table "transactions".
 *
 * The followings are the available columns in table 'transactions':
 * @property string $transaction_id
 * @property string $transaction_type
 * @property string $transaction_method
 * @property string $transaction_amount
 * @property string $transaction_unit_price
 * @property string $transaction_amount_equvalent
 * @property integer $transaction_currency_code
 * @property string $transaction_start_date
 * @property string $transaction_end_date
 * @property integer $transaction_result
 * @property string $transaction_explanation
 * @property string $transaction_book_id
 * @property string $transaction_host_id
 * @property string $transaction_reader_id
 * @property integer $transaction_user_id
 * @property string $transaction_organisation_id
 * @property string $transaction_host_ip
 * @property string $transaction_remote_ip
 */
class Transactions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Transactions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transactions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_id, transaction_type, transaction_method, transaction_amount, transaction_amount_equvalent, transaction_start_date, transaction_organisation_id', 'required'),
			array('transaction_currency_code, transaction_result, transaction_user_id', 'numerical', 'integerOnly'=>true),
			array('transaction_id, transaction_reader_id', 'length', 'max'=>45),
			array('transaction_type', 'length', 'max'=>15),
			array('transaction_method, transaction_amount, transaction_unit_price, transaction_amount_equvalent', 'length', 'max'=>10),
			array('transaction_book_id, transaction_organisation_id', 'length', 'max'=>44),
			array('transaction_host_id', 'length', 'max'=>12),
			array('transaction_end_date, transaction_explanation, transaction_host_ip, transaction_remote_ip', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transaction_id, transaction_type, transaction_method, transaction_amount, transaction_unit_price, transaction_amount_equvalent, transaction_currency_code, transaction_start_date, transaction_end_date, transaction_result, transaction_explanation, transaction_book_id, transaction_host_id, transaction_reader_id, transaction_user_id, transaction_organisation_id, transaction_host_ip, transaction_remote_ip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transaction_id' => 'Transaction',
			'transaction_type' => 'Transaction Type',
			'transaction_method' => 'Transaction Method',
			'transaction_amount' => 'Transaction Amount',
			'transaction_unit_price' => 'Transaction Unit Price',
			'transaction_amount_equvalent' => 'Transaction Amount Equvalent',
			'transaction_currency_code' => 'Transaction Currency Code',
			'transaction_start_date' => 'Transaction Start Date',
			'transaction_end_date' => 'Transaction End Date',
			'transaction_result' => 'Transaction Result',
			'transaction_explanation' => 'Transaction Explanation',
			'transaction_book_id' => 'Transaction Book',
			'transaction_host_id' => 'Transaction Host',
			'transaction_reader_id' => 'Transaction Reader',
			'transaction_user_id' => 'Transaction User',
			'transaction_organisation_id' => 'Transaction Organisation',
			'transaction_host_ip' => 'Transaction Host Ip',
			'transaction_remote_ip' => 'Transaction Remote Ip',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('transaction_type',$this->transaction_type,true);
		$criteria->compare('transaction_method',$this->transaction_method,true);
		$criteria->compare('transaction_amount',$this->transaction_amount,true);
		$criteria->compare('transaction_unit_price',$this->transaction_unit_price,true);
		$criteria->compare('transaction_amount_equvalent',$this->transaction_amount_equvalent,true);
		$criteria->compare('transaction_currency_code',$this->transaction_currency_code);
		$criteria->compare('transaction_start_date',$this->transaction_start_date,true);
		$criteria->compare('transaction_end_date',$this->transaction_end_date,true);
		$criteria->compare('transaction_result',$this->transaction_result);
		$criteria->compare('transaction_explanation',$this->transaction_explanation,true);
		$criteria->compare('transaction_book_id',$this->transaction_book_id,true);
		$criteria->compare('transaction_host_id',$this->transaction_host_id,true);
		$criteria->compare('transaction_reader_id',$this->transaction_reader_id,true);
		$criteria->compare('transaction_user_id',$this->transaction_user_id);
		$criteria->compare('transaction_organisation_id',$this->transaction_organisation_id,true);
		$criteria->compare('transaction_host_ip',$this->transaction_host_ip,true);
		$criteria->compare('transaction_remote_ip',$this->transaction_remote_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}