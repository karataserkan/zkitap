<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property string $book_id
 * @property string $workspace_id
 * @property string $title
 * @property string $author
 * @property string $created
 * @property string $publish_time
 * @property string $data
 */
class Book extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Book the static model class
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
		return 'book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('book_id, workspace_id', 'required'),
			array('book_id, workspace_id', 'length', 'max'=>44),
			array('title, author', 'length', 'max'=>255),
			array('created, publish_time, data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('book_id, workspace_id, title, author, created, publish_time, data', 'safe', 'on'=>'search'),
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
			'workspace_id'=> array(self::BELONGS_TO, 'Workspaces','workspace_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'book_id' => 'Book',
			'workspace_id' => 'Workspace',
			'title' => 'Title',
			'author' => 'Author',
			'created' => 'Created',
			'publish_time' => 'Publish Time',
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

		$criteria->compare('book_id',$this->book_id,true);
		$criteria->compare('workspace_id',$this->workspace_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('publish_time',$this->publish_time,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}