<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/view/header.php';
?>

<main class="container w-50 main mt-3">
	<div class="row bg-dark">
		<div class="row justify-content-between mt-3 text-center">
			<h4 class="modal-title whiteText">Отзыв</h4>
		</div>
		<div class="row justify-content-between mt-3">
			<div class="col-md-auto whiteText">Имя: <?php echo htmlspecialchars(substr($feedback['name'],0,50))?></div>
			<div class="col"></div>
			<div class="col-md-auto whiteText">Дата: <?php echo htmlspecialchars($feedback['datetime']) ?></div>
		</div>
	</div>
	<div class="row bg-light">
		<div class="row mt-3">
            <p style="word-break: break-all"><?php echo htmlspecialchars($feedback['text']) ?></p>
		</div>
	</div>
</main>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/view/footer.php';
?>
