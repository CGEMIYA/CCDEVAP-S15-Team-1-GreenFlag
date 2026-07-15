<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Flag | Coinflip</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/coinflip.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="page-transition">

    <header>
        <div class="left-nav">
            <button class="menu-btn" id="menuBtn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <h1 class="logo">
                <a href="index.php">Green<br>Flag</a>
            </h1>
        </div>

        <div class="right-nav">
            <button id="themeToggle">
                <i class="fa-solid fa-moon"></i>
            </button>

            <a href="index.php">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </div>
    </header>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-profile">
            <div class="profile-picture">
                <i class="fa-regular fa-user"></i>
            </div>

            <div class="profile-info">
                <h3>Coinflip Arena</h3>
                <p>Pick your side and let the coin decide.</p>
            </div>
        </div>

        <div class="sidebar-links">
            <a href="index.php">
                <i class="fa-solid fa-house"></i>
                Home
            </a>

            <a href="coinflip.php" class="active">
                <i class="fa-solid fa-coins"></i>
                Coinflip
            </a>
        </div>
    </aside>

    <main class="coinflip-shell">
        <section class="coinflip-card">
            <div class="page-intro">
                <p class="eyebrow">Two-player showdown</p>
                <h2>Choose a side, then flip the coin.</h2>
                <p class="intro-copy">
                    Player 1 and Player 2 each lock in a spot. The coin decides the winner, and the winning side gets the spotlight.
                </p>
            </div>

            <div class="player-grid">
                <article class="player-card" id="playerOneCard">
                    <div class="player-header">
                        <div class="player-badge">P1</div>
                        <div>
                            <h3>Player 1</h3>
                            <p>Choose your spot</p>
                        </div>
                    </div>

                    <div class="spot-options" role="group" aria-label="Player 1 spot selection">
                        <button class="spot-option" data-player="player1" data-spot="heads" type="button">
                            <span class="spot-icon">🪙</span>
                            <span class="spot-name">Heads</span>
                        </button>
                        <button class="spot-option" data-player="player1" data-spot="tails" type="button">
                            <span class="spot-icon">🪙</span>
                            <span class="spot-name">Tails</span>
                        </button>
                    </div>
                </article>

                <div class="coin-stage">
                    <div class="coin-wrapper">
                        <div class="coin" id="coin">
                            <div class="coin-face coin-front">H</div>
                            <div class="coin-face coin-back">T</div>
                        </div>
                    </div>

                    <button class="flip-btn" id="flipBtn" type="button" disabled>
                        <i class="fa-solid fa-arrows-rotate"></i>
                        Flip Coin
                    </button>

                    <div class="result-banner" id="resultBanner">
                        Waiting for both players to lock in...
                    </div>
                </div>

                <article class="player-card" id="playerTwoCard">
                    <div class="player-header">
                        <div class="player-badge accent">P2</div>
                        <div>
                            <h3>Player 2</h3>
                            <p>Choose your spot</p>
                        </div>
                    </div>

                    <div class="spot-options" role="group" aria-label="Player 2 spot selection">
                        <button class="spot-option" data-player="player2" data-spot="heads" type="button">
                            <span class="spot-icon">🪙</span>
                            <span class="spot-name">Heads</span>
                        </button>
                        <button class="spot-option" data-player="player2" data-spot="tails" type="button">
                            <span class="spot-icon">🪙</span>
                            <span class="spot-name">Tails</span>
                        </button>
                    </div>
                </article>
            </div>

            <div class="actions">
                <button class="secondary-btn" id="playAgainBtn" type="button">Play Again</button>
                <a class="ghost-btn" href="index.php">Back to Dashboard</a>
            </div>
        </section>
    </main>

    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/coinflip.js"></script>
</body>

</html>
