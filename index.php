<?php 
require_once __DIR__ . '/config/init.php'; 
include 'includes/head.php'; 
include 'includes/nav.php'; 
?>

<!-- 1. Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title text-uppercase mb-3">Play. Compete. Level Up.</h1>
        <p class="lead text-secondary mb-5" style="font-size: 1.25rem;">Explore fun JavaScript mini-games built for speed & skill.</p>
        <a href="#featured-games" class="btn btn-cyber btn-lg px-5 shadow-lg" style="font-size: 1.2rem;">Play Now <i class="bi bi-arrow-down-circle ms-2"></i></a>
    </div>
</section>

<!-- 7. Updates / News Section -->
<section class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="glass-panel py-3 px-4 d-inline-block update-badge border-info shadow-sm rounded-pill">
                <span class="text-info fw-bold"><i class="bi bi-fire text-danger"></i> 🔥 New: Multiplayer Snake Added!</span>
                <span class="text-secondary mx-3">|</span>
                <span class="text-success fw-bold"><i class="bi bi-lightning-charge-fill text-warning"></i> ⚡ Performance Improved.</span>
            </div>
        </div>
    </div>
</section>

<!-- 2. Featured Games Section -->
<section id="featured-games" class="container my-5 pt-4">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold" style="color: var(--text-color);">Featured Games</h2>
        <p class="text-secondary">Jump into the action immediately.</p>
    </div>
    
    <div class="row g-4 justify-content-center">
        <!-- Snake -->
        <div class="col-md-6 col-lg-4">
            <div class="game-card-hover d-flex flex-column h-100">
                <div class="game-thumb d-flex justify-content-center align-items-center mb-3" style="background: linear-gradient(135deg, rgba(0, 153, 51, 0.4), rgba(0, 51, 0, 0.4)); border-radius: 12px; height: 160px; border: 1px solid var(--card-border);">
                    <i class="bi bi-heptagon-half text-success display-1"></i>
                </div>
                <h3 class="game-title text-uppercase" style="color: #00ff66;">Snake 🐍</h3>
                <p class="text-secondary small flex-grow-1 mt-2">The classic fast-paced action game. Survive by eating and growing without hitting boundaries!</p>
                <a href="/NexPLAY/games/snake/" class="btn btn-cyber mt-3 w-100" style="background: linear-gradient(45deg, #00b33c, #009933);">Play Now <i class="bi bi-play-fill ms-1"></i></a>
            </div>
        </div>

        <!-- TicTacToe -->
        <div class="col-md-6 col-lg-4">
            <div class="game-card-hover d-flex flex-column h-100">
                <div class="game-thumb d-flex justify-content-center align-items-center mb-3" style="background: linear-gradient(135deg, rgba(51, 102, 255, 0.4), rgba(0, 0, 102, 0.4)); border-radius: 12px; height: 160px; border: 1px solid var(--card-border);">
                    <i class="bi bi-grid-3x3 text-info display-1"></i>
                </div>
                <h3 class="game-title text-uppercase" style="color: #00f0ff;">TicTacToe ❌⭕</h3>
                <p class="text-secondary small flex-grow-1 mt-2">The ultimate strategic showdown. Face off on a 3x3 grid and conquer your opponent.</p>
                <a href="/NexPLAY/games/tictactoe/" class="btn btn-cyber mt-3 w-100" style="background: linear-gradient(45deg, #0088cc, #0066cc);">Play Now <i class="bi bi-play-fill ms-1"></i></a>
            </div>
        </div>

        <!-- Pong (Coming Soon) -->
        <div class="col-md-6 col-lg-4">
            <div class="game-card-hover coming-soon d-flex flex-column h-100" style="opacity: 0.8;">
                <div class="game-thumb d-flex justify-content-center align-items-center mb-3" style="background: linear-gradient(135deg, rgba(204, 0, 102, 0.4), rgba(102, 0, 51, 0.4)); border-radius: 12px; height: 160px; border: 1px solid var(--card-border);">
                    <i class="bi bi-record-circle text-danger display-1"></i>
                </div>
                <h3 class="game-title text-uppercase" style="color: #ff3366;">Pong 🏓</h3>
                <p class="text-secondary small flex-grow-1 mt-2">The retro arcade table-tennis legend. Defend your side and smash the ball past your rival!</p>
                <button class="btn btn-outline-danger mt-3 w-100 disabled text-uppercase fw-bold">Coming Soon <i class="bi bi-hourglass-split ms-1"></i></button>
            </div>
        </div>

        <!-- Maze Runner (Coming Soon) -->
        <div class="col-md-6 col-lg-4">
            <div class="game-card-hover coming-soon d-flex flex-column h-100" style="opacity: 0.8;">
                <div class="game-thumb d-flex justify-content-center align-items-center mb-3" style="background: linear-gradient(135deg, rgba(255, 153, 0, 0.4), rgba(153, 51, 0, 0.4)); border-radius: 12px; height: 160px; border: 1px solid var(--card-border);">
                    <i class="bi bi-bricks text-warning display-1"></i>
                </div>
                <h3 class="game-title text-uppercase" style="color: #ffaa00;">Maze Runner 🧩</h3>
                <p class="text-secondary small flex-grow-1 mt-2">Navigate through complex, shifting labyrinths against the clock.</p>
                <button class="btn btn-outline-warning mt-3 w-100 disabled text-uppercase fw-bold">Coming Soon <i class="bi bi-hourglass-split ms-1"></i></button>
            </div>
        </div>

        <!-- Reaction Test (Coming Soon) -->
        <div class="col-md-6 col-lg-4">
            <div class="game-card-hover coming-soon d-flex flex-column h-100" style="opacity: 0.8;">
                <div class="game-thumb d-flex justify-content-center align-items-center mb-3" style="background: linear-gradient(135deg, rgba(153, 51, 255, 0.4), rgba(51, 0, 102, 0.4)); border-radius: 12px; height: 160px; border: 1px solid var(--card-border);">
                    <i class="bi bi-lightning text-purple display-1" style="color: #cc66ff;"></i>
                </div>
                <h3 class="game-title text-uppercase" style="color: #cc66ff;">Reaction Test ⚡</h3>
                <p class="text-secondary small flex-grow-1 mt-2">Test your reflexes. Click as fast as humanly possible when the screen flashes.</p>
                <button class="btn btn-outline-light border-secondary mt-3 w-100 disabled text-uppercase fw-bold" style="color: #cc66ff;">Coming Soon <i class="bi bi-hourglass-split ms-1"></i></button>
            </div>
        </div>
    </div>
