<?php

/**
 * This is the model class for table "hall".
 *
 * The followings are the available columns in table 'hall':
 * @property integer $id
 * @property integer $gameid
 * @property string $name
 * @property integer $totalitems
 * @property integer $totalvotes
 * @property integer $correct
 * @property string $starttime
 * @property integer $gamesecs
 *
 * The followings are the available model relations:
 * @property Game $game
 */
class Hall extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hall';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gameid, totalitems, totalvotes, correct, gamesecs', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('starttime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gameid, name, totalitems, totalvotes, correct, starttime, gamesecs', 'safe', 'on'=>'search'),
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
			'game' => array(self::BELONGS_TO, 'Game', 'gameid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'gameid' => 'Gameid',
			'name' => 'Име',
			'totalitems' => 'Totalitems',
			'totalvotes' => 'Totalvotes',
			'correct' => 'Correct',
			'starttime' => 'Starttime',
			'gamesecs' => 'Gamesecs',
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
		$criteria->compare('gameid',$this->gameid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('totalitems',$this->totalitems);
		$criteria->compare('totalvotes',$this->totalvotes);
		$criteria->compare('correct',$this->correct);
		$criteria->compare('starttime',$this->starttime,true);
		$criteria->compare('gamesecs',$this->gamesecs);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Hall the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
