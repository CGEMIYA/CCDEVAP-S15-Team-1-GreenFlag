document.addEventListener('DOMContentLoaded', () => {
    const playerOneCard = document.getElementById('playerOneCard');
    const playerTwoCard = document.getElementById('playerTwoCard');
    const coin = document.getElementById('coin');
    const flipBtn = document.getElementById('flipBtn');
    const resultBanner = document.getElementById('resultBanner');
    const playAgainBtn = document.getElementById('playAgainBtn');
    const spotButtons = Array.from(document.querySelectorAll('.spot-option'));

    const state = {
        player1: null,
        player2: null,
        result: null,
        flipped: false
    };

    const updateSelectionUI = () => {
        spotButtons.forEach((button) => {
            const player = button.dataset.player;
            const spot = button.dataset.spot;
            const isLocked = (player === 'player1' && state.player1) || (player === 'player2' && state.player2);

            if (isLocked && !state[player]) {
                button.disabled = true;
            } else {
                button.disabled = false;
            }

            if (state[player] === spot) {
                button.classList.add('selected');
            } else {
                button.classList.remove('selected');
            }

            if (state.player1 && state.player2 && state.player1 !== state.player2) {
                const opposite = player === 'player1' ? 'player2' : 'player1';
                const lockedSpot = state[opposite];
                if (lockedSpot === spot) {
                    button.disabled = true;
                }
            }
        });

        if (state.player1 && state.player2) {
            flipBtn.disabled = false;
        } else {
            flipBtn.disabled = true;
        }

        if (state.player1) {
            playerOneCard.classList.add('locked');
        } else {
            playerOneCard.classList.remove('locked');
        }

        if (state.player2) {
            playerTwoCard.classList.add('locked');
        } else {
            playerTwoCard.classList.remove('locked');
        }
    };

    spotButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const { player, spot } = button.dataset;
            const playerKey = player === 'player1' ? 'player1' : 'player2';

            if (state[playerKey]) {
                return;
            }

            if (state.player1 && state.player2) {
                return;
            }

            if (state.player1 === spot || state.player2 === spot) {
                return;
            }

            state[playerKey] = spot;
            button.classList.add('selected');
            updateSelectionUI();
            resultBanner.innerHTML = `${player === 'player1' ? 'Player 1' : 'Player 2'} locked in ${spot}.`;
        });
    });

    flipBtn.addEventListener('click', () => {
        if (!state.player1 || !state.player2) {
            return;
        }

        if (state.flipped) {
            return;
        }

        state.flipped = true;
        flipBtn.disabled = true;
        coin.classList.remove('land-heads', 'land-tails');
        coin.classList.add('flipping');
        resultBanner.classList.remove('winner');
        resultBanner.textContent = 'The coin is spinning...';

        const winningSpot = Math.random() < 0.5 ? 'heads' : 'tails';

        setTimeout(() => {
            coin.classList.remove('flipping');
            coin.classList.add(winningSpot === 'heads' ? 'land-heads' : 'land-tails');

            const winner = state.player1 === winningSpot ? 'player1' : 'player2';
            const winnerCard = winner === 'player1' ? playerOneCard : playerTwoCard;
            const loserCard = winner === 'player1' ? playerTwoCard : playerOneCard;

            state.result = winningSpot;
            resultBanner.classList.add('winner');
            resultBanner.innerHTML = `<strong>${winningSpot === 'heads' ? 'Heads' : 'Tails'} Wins!</strong><br>${winner === 'player1' ? 'Player 1' : 'Player 2'} takes the round.`;
            winnerCard.classList.add('winner');
            loserCard.classList.remove('winner');
            flipBtn.textContent = 'Flipped';
        }, 2500);
    });

    playAgainBtn.addEventListener('click', () => {
        state.player1 = null;
        state.player2 = null;
        state.result = null;
        state.flipped = false;

        spotButtons.forEach((button) => {
            button.classList.remove('selected');
            button.disabled = false;
        });

        playerOneCard.classList.remove('winner', 'locked');
        playerTwoCard.classList.remove('winner', 'locked');
        coin.classList.remove('flipping', 'land-heads', 'land-tails');
        coin.classList.add('land-heads');
        flipBtn.disabled = true;
        flipBtn.innerHTML = '<i class="fa-solid fa-arrows-rotate"></i> Flip Coin';
        resultBanner.classList.remove('winner');
        resultBanner.textContent = 'Waiting for both players to lock in...';
    });
});
