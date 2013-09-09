<?php
/* @var $this GameController */
?>

<div class="jumbotron">
	<h1>Познавате ли депутатите?</h1>
	<p>Познайте от коя партия е депутатът на снимката</p>
	<?php if ($gamesess): ?>
		<p><a class="btn btn-lg btn-success" href="/game/start?gameid=1">Започнете нова игра</a></p>
		<p>или</p>
		<p><a class="btn btn-lg btn-primary" href="/game/play">Продължете играта</a></p>
	<?php else: ?>
		<p><a class="btn btn-lg btn-success" href="/game/start?gameid=1">Нова игра</a></p>
	<?php endif; ?>

</div>

<h2>Каква е тази игра?</h2>
<p>Кои са хората, които ви управляват, знаете ли? Рядко виждаме лицата на повечето от тях извън предизборните кампании. А е добре да ги познаваме. Най-малкото за да можем да отидем при тях докато вечерят спокойно и да им поискаме обяснение. Или да им стиснем ръката. Което от двете са си заслужили.</p>
<p>Тази игра ви показва лицата на депутатите и условието й е просто: да познаете от коя партия е всеки народен представител.</p>
<p>Разработена е от Камен, в свободното му време и всеки е добре дошъл да се включи в доработката й. Кодът е отворен и достъпен в Джитхюб.</p>
