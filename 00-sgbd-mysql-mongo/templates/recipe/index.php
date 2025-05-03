<?php
require_once __DIR__ . '/../../src/handlers/recipe/index.php';
?>
<div href="#" class="list-group-item list-group-item-action flex-column align-items-start mt-3 mb-3 container w-50 p-3 border rounded shadow-sm bg-light flex flex-column gap-3 ">

    <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1"><?php echo  $recipe['title'] ?></h5>
        <small class="text-muted" id="average-score"></small>
    </div>
    <p> <?php echo $recipe['image'] ?? 'there shouldbe image'; ?></p>
    <p class="mb-1">Описание: <?php echo $recipe['description']; ?></p>
    <p>Тэги: <?php echo join(', ', $recipe['tags']) ?></p>
    <p>Категории: <?php echo $recipe['name']; ?></p>
    <p>Ингридиенты: <?php echo $recipe['ingredients']; ?></p>
    <p>Шаги приготовления:</p>
    <ul class="list-group">
        <?php foreach ($recipe['steps'] as $step): ?>
            <li class="list-group-item"><?php echo $step; ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="justify-content-between">
        <a class="btn btn-warning mt-2" href="/recipe/<?php echo $recipe['id'] ?>/edit">Изменить рецепт</a>
        <a class="btn btn-danger mt-2" href="/recipe/<?php echo $recipe['id'] ?>/delete">Удалить рецепт</a>
    </div>


    <h4 class="mt-4">Комментарии</h4>
    <div id="comments-container"></div>
    <form id="comment-form" class="mt-" method="post" action="">
        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
        <div class="mb-2">
            <input type="text" name="name" placeholder="Ваше имя" class="form-control" required>
        </div>
        <div class="mb-2">
            <input type="email" name="email" placeholder="Email" class="form-control" required>
        </div>
        <div class="mb-2">
            <textarea name="content" placeholder="Комментарий" class="form-control" required></textarea>
        </div>
        <div class="mb-2">
            <input type="number" name="score" min="1" max="10" placeholder="Оценка (1–10)" class="form-control">
        </div>
        <button type="submit" class="btn btn-warning">Отправить</button>
    </form>

    <script>
        const recipeId = "<?php echo $recipe['id']; ?>";
        const commentsContainer = document.getElementById('comments-container');
        const averageScore = document.getElementById('average-score');
        const apiBase = 'http://localhost:8080/api/comments';

        async function fetchComments(recipeId) {
            const res = await fetch(`${apiBase}/${recipeId}`);
            return await res.json();
        }

        async function fetchAverageScore(recipeId) {
            const res = await fetch(`${apiBase}/${recipeId}/score`);
            return await res.json();
        }

        async function createComment(data) {
            const res = await fetch('http://localhost:8080/api/comments/' + recipeId, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            return res.ok;
        }

        async function deleteCommentById(id) {
            const res = await fetch('http://localhost:8080/api/comments/' + id, {
                method: 'DELETE',
                body: JSON.stringify({
                    id
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            return res.ok;
        }

        async function loadComments() {
            const res = await fetch(`${apiBase}/${recipeId}`);
            const comments = await res.json();
            commentsContainer.innerHTML = comments.map(c => `
        <div class="border p-2 mb-2" id="comment-${c.id}">
            <p><strong>${c.name}</strong> (${c.email}) — Оценка: ${c.score ?? '-'}</p>
            <p>${c.content}</p>
            <button onclick="deleteComment('${c.id}')" class="btn btn-sm btn-danger">Удалить</button>
            <button onclick="toggleEditForm('${c.id}')" class="btn btn-sm btn-success">Изменить</button>
            
            <form id="edit-form-${c.id}" class="mt-2" style="display: none;" onsubmit="handleUpdate(event, '${c.id}')">
                <input type="hidden" name="recipe_id" value="${c.recipeId}">
                <div class="mb-2">
                    <input type="text" name="name" value="${c.name}" class="form-control" required>
                </div>
                <div class="mb-2">
                    <input type="email" name="email" value="${c.email}" class="form-control" required>
                </div>
                <div class="mb-2">
                    <textarea name="content" class="form-control" required>${c.content}</textarea>
                </div>
                <div class="mb-2">
                    <input type="number" name="score" min="1" max="10" value="${c.score ?? ''}" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning">Сохранить</button>
            </form>
        </div>
    `).join('');
        }

        function toggleEditForm(commentId) {
            const form = document.getElementById(`edit-form-${commentId}`);
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        async function handleUpdate(event, commentId) {
            event.preventDefault();
            const form = document.getElementById(`edit-form-${commentId}`);
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            if (data.score) {
                data.score = parseInt(data.score, 10);
            }

            const res = await fetch(`${apiBase}/${commentId}`, {
                method: 'PUT',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (res.ok) {
                await loadComments();
                await loadAverageScore();
            }
        }


        async function loadAverageScore() {
            const data = await fetchAverageScore(recipeId);
            averageScore.textContent = `(средняя оценка: ${data.averageScore.toFixed(1)})`;
        }

        async function handleDelete(id) {
            const success = await deleteCommentById(id);
            if (success) {
                await loadComments();
                await loadAverageScore();
            } else {
                alert('Ошибка при удалении комментария.');
            }
        }

        document.getElementById('comment-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                content: formData.get('content'),
                score: formData.get('score') ? parseInt(formData.get('score'), 10) : null,
                recipe_id: formData.get('recipe_id')

            };
            const success = await createComment(data);
            if (success) {
                this.reset();
                await loadComments();
                await loadAverageScore();
            } else {
                alert('Не удалось отправить комментарий.');
            }
        });

        loadComments();
        loadAverageScore();
    </script>

</div>