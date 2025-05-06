<body class="bg-dark text-white pt-5 min-vh-75 vertical-center ">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center text-white">Вход</h2>
                <?php if (!empty($error)): ?>
                    <p class="text-danger"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <form method="post" action="/login">
                    <div class="mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Логин" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Пароль" required>
                    </div>
                    <div class="w-100">
                        <button type="submit" class="btn btn-danger w-100">Войти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>