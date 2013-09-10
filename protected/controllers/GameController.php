<?php

class GameController extends Controller
{
	public function actionCurstats() {
		$this->render('curstats');
	}

	public function actionHall() {
		$gamesess = Gamesess::init_gamesess();
		$h = new Hall();
		$totalitems = null;
		$totalvotes = null;
		$correct = null;
		$gamesecs = null;

		$finished = null;

		if ($gamesess) {
			$totalitems = count($gamesess->itemlistarr);
			$totalvotes = $gamesess->listpos;
			$correct = Result::model()->count('gamesessid = :gamesessid AND guessprop = corrprop', array(':gamesessid' => $gamesess->id));
			$gamesecs = strtotime($gamesess->lastupdate) - strtotime($gamesess->startdate);
			$finished = ($gamesess->listpos >= count($gamesess->itemlistarr));

			if ($_POST) {
				$h->gameid = $gamesess->gameid;
				$h->name = $_POST['name'];
				$h->totalitems = $totalitems;
				$h->totalvotes = $totalvotes;
				$h->correct = $correct;
				$h->starttime = $gamesess->startdate;
				$h->gamesecs = $gamesecs;

				if ($h->validate()) {
					$h->save();

					unset(Yii::app()->request->cookies['gamesess']);

					$this->redirect('/game/hall');
				}
			}
		}

		$top10_1 = Hall::model()->findAll(array(
				'condition' => 'correct > 0',
				'order' => '(gamesecs / correct)',
				'limit' => 10
			));

		$top10_2 = Hall::model()->findAll(array(
				'order' => '(correct / totalitems) DESC',
				'limit' => 10
			));

		$this->render('hall', array(
			'model' => $h,
			'gamesess' => $gamesess,
			'totalitems' => $totalitems,
			'totalvotes' => $totalvotes,
			'correct' => $correct,
			'gamesecs' => $gamesecs,
			'top10_1' => $top10_1,
			'top10_2' => $top10_2,
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

		if ($gamesess) {
			if ($gamesess->listpos >= count($gamesess->itemlistarr)) {
				$this->redirect('/game/hall');
			}

			$curr = $gamesess->itemlistarr[$gamesess->listpos];

			$curr_item = Item::model()->findByPk($curr);

			$prev_vote = null;

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

			// Tell the browser to never cache this page
			header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
			header("Pragma: no-cache"); //HTTP 1.0
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

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
