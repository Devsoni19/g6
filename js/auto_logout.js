// <!-- //new script for auto logout at set timer from idle state -->
let idleTime = 0;

function resetIdleTime() {
  idleTime = 0;
  document.getElementById("idle-timer").style.display = "none";
  // Send AJAX request to update session's last active time
  fetch("user_auth.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "type=ajax",
  });
}

// Increment the idle time counter every second.
setInterval(() => {
  idleTime++;
  document.getElementById("idle-time").textContent = idleTime;
  if (idleTime >= 10) {
    // 600 seconds = 10 minutes
    window.location.href = "logout.php";
  } else if (idleTime > 0) {
    document.getElementById("idle-timer").style.display = "block";
  }
}, 1000);

// Reset the idle timer on any of these events.
window.onload = resetIdleTime;
window.onmousemove = resetIdleTime;
window.onscroll = resetIdleTime;
window.onclick = resetIdleTime;
window.onkeypress = resetIdleTime;
window.ontouchstart = resetIdleTime;
