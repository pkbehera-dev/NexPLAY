<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /NexPLAY/login");
    exit();
}
include '../../includes/head.php'; 
include '../../includes/nav.php'; 
?>

<style>
    .cell {
        width: 100px;
        height: 100px;
        background: rgba(0, 0, 0, 0.4);
        border: 2px solid var(--accent-cyan);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 3rem;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 8px;
    }
    .cell:hover {
        background: rgba(0, 240, 255, 0.1);
    }
    .cell.x {
        color: var(--accent-cyan);
        text-shadow: 0 0 10px var(--accent-cyan);
    }
    .cell.o {
        color: var(--accent-red);
        text-shadow: 0 0 10px var(--accent-red);
    }
</style>

<div class="container my-5 text-center flex-grow-1 d-flex flex-column align-items-center justify-content-center">
    <div class="glass-panel" style="max-width: 500px; width: 100%;">
        <div class="row align-items-center mb-4">
            <div class="col-3 text-start">
                <a href="/NexPLAY/" class="btn btn-sm btn-outline-info"><i class="bi bi-arrow-left"></i> Hub</a>
            </div>
            <div class="col-6">
                <h2 class="text-info text-uppercase fw-bold m-0"><i class="bi bi-grid-3x3"></i> TicTacToe</h2>
            </div>
            <div class="col-3 text-end">
                <button id="resetBtn" class="btn btn-sm btn-outline-warning"><i class="bi bi-arrow-clockwise"></i> Reset</button>
            </div>
        </div>

        <h4 id="status" class="mb-4 text-white">Player X's Turn</h4>
        
        <div class="d-flex justify-content-center">
            <div class="d-grid gap-2" style="grid-template-columns: repeat(3, 1fr);">
                <div class="cell" data-index="0"></div>
                <div class="cell" data-index="1"></div>
                <div class="cell" data-index="2"></div>
                <div class="cell" data-index="3"></div>
                <div class="cell" data-index="4"></div>
                <div class="cell" data-index="5"></div>
                <div class="cell" data-index="6"></div>
                <div class="cell" data-index="7"></div>
                <div class="cell" data-index="8"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const cells = document.querySelectorAll('.cell');
    const statusText = document.querySelector('#status');
    const resetBtn = document.querySelector('#resetBtn');
    let options = ["", "", "", "", "", "", "", "", ""];
    let currentPlayer = "X";
    let running = true;
    
    const winConditions = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],
        [0, 3, 6], [1, 4, 7], [2, 5, 8],
        [0, 4, 8], [2, 4, 6]
    ];

    function initializeGame(){
        cells.forEach(cell => cell.addEventListener('click', cellClicked));
        resetBtn.addEventListener('click', restartGame);
        statusText.textContent = `Player ${currentPlayer}'s Turn`;
    }

    function cellClicked(){
        const cellIndex = this.getAttribute('data-index');

        if(options[cellIndex] != "" || !running){
            return;
        }

        updateCell(this, cellIndex);
        checkWinner();
    }

    function updateCell(cell, index){
        options[index] = currentPlayer;
        cell.textContent = currentPlayer;
        cell.classList.add(currentPlayer.toLowerCase());
    }

    function switchPlayer(){
        currentPlayer = (currentPlayer == "X") ? "O" : "X";
        let colorClass = currentPlayer == 'X' ? 'text-info' : 'text-danger';
        statusText.innerHTML = `Player <span class="${colorClass} fw-bold">${currentPlayer}</span>'s Turn`;
    }

    function checkWinner(){
        let roundWon = false;

        for(let i = 0; i < winConditions.length; i++){
            const condition = winConditions[i];
            const cellA = options[condition[0]];
            const cellB = options[condition[1]];
            const cellC = options[condition[2]];

            if(cellA == "" || cellB == "" || cellC == ""){
                continue;
            }
            if(cellA == cellB && cellB == cellC){
                roundWon = true;
                break;
            }
        }

        if(roundWon){
            let colorClass = currentPlayer == 'X' ? 'text-info' : 'text-danger';
            statusText.innerHTML = `Player <span class="${colorClass}">${currentPlayer}</span> Wins!`;
            running = false;
        }
        else if(!options.includes("")){
            statusText.textContent = "Draw!";
            running = false;
        }
        else{
            switchPlayer();
        }
    }

    function restartGame(){
        currentPlayer = "X";
        options = ["", "", "", "", "", "", "", "", ""];
        statusText.innerHTML = `Player <span class="text-info fw-bold">${currentPlayer}</span>'s Turn`;
        cells.forEach(cell => {
            cell.textContent = "";
            cell.classList.remove('x', 'o');
        });
        running = true;
    }

    initializeGame();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
