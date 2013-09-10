<?php /* @var $this Controller */ ?>
<div class="ccontent">
	<?php if ($curr): ?>
		<p><img src="<?php echo $curr->photo ?>" width="150" height="190" /></p>
		<p><small><?=$curr->name ?></small></p>
		<p>
			<?php foreach ($props as $v): ?>
				<a class="btn btn-default btn-num<?=$v->id ?>" href="/game/vote?pos=<?=$gamesess->listpos ?>&prop=<?=$v->id ?>"><?=$v->name ?></a>
			<?php endforeach; ?>
		</p>
		
		<?php if ($prev_vote):
			if ($prev_vote[0]->corrprop0->name == $prev_vote[0]->guessprop0->name): ?>
				<p>Последно познахте че <?=$prev_vote[0]->item->name ?> е от <span class="label label-success"><span class="glyphicon glyphicon-ok"></span> <?=$prev_vote[0]->corrprop0->name ?></span>.</p>
			<?php else: ?>
				<p>Последно не познахте че <?=$prev_vote[0]->item->name ?> е от <span class="label label-danger"><span class="glyphicon glyphicon-remove"></span> <?=$prev_vote[0]->guessprop0->name ?></span>. Oт <span class="label label-default"><?=$prev_vote[0]->corrprop0->name ?></span> e.</p>
			<?php endif;?>
		<?php endif; ?>
		
		<?php if ($gamesess->listpos > count($gamesess->itemlistarr) * 0.05): ?>
			<p><a class="btn btn-primary" href="/game/hall">Не мога повече, към класирането!</a></p>
		<?php endif; ?>
		<p>Познали сте <strong><?=$correct ?> от <?=$gamesess->listpos ?></strong> (или <?=round(($correct / count($gamesess->itemlistarr)) * 100, 2) ?>%) и ви остават <?=count($gamesess->itemlistarr) - $gamesess->listpos ?> депутата</p>
		
	<?php else: ?>
		<h1>ПОЗДРАВЛЕНИЯ!</h1>
		<h2>Вие преминахте през всичките <?php echo count($gamesess->itemlistarr) ?> депутата</h2>
		
		<?php $this->renderPartial('_mystat', array('correct' => $correct, 'gamesess' => $gamesess)); ?>
		
		<p><a class="btn btn-success" href="/game/hall">Запишете този резултат в класацията</a></p>
		<p>или</p>
		<p><a class="btn btn-primary" href="/game/restart">Започнете нова игра</a></p>
	<?php endif; ?>
</div>

<?php if ($prev_vote): ?>
	<h3>Резултат до момента</h3>
	<table class="table">
		<thead>
			<tr>
				<th>Снимка</th>
				<th>Име</th>
				<th>Партия</th>
				<th>Според вас</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($prev_vote as $vote):?>
				<tr class="<?=($vote->corrprop0->name == $vote->guessprop0->name ? 'success' : 'danger') ?>">
					<td><img width="40" src="<?=$vote->item->photo ?>" /></td>
					<td><?=$vote->item->name ?></td>
					<td><?=$vote->corrprop0->name ?></td>
					<td><span class="label label-<?=($vote->corrprop0->name == $vote->guessprop0->name ? 'success' : 'danger') ?>"><span class="glyphicon glyphicon-<?=($vote->corrprop0->name == $vote->guessprop0->name ? 'ok' : 'remove') ?>"></span> <?=$vote->guessprop0->name ?></span></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
