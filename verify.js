let timer = document.getElementById('timer');
let requestBtn = document.getElementById('requestBtn');
let timeLeft = 180; // 3 minutes in seconds
let timerInterval;

function updateTimer() {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    // Format the time as MM:SS
    timer.innerHTML = `${minutes}:${seconds.toString().padStart(2, '0')}`;

    if (timeLeft > 0) {
        timeLeft--;
    } else {
        clearInterval(timerInterval);
        timer.innerHTML = "Time's up!";
        requestBtn.disabled = false; // Enable the button when the timer runs out
    }
}

function startTimer() {
    clearInterval(timerInterval);
    timeLeft = 180; // Reset the timer to 3 minutes
    timerInterval = setInterval(updateTimer, 1000);
    updateTimer(); // Initial call to display the timer immediately
}

function resetTimer() {
    requestBtn.disabled = true; // Disable the button when it's clicked
    startTimer();
}

// Start the timer when the page loads
startTimer();