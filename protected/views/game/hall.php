<?php /* @var $this GameController */ ?>
<h1>Класиране</h1>

<?php if ($gamesess):?>
	<?php if ($gamesess->listpos > count($gamesess->itemlistarr) * 0.05):?>
	<div class="form">
		<?php if ($finished): ?>
			<h2>ЧЕСТИТО, вие приключихте играта</h2>
		<?php else: ?>
			<h2>Не се отказвайте толкова рано!</h2>
		<?php endif; ?>
		
		<?php $this->renderPartial('_mystat', array('correct' => $correct, 'gamesess' => $gamesess)); ?>
		
		<p>За да се запишете в класацията, моля, въведете име или псевдоним в полето.</p>
	
		<form role="form" method="POST">
			<div class="form-group">
				<label for="name">Име</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Име или псевдоним">
			</div>
			<p><button type="submit" class="btn btn-success">Запазване</button></p>
			<?php if (!$finished): ?>
				<p><a class="btn btn-primary" href="/game/play">Размислих, ще играя още</a></p>
			<?php else: ?>
				<p><a class="btn btn-primary" href="/game/start?gameid=1">Започни нова игра</a></p>
			<?php endif; ?>
		</form>
		<p>
			<a href="https://twitter.com/intent/tweet?button_hashtag=mpbook&text=<?=urlencode('Познах от коя партия са ' . $correct . ' от ' . $gamesess->listpos . ' депутата в играта "Опознай депутата"') ?>" class="twitter-hashtag-button" data-size="large" data-url="http://mpbook.obshtestvo.bg/">Tweet #mpbook</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</p>
	</div>
	<?php else: ?>
	<p>За да се запишете в класацията трябва да поиграете още малко.</p>
	<p><a href="/game/play" class="btn btn-primary">Обратно към играта</a></p>
	<?php endif; ?>
<?php endif; ?>

<h2>ТОП 10</h2>

<table class="table table-striped">
	<thead>
		<tr>
			<th>№</th>
			<th>Име</th>
			<th>Познати</th>
			<th>Време (сек.)</th>
			<th>Дата</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($top10 as $k => $v): ?>
			<tr>
				<td><?=($k+1) ?></td>
				<td><strong><?=CHtml::encode($v->name) ?></strong></td>
				<td><?=$v->correct ?></td>
				<td><?=$v->gamesecs ?></td>
				<td><?=$v->starttime ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
