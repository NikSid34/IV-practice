<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/view/header.php';
?>
    <!-- Вход в аккаунт -->
<div class="container w-25 main">
    <div class="row mt-3">
        <h5 class="modal-title" id="exampleModalLabel">Воти в аккаунт</h5>
        <form class="mt-3" action="/api/login" method="post">
            <div class="mb-3">
                <label for="inputLogin" class="form-label">Логин</label>
                <input type="text" class="form-control" id="inputLogin" name="login" required>
            </div>
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="inputPassword" name="password" required>
            </div>
            <div class="mb-3 text-danger">
				<?php  if(isset($_COOKIE['error'])) echo htmlspecialchars($_COOKIE['error'])?>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
</div>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/view/footer.php';
?>