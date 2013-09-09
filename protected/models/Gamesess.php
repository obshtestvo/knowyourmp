<?php

/**
 * This is the model class for table "gamesess".
 *
 * The followings are the available columns in table 'gamesess':
 * @property string $id
 * @property integer $gameid
 * @property string $startdate
 * @property string $lastupdate
 * @property string $itemlist
 * @property integer $listpos
 *
 * The followings are the available model relations:
 * @property Game $game
 * @property Result[] $results
 */
class Gamesess extends CActiveRecord
{
	
	public $itemlistarr;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gamesess';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('gameid, listpos', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>100),
			array('itemlist', 'length', 'max'=>2000),
			array('startdate, lastupdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gameid, startdate, lastupdate, itemlist, listpos', 'safe', 'on'=>'search'),
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
			'results' => array(self::HAS_MANY, 'Result', 'gamesessid'),
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
			'startdate' => 'Startdate',
			'lastupdate' => 'Lastupdate',
			'itemlist' => 'Itemlist',
			'listpos' => 'Listpos',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('gameid',$this->gameid);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('lastupdate',$this->lastupdate,true);
		$criteria->compare('itemlist',$this->itemlist,true);
		$criteria->compare('listpos',$this->listpos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gamesess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/* generate new session */
	public function fill_session($gameid, $itemlist) {
		$this->id = sha1(mt_rand() . mt_rand());
		$this->gameid = $gameid;
		$this->startdate = new CDbExpression('NOW()');;
		$this->lastupdate = new CDbExpression('NOW()');
		$this->itemlist = $itemlist;
		$this->listpos = 0;
		if ($this->save()) {
			return $this->id;
		} else {
			return null;
		}
	}
	
	public static function init_gamesess() {
		$cookie = Yii::app()->request->cookies->contains('gamesess') ? Yii::app()->request->cookies['gamesess']->value : '';
		if ($cookie) {
			$gs = Gamesess::model()->findByPk($cookie);
			if ($gs) {
				$gs->itemlistarr = explode(',', $gs->itemlist);
				return $gs;
			} else {
				unset(Yii::app()->request->cookies['gamesess']);
			}
		}
		return null;
	}
	
	public static function new_gamesess($gameid, $itemlist) {
		$s = new Gamesess();
		$gamesessid = $s->fill_session($gameid, $itemlist);
		
		Yii::app()->request->cookies['gamesess'] = new CHttpCookie('gamesess', $gamesessid, array('expire' => time()+(24*60*60), 'path' => '/'));
		return $gamesessid;
	}
}
