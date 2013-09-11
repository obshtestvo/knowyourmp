<h2>По % познавания</h2>
<table class="table">
<thead>
	<tr>
		<th colspan="2">Депутат</th>
		<th>Партия</th>
		<th>Брой отгатвания</th>
		<th>Брой верни</th>
		<th>% познавания</th>
	</tr>
</thead>
<tbody>
<?php foreach($stats1 as $s): ?>
	<tr>
		<td><img width="40" height="51" src="<?=$s['photo'] ?>" /></td>
		<td><?=$s['name'] ?></td>
		<td><?=$s['propname'] ?></td>
		<td><?=$s['totalcnt'] ?></td>
		<td><?=$s['correct'] ?></td>
		<td><?=round($s['correct']/$s['totalcnt']*100, 2) ?></td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
