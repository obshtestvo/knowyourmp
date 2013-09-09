<?php

/**
 * This is the model class for table "prop".
 *
 * The followings are the available columns in table 'prop':
 * @property integer $id
 * @property integer $gameid
 * @property string $name
 * @property string $vars
 *
 * The followings are the available model relations:
 * @property Item[] $items
 * @property Game $game
 * @property Result[] $results
 * @property Result[] $results1
 */
class Prop extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prop';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gameid', 'required'),
			array('gameid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>500),
			array('vars', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gameid, name, vars', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'Item', 'corrprop'),
			'game' => array(self::BELONGS_TO, 'Game', 'gameid'),
			'results' => array(self::HAS_MANY, 'Result', 'corrprop'),
			'results1' => array(self::HAS_MANY, 'Result', 'guessprop'),
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
			'name' => 'Name',
			'vars' => 'Vars',
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
		$criteria->compare('vars',$this->vars,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Prop the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
