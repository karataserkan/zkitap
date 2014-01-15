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
			//array('pdf_file', 'file', 'types'=>'pdf,doc,docx'),
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
			'book_id' => 'Kitap',
			'workspace_id' => 'Çalisma Grubu',
			'title' => 'Kitap Adi',
			'author' => 'Yazar',
			'created' => 'Oluşturulma Tarihi',
			'publish_time' => 'Publish Time',
			//'pdf_file'=>'Pdf File',
			'data' => 'Data',
			'pdf_file' => 'File',
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
		$criteria->compare('pdf_file',$this->pdf_file,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function setData($attribute,$value)
	{
		$book_data=json_decode($this->data,true);
		$book_data[$attribute]=$value;
		$this->data=json_encode($book_data);
	}

	public function getData($attribute)
	{
		$bookData = json_decode($this->data,true);
		return (isset($bookData[$attribute])) ? $bookData[$attribute] : false;
	}

	public function setPdfFile($value=null)
	{
		$this->pdf_file=$value;
	}

	public function getPdfFile()
	{
		return $this->pdf_file;
	}

	public function getPageSize(){
		$bookData = json_decode($this->data,true);
		if (isset($bookData['size']['height'])&&isset($bookData['size']['width'])) {
			$bookHeight=$bookData['size']['height'];
			$bookWidth=$bookData['size']['width'];
		}
		else
		{
			$bookHeight="768";
			$bookWidth="1024";
		}
		return $bookSize = array('height'=>$bookHeight,
					'width'=>$bookWidth);
	}

	public function setPageSize($width,$height)
	{
		$book_data=json_decode($this->data,true);
		$book_data['size']['width']=$width;
		$book_data['size']['height']=$height;
		$this->data=json_encode($book_data);
	}

}