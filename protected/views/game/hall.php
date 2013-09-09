<?php /* @var $this GameController */ ?>
<h1>Класиране</h1>

<?php if ($gamesess):?>
<div class="form">
	<?php if ($finished): ?>
		<h2>ЧЕСТИТО, вие приключихте играта</h2>
	<?php else: ?>
		<h2>Не се отказвайте толкова рано!</h2>
	<?php endif; ?>
	<p>Познали сте партиите на <strong><?=$correct ?></strong> от <?=$totalitems ?> депутата или <?=round(($correct / $totalitems) * 100, 2) ?>%.</p>
	<p>Започнали сте играта на <?=$gamesess->startdate ?> и сте играли <strong><?=$gamesecs ?></strong> секунди</p>
	<p>За да се запишете в класацията, моля, въведете име или псевдоним в полето.</p>

	<form role="form" method="POST">
		<div class="form-group">
			<label for="name">Име</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Име или псевдоним">
		</div>
		<p><button type="submit" class="btn btn-primary">Запазване</button></p>
		<?php if (!$finished): ?>
			<p><a class="btn btn-success" href="/game/play">Размислих, ще играя още</a></p>
		<?php else: ?>
			<p><a class="btn btn-success" href="/game/start?gameid=1">Започни нова игра</a></p>
		<?php endif; ?>
	</form>
	
</div>
<?php endif; ?>

<h2>ТОП 10 по средно време на познат</h2>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Позиция</th>
			<th>Име</th>
			<th>Брой познати</th>
			<th>Време за игра</th>
			<th>Начало на играта</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($top10_1 as $k => $v): ?>
			<tr>
				<td><?=($k+1) ?></td>
				<td><?=CHtml::encode($v->name) ?></td>
				<td><?=$v->correct ?> / <?=$v->totalitems ?></td>
				<td><?=$v->gamesecs ?></td>
				<td><?=$v->starttime ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h2>ТОП 10 по брой познати</h2>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Позиция</th>
			<th>Име</th>
			<th>Брой познати</th>
			<th>Време за игра</th>
			<th>Начало на играта</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($top10_2 as $k => $v): ?>
			<tr>
				<td><?=($k+1) ?></td>
				<td><?=CHtml::encode($v->name) ?></td>
				<td><?=$v->correct ?> / <?=$v->totalitems ?></td>
				<td><?=$v->gamesecs ?></td>
				<td><?=$v->starttime ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
