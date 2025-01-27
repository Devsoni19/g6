// Quantity input handling
$(document).ready(function () {
  $('.quantity-right-plus').click(function (e) {
    e.preventDefault();
    var quantity = parseInt($('#quantity').val());
    if (quantity < 100) {
      $('#quantity').val(quantity + 1);
    }
  });

  $('.quantity-left-minus').click(function (e) {
    e.preventDefault();
    var quantity = parseInt($('#quantity').val());
    if (quantity > 1) {
      $('#quantity').val(quantity - 1);
    }
  });
});

// Track selected components
let selectedBackplate = null;
let selectedTopplate = null;

function load_plate(element) {
  // ... existing load_plate code ...
  selectedBackplate = {
    title: element.querySelector('.title').textContent,
    image: element.querySelector('img').src,
    rows: element.getAttribute('data-rows')
  };
}

function load_top_plate(e, type) {
  // ... existing load_top_plate code ...
  selectedTopplate = {
    type: type,
    image: e.target.childNodes[1].childNodes[1].src
  };
}

// Add to cart functionality
async function addToCart() {
  if (!is_plate_selected) {
    alert("Please select a top plate");
    return;
  }

  const quantity = parseInt(document.getElementById('quantity').value);
  if (isNaN(quantity) || quantity < 1 || quantity > 100) {
    alert("Please enter a valid quantity (1-100)");
    return;
  }

  const configuration = {
    backplate: selectedBackplate,
    components: Array.from(document.querySelectorAll('.component-item')).map(item => item.dataset.componentType),
    icons: Array.from(document.querySelectorAll('.icon-holder img')).map(img => img.src),
    top_plate: selectedTopplate,
    quantity: quantity
  };

  try {
    const response = await fetch('save_to_cart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(configuration)
    });

    const result = await response.json();
    if (result.success) {
      alert('Item added to cart successfully!');
      window.location.href = 'cart.php'; // Redirect to cart page
    } else {
      alert('Error: ' + result.message);
    }
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred while adding to cart');
  }
}

// Modified next_section function
function next_section() {
  // ... existing next_section code ...

  setTimeout(() => {
    // ... existing container handling code ...

    if (container_index === 3) {
      next_btn.innerHTML = "Add to Cart";
      next_btn.onclick = addToCart;
      document.querySelector('.quantity-input-group').style.display = 'flex';
    }
  }, 300);
}