function fetchOrders() {
  let username = document.getElementById("userDropdown").value;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "fetch_orders.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.getElementById("ordersTable").innerHTML = xhr.responseText;
    }
  };
  xhr.send("username=" + encodeURIComponent(username));
}
