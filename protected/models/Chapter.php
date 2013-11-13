<?php

/**
 * This is the model class for table "chapter".
 *
 * The followings are the available columns in table 'chapter':
 * @property string $chapter_id
 * @property string $title
 * @property string $book_id
 * @property integer $start_page
 * @property integer $order
 * @property string $created
 * @property string $data
 */
class Chapter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Chapter the static model class
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
		return 'chapter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chapter_id, book_id', 'required'),
			array('start_page, order', 'numerical', 'integerOnly'=>true),
			array('chapter_id, book_id', 'length', 'max'=>44),
			array('title', 'length', 'max'=>255),
			array('created, data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('chapter_id, title, book_id, start_page, order, created, data', 'safe', 'on'=>'search'),
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
			'book'=>array(self::BELONGS_TO, 'Book', 'book_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'chapter_id' => 'Chapter',
			'title' => 'Title',
			'book_id' => 'Book',
			'start_page' => 'Start Page',
			'order' => 'Order',
			'created' => 'Created',
			'data' => 'Data',
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

		$criteria->compare('chapter_id',$this->chapter_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('start_page',$this->start_page);
		$criteria->compare('order',$this->order);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}