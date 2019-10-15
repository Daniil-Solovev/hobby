<?php
require_once(ROOT . '/views/layouts/header.php');

/**
 * @var $count_pages SiteController/index
 */

?>

<main>
    <div class="container">

        <button id="load" class="btn btn-info load_btn">Загрузить</button>

        <!-- Контент-->
        <div id="content" class="row">
            <?php if (!empty($articles)): ?>
                <?php foreach ($articles as $article): ?>

                    <div class="col-md-6 post">
                        <h3>
                            <a class="post_title" target="_blank" href="<?= $article['link'] ?>">
                                <?= $article['title'] ?>
                            </a>
                        </h3>
                        <p><?= truncate($article['text'], 300) ?></p>
                        <p>
                            <a data-toggle="modal" data-target="#exampleModal" class="btn btn-secondary post_read"
                               data-id="<?= $article['id'] ?>" href="#" role="button">
                                Полный текст
                            </a>
                        </p>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>

                <div class="col-md-6">
                    <p>Такой страницы не существует</p>
                </div>

            <?php endif; ?>
        </div>
        <!-- /Контент-->

        <hr>

        <!-- Пагинация-->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= intval($count_pages); $i++): ?>
                    <li class="page-item">
                        <a class="page-link" data-page="<?= $i ?>" href="/page/<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
        <!-- /Пагинация-->

    </div>
</main>

<?php require_once(ROOT . '/views/layouts/footer.php') ?>