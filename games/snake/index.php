<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /NexPLAY/login");
    exit();
}
include '../../includes/head.php'; 
include '../../includes/nav.php'; 
?>

<div class="container my-5 text-center flex-grow-1 d-flex flex-column align-items-center justify-content-center">
    <div class="glass-panel" style="max-width: 600px; width: 100%;">
        <div class="row align-items-center mb-3">
            <div class="col-3 text-start">
                <a href="/NexPLAY/" class="btn btn-sm btn-outline-info"><i class="bi bi-arrow-left"></i> Hub</a>
            </div>
            <div class="col-6">
                <h2 class="text-success text-uppercase fw-bold m-0"><i class="bi bi-heptagon-half"></i> Snake</h2>
            </div>
            <div class="col-3 text-end">
                <span class="badge bg-success p-2">Score: <span id="score">0</span></span>
            </div>
        </div>
        
        <canvas id="gameCanvas" width="400" height="400" class="border border-success rounded w-100" style="background-color: #001a00; max-width: 400px; box-shadow: 0 0 15px rgba(0,255,102,0.2);"></canvas>
        
        <div class="mt-4">
            <button id="startBtn" class="btn btn-success fw-bold px-4">START GAME</button>
            <p class="text-secondary small mt-3">Use ARROW KEYS to move.</p>
        </div>
    </div>
</div>

<script>
    const canvas = document.getElementById("gameCanvas");
    const ctx = canvas.getContext("2d");
    const scoreEl = document.getElementById("score");
    const startBtn = document.getElementById("startBtn");

    const box = 20;
    let snake = [];
    let food = {};
    let score = 0;
    let d = "";
    let game;

    function init() {
        snake = [];
        snake[0] = { x: 9 * box, y: 10 * box };
        spawnFood();
        score = 0;
        d = "";
        scoreEl.innerText = score;
    }

    function spawnFood() {
        food = {
            x: Math.floor(Math.random() * 19 + 1) * box,
            y: Math.floor(Math.random() * 19 + 1) * box
        };
    }

    document.addEventListener("keydown", direction);
    function direction(event) {
        if (event.keyCode == 37 && d != "RIGHT") d = "LEFT";
        else if (event.keyCode == 38 && d != "DOWN") d = "UP";
        else if (event.keyCode == 39 && d != "LEFT") d = "RIGHT";
        else if (event.keyCode == 40 && d != "UP") d = "DOWN";
    }

    function collision(head, array) {
        for (let i = 0; i < array.length; i++) {
            if (head.x == array[i].x && head.y == array[i].y) return true;
        }
        return false;
    }

    function draw() {
        ctx.fillStyle = "#001a00";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        for (let i = 0; i < snake.length; i++) {
            ctx.fillStyle = (i == 0) ? "#00ff66" : "#00cc52";
            ctx.fillRect(snake[i].x, snake[i].y, box, box);
            ctx.strokeStyle = "#0d0f1a";
            ctx.strokeRect(snake[i].x, snake[i].y, box, box);
        }

        ctx.fillStyle = "red";
        ctx.fillRect(food.x, food.y, box, box);

        let snakeX = snake[0].x;
        let snakeY = snake[0].y;

        if (d == "LEFT") snakeX -= box;
        if (d == "UP") snakeY -= box;
        if (d == "RIGHT") snakeX += box;
        if (d == "DOWN") snakeY += box;

        if (snakeX == food.x && snakeY == food.y) {
            score++;
            scoreEl.innerText = score;
            spawnFood();
        } else {
            snake.pop();
        }

        let newHead = { x: snakeX, y: snakeY };

        if (snakeX < 0 || snakeX >= canvas.width || snakeY < 0 || snakeY >= canvas.height || collision(newHead, snake)) {
            clearInterval(game);
            ctx.fillStyle = "white";
            ctx.font = "40px Inter";
            ctx.fillText("GAME OVER", canvas.width / 4, canvas.height / 2);
            startBtn.disabled = false;
            startBtn.innerText = "PLAY AGAIN";
            return;
        }

        snake.unshift(newHead);
    }

    startBtn.addEventListener("click", () => {
        init();
        if (game) clearInterval(game);
        game = setInterval(draw, 100);
        startBtn.disabled = true;
    });

    init();
    draw();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
