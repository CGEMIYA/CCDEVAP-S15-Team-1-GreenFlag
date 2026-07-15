document.addEventListener('DOMContentLoaded', () => {
    const playerOneCard = document.getElementById('playerOneCard');
    const playerTwoCard = document.getElementById('playerTwoCard');
    const coin = document.getElementById('coin');
    const flipBtn = document.getElementById('flipBtn');
    const resultBanner = document.getElementById('resultBanner');
    const playAgainBtn = document.getElementById('playAgainBtn');
    const choiceButtons = Array.from(document.querySelectorAll('.choice-btn'));
    const spotSelects = Array.from(document.querySelectorAll('.spot-select'));

    const state = {
        player1: '',
        player2: '',
        result: null,
        flipped: false,
        player1Place: '',
        player2Place: ''
    };

    const getChoiceName = (value) => (value === 'heads' ? 'Heads' : 'Tails');
    const getPlaceName = (player) => {
        const select = spotSelects.find((item) => item.dataset.player === player);
        const selectedOption = select?.selectedOptions[0];
        return selectedOption?.dataset.name || selectedOption?.textContent || 'a place';
    };

    const resetPlaceSelectors = () => {
        spotSelects.forEach((select) => {
            select.value = '';
        });
    };

    const updateSelectionUI = () => {
        choiceButtons.forEach((button) => {
            const player = button.dataset.player;
            const otherPlayer = player === 'player1' ? 'player2' : 'player1';
            const otherChoice = state[otherPlayer];
            const thisChoice = button.dataset.choice;

            const isBlocked = Boolean(otherChoice) && otherChoice === thisChoice;
            button.disabled = isBlocked;
            button.classList.toggle('active', state[player] === thisChoice);
        });

        spotSelects.forEach((select) => {
            const player = select.dataset.player;
            const otherPlayer = player === 'player1' ? 'player2' : 'player1';
            const otherPlace = state[player === 'player1' ? 'player2Place' : 'player1Place'];
            const selectedValue = select.value;

            Array.from(select.options).forEach((option) => {
                if (!option.value) {
                    return;
                }

                option.disabled = Boolean(otherPlace) && option.value === otherPlace;
            });

            if (selectedValue && select.querySelector(`option[value="${selectedValue}"]`)?.disabled) {
                select.value = '';
            }
        });

        const bothReady = Boolean(state.player1) && Boolean(state.player2) && Boolean(state.player1Place) && Boolean(state.player2Place) && state.player1Place !== state.player2Place;
        flipBtn.disabled = !bothReady;

        playerOneCard.classList.toggle('locked', Boolean(state.player1));
        playerTwoCard.classList.toggle('locked', Boolean(state.player2));
    };

    choiceButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const player = button.dataset.player;
            const key = player === 'player1' ? 'player1' : 'player2';
            const choice = button.dataset.choice;
            const otherPlayer = player === 'player1' ? 'player2' : 'player1';

            if (state[otherPlayer] === choice) {
                resultBanner.textContent = 'That side is already taken by the other player.';
                return;
            }

            state[key] = choice;
            updateSelectionUI();
            resultBanner.textContent = `${player === 'player1' ? 'Player 1' : 'Player 2'} locked in ${getChoiceName(choice)} for ${getPlaceName(player)}.`;
        });
    });

    spotSelects.forEach((select) => {
        select.addEventListener('change', () => {
            const player = select.dataset.player;
            const placeKey = player === 'player1' ? 'player1Place' : 'player2Place';
            const otherPlaceKey = player === 'player1' ? 'player2Place' : 'player1Place';
            const selectedValue = select.value;

            if (!selectedValue) {
                state[placeKey] = '';
                updateSelectionUI();
                resultBanner.textContent = `${player === 'player1' ? 'Player 1' : 'Player 2'} must choose a place.`;
                return;
            }

            if (state[otherPlaceKey] === selectedValue) {
                select.value = '';
                state[placeKey] = '';
                updateSelectionUI();
                resultBanner.textContent = 'That place is already taken by the other player.';
                return;
            }

            state[placeKey] = selectedValue;
            updateSelectionUI();
            resultBanner.textContent = `${player === 'player1' ? 'Player 1' : 'Player 2'} selected ${getPlaceName(player)}.`;
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

        const winningChoice = Math.random() < 0.5 ? 'heads' : 'tails';
        const winningSpotName = getChoiceName(winningChoice);
        const winner = state.player1 === winningChoice ? 'player1' : 'player2';
        const winnerCard = winner === 'player1' ? playerOneCard : playerTwoCard;
        const loserCard = winner === 'player1' ? playerTwoCard : playerOneCard;

        setTimeout(() => {
            coin.classList.remove('flipping');
            coin.classList.add(winningChoice === 'heads' ? 'land-heads' : 'land-tails');

            state.result = winningChoice;
            resultBanner.classList.add('winner');
            resultBanner.innerHTML = `<strong>${winningSpotName} Wins!</strong><br>${winner === 'player1' ? 'Player 1' : 'Player 2'} takes the round for ${getPlaceName(winner)}.`;
            winnerCard.classList.add('winner');
            loserCard.classList.remove('winner');
            flipBtn.textContent = 'Flipped';
        }, 2500);
    });

    playAgainBtn.addEventListener('click', () => {
        state.player1 = '';
        state.player2 = '';
        state.result = null;
        state.flipped = false;
        state.player1Place = '';
        state.player2Place = '';

        choiceButtons.forEach((button) => {
            button.disabled = false;
            button.classList.remove('active');
        });

        resetPlaceSelectors();

        playerOneCard.classList.remove('winner', 'locked');
        playerTwoCard.classList.remove('winner', 'locked');
        coin.classList.remove('flipping', 'land-heads', 'land-tails');
        coin.classList.add('land-heads');
        flipBtn.disabled = true;
        flipBtn.innerHTML = '<i class="fa-solid fa-arrows-rotate"></i> Flip Coin';
        resultBanner.classList.remove('winner');
        resultBanner.textContent = 'Waiting for both players to lock in...';
        updateSelectionUI();
    });

    resetPlaceSelectors();
    updateSelectionUI();
});
