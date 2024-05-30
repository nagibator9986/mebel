// script.js

// Function to handle tab switching
function openTab(event, tabName) {
    var i, tabcontent, tablinks;

    // Hide all tab content
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        tabcontent[i].classList.remove("active");
    }

    // Remove the active class from all tab buttons
    tablinks = document.getElementsByClassName("tab-button");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    document.getElementById(tabName).classList.add("active");
    event.currentTarget.className += " active";
}

// Initialize the first tab as active
document.addEventListener("DOMContentLoaded", function() {
    document.getElementsByClassName("tab-button")[0].click();
});

// Function to handle thumbnail image clicks
function showImage(thumbnail) {
    var mainImage = document.querySelector('.main-image');
    mainImage.style.backgroundImage = thumbnail.style.backgroundImage;
}

// Attach event listeners to thumbnail images
var thumbnails = document.getElementsByClassName('thumbnail');
for (var i = 0; i < thumbnails.length; i++) {
    thumbnails[i].addEventListener('click', function() {
        showImage(this);
    });
}

// Function to handle quantity adjustment
function adjustQuantity(increment) {
    var quantityInput = document.querySelector('.quantity input');
    var currentQuantity = parseInt(quantityInput.value);
    var newQuantity = currentQuantity + increment;
    if (newQuantity > 0) {
        quantityInput.value = newQuantity;
    }
}

// Attach event listeners to quantity buttons
document.querySelector('.quantity input').addEventListener('input', function() {
    if (this.value < 1) {
        this.value = 1;
    }
});

// Add to Cart and Compare button functionality (dummy implementation for demonstration)
document.querySelector('.btn').addEventListener('click', function() {
    alert('Added to cart!');
});

document.querySelector('.btn.secondary').addEventListener('click', function() {
    alert('Added to compare list!');
});

// Smooth scrolling for any in-page navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Function to open the cart modal
function openCart() {
    document.getElementById('cart-modal').style.display = 'flex';
}

// Function to close the cart modal
function closeCart() {
    document.getElementById('cart-modal').style.display = 'none';
}

// Attach event listeners to cart icon and close button
document.getElementById('cart-icon').addEventListener('click', openCart);
document.getElementById('close-cart').addEventListener('click', closeCart);

// Close the cart modal when clicking outside of the modal content
window.onclick = function(event) {
    var modal = document.getElementById('cart-modal');
    if (event.target == modal) {
        closeCart();
    }
}