</section>

<!-- 6. Why Your Platform Section -->
<section class="container my-5 py-5 border-top border-secondary" style="border-opacity: 0.3;">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold text-white">Why NexPlay?</h2>
        <p class="text-secondary">Designed specifically for quick, uninterrupted gaming sessions.</p>
    </div>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-code-slash display-4 mb-3" style="color: var(--accent-cyan);"></i>
                <h4 class="text-white fw-bold">Pure JavaScript</h4>
                <p class="text-secondary small">Every game is constructed from the ground up utilizing native HTML5 Canvas and Vanilla JS DOM manipulation for extremely low latency input detection.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-rocket-takeoff display-4 mb-3" style="color: var(--accent-red);"></i>
                <h4 class="text-white fw-bold">Fast & Lightweight</h4>
                <p class="text-secondary small">Engineered using lightweight assets and optimized loops to ensure a smooth 60 FPS experience regardless of the device you are using.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-cloud-arrow-down-fill display-4 mb-3" style="color: #00ff66;"></i>
                <h4 class="text-white fw-bold">No Downloads Required</h4>
                <p class="text-secondary small">Skip the massive installers and patches. Your account history and gameplay seamlessly stream directly to your web browser instantly.</p>
            </div>
        </div>
    </div>
</section>

<!-- 9. Call-to-Action (Bottom) -->
<section class="container-fluid py-5 mt-5" style="background: linear-gradient(0deg, rgba(0,240,255,0.05) 0%, rgba(13,15,26,1) 100%); border-top: 1px solid var(--card-border);">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <h2 class="display-4 fw-bold text-white mb-3">Ready to beat the high score?</h2>
            <p class="lead text-secondary mb-4">Start grinding and climb to the top of the leaderboards today.</p>
            <a href="#featured-games" class="btn btn-lg fw-bold shadow position-relative" style="background: var(--accent-cyan); color: #000; letter-spacing: 1px;">START PLAYING <i class="bi bi-joystick ms-2"></i></a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
