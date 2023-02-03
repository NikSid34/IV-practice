<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/view/header.php';
?>

    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>

        <!-- Модальное окно создания отзывов -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="/api/create" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Добавить отзыв</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <label for="inputName" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="inputName" name="name" required>

                        <label for="inputText" class="form-label">Отзыв</label>
                        <textarea rows="5" cols="60" id="inputText" name="text" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
            </form>
        </div>

        <!-- Таблица -->
        <div class="row mt-3">
            Страница <?php echo htmlspecialchars($page+1) ?>/<?php echo htmlspecialchars($maxPage+1) ?>
        </div>
        <div class="row mt-3">
            <table class="table table-hover table-striped">
                <thead>
                <tr class="table-dark">
                    <th>Имя</th>
                    <th>Дата</th>
                    <th>Отзыв</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
				<?php foreach ($feedbacks as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(substr($item['name'],0,50))?></td>
                        <td><?php echo htmlspecialchars($item['datetime'])?></td>
                        <td><?php echo htmlspecialchars(substr($item['text'],0,50)); if (strlen($item['text'])>50)
                            echo ' ...' ?></td>
                        <td>
                            <form class="d-inline-block" action="/api/delete/<?php echo htmlspecialchars($item['id'])?>"
                                  method="post">
                                <button type="submit" class="btn btn-danger"><i class="fa-solid
                    fa-trash"></i>
                                </button>
                            </form>

                            <form class="d-inline-block" action="/api/feedbacks/<?php echo htmlspecialchars($item['id'])?>" method="get">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Строка пагинации -->
        <nav>
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="/api/feedbacks?page=<?php if($page != 0){echo htmlspecialchars($page-1);} else{echo 0;} ?>"
                       aria-label="Предыдущая">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="/api/feedbacks?page=<?php if($page != $maxPage){echo htmlspecialchars($page+1);} else{echo $maxPage;} ?>"
                       aria-label="Следующая">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>



<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/view/footer.php';
?>