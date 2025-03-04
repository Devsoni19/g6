document.addEventListener("DOMContentLoaded", function () {
  const select = document.querySelector(".order-status");
  const tempSpan = document.createElement("span");

  // Apply styles to match the select element
  tempSpan.style.visibility = "hidden";
  tempSpan.style.position = "absolute";
  tempSpan.style.whiteSpace = "nowrap";
  tempSpan.style.fontSize = window.getComputedStyle(select).fontSize;
  tempSpan.style.fontWeight = window.getComputedStyle(select).fontWeight;
  tempSpan.style.padding = window.getComputedStyle(select).padding;
  document.body.appendChild(tempSpan);

  function updateWidth() {
    tempSpan.textContent = select.options[select.selectedIndex].text;
    const textWidth = tempSpan.offsetWidth;
    const extraPadding = 40; // Adjust for padding & dropdown arrow
    select.style.width = tempSpan.offsetWidth + 40 + "px"; // Extra padding for arrow
  }

  select.addEventListener("change", updateWidth);
  updateWidth(); // Initial width update
});
