<?php

/**
 * This is the model class for table "invitation".
 *
 * The followings are the available columns in table 'invitation':
 * @property integer $id
 * @property string $invitation_key
 * @property string $type
 * @property string $type_id
 * @property string $type_data
 * @property integer $user_id
 * @property integer $new_user
 * @property integer $inviter
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $inviter0
 */
class Invitation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invitation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invitation_key, type, type_id, inviter, created', 'required'),
			array('user_id, new_user, inviter', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>12),
			array('type_data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invitation_key, type, type_id, type_data, user_id, new_user, inviter, created', 'safe', 'on'=>'search'),
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
			'inviter0' => array(self::BELONGS_TO, 'User', 'inviter'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invitation_key' => 'invitation_key',
			'type' => 'Type',
			'type_id' => 'Type',
			'type_data' => 'Type Data',
			'user_id' => 'User',
			'new_user' => 'New User',
			'inviter' => 'Inviter',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('invitation_key',$this->invitation_key,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('type_data',$this->type_data,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('new_user',$this->new_user);
		$criteria->compare('inviter',$this->inviter);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invitation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
