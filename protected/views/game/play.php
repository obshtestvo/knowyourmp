<?php /* @var $this Controller */ ?>
<div class="ccontent">
	<p><img src="<?php echo $curr->photo ?>" /></p>
	<p>
		<?php foreach ($props as $v): ?>
			<a class="btn btn-default btn-num<?=$v->id ?>" href="/game/vote?pos=<?=$gamesess->listpos ?>&prop=<?=$v->id ?>"><?=$v->name ?></a>
		<?php endforeach; ?>
	</p>
	<p>Познали сте <?=$correct ?> и ви остават <?=count($gamesess->itemlistarr) - $gamesess->listpos ?> депутата</p>
	<p><a class="btn btn-primary" href="/game/hall">Не мога повече, към класирането</a></p>
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
