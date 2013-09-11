<?php

class GameController extends Controller
{
	public function actionCurstats() {
		$this->render('curstats');
	}

	public function actionHall() {
		$gamesess = Gamesess::init_gamesess();
		$h = new Hall();
		$correct = null;

		$finished = null;

		if ($gamesess) {
			$correct = Result::model()->count('gamesessid = :gamesessid AND guessprop = corrprop', array(':gamesessid' => $gamesess->id));
			$finished = ($gamesess->listpos >= count($gamesess->itemlistarr));

			if ($_POST) {
				$h->gameid = $gamesess->gameid;
				$h->name = $_POST['name'];
				$h->totalitems = count($gamesess->itemlistarr);
				$h->correct = $correct;
				$h->starttime = $gamesess->startdate;
				$h->gamesecs = strtotime($gamesess->lastupdate) - strtotime($gamesess->startdate);

				if ($h->validate()) {
					$h->save();

					unset(Yii::app()->request->cookies['gamesess']);

					$this->redirect('/game/hall');
				}
			}
		}

		$top10 = Hall::model()->findAll(array(
				'condition' => 'correct > 0',
				'order' => 'correct desc, gamesecs',
				'limit' => 10
			));
		
		$this->render('hall', array(
			'model' => $h,
			'gamesess' => $gamesess,
			'correct' => $correct,
			'top10' => $top10,
			'finished' => $finished
			));
	}

	public function actionIndex() {
		$gamesess = Gamesess::init_gamesess();

		$games = Game::model()->findAll();
		$this->render('index', array(
			'games' => $games,
			'gamesess' => $gamesess
			));
	}

	public function actionPlay() {
		$gamesess = Gamesess::init_gamesess();
		$curr_item = null;
		$prev_vote = null;

		if ($gamesess) {
			
			// there are more items to guess
			if ($gamesess->listpos < count($gamesess->itemlistarr)) {
				$curr_id = $gamesess->itemlistarr[$gamesess->listpos];
				$curr_item = Item::model()->findByPk($curr_id);
			}

			$correct = Result::model()->count('gamesessid = :gamesessid AND guessprop = corrprop', array(':gamesessid' => $gamesess->id));

			if ($gamesess->listpos > 0) {
				$prev_vote = Result::model()
					->with('item', 'guessprop0', 'corrprop0')
					->findAll(array(
						'condition' => 'gamesessid = :gamesessid',
						'params' => array(':gamesessid' => $gamesess->id),
						'order' => 'tm desc'));
			}

			$props = Prop::model()->findAll(
				'gameid = :gameid',
				array(':gameid' => (int) $gamesess->gameid)
				);
			
			$this->render('play', array(
				'curr' => $curr_item,
				'prev_vote' => $prev_vote,
				'props' => $props,
				'gamesess' => $gamesess,
				'correct' => $correct,
				));
		} else {
			$this->redirect('/game/start?gameid=1');
		}
	}

	public function actionRestart() {
		$gamesess = Gamesess::init_gamesess();
		$this->actionStart($gamesess->gameid);

		$this->redirect('/game/play');
	}

	public function actionStart($gameid) {
		if ((int) $gameid) {

			/* get randomized items list */
			$items = Item::model()->findAll('gameid = :gameid', array(':gameid' => (int) $gameid));
			$itemlist = array();
			foreach($items as $i) {
				$itemlist[] = $i->id;
			}
			shuffle($itemlist);
			$itemlist = implode(',', $itemlist);

			/* and init new game session */
			Gamesess::new_gamesess($gameid, $itemlist);

			$this->redirect('/game/play');
		}
	}

	public function actionVote($pos, $prop) {
		$gamesess = Gamesess::init_gamesess();
		if ($gamesess && $gamesess->listpos == $pos) {

			$corritem = Item::model()->findByPk($gamesess->itemlistarr[$pos]);

			$r = new Result();
			$r->gamesessid = $gamesess->id;
			$r->itemid = $gamesess->itemlistarr[$pos];
			$r->guessprop = $prop;
			$r->corrprop = $corritem->corrprop;
			$r->save();
			$gamesess->listpos = $gamesess->listpos + 1;
			$gamesess->lastupdate = new CDbExpression('NOW()');
			$gamesess->save();
			$this->redirect('/game/play');
		} else {
			// voting too fast!
			$this->redirect('/game/play');
		}
	}
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
