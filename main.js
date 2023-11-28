
window.onload = function() {
	// Get a reference to the loading text element
	const loadingText = document.getElementById('loading-text');
	
	// Array of text messages to display
	const textMessages = ["STRAICH", "DE", "JYAL"];
	
	let index = 0;
 
	// Function to update the text
	function updateText() {
		loadingText.innerText = textMessages[index];
		index = (index + 1) % textMessages.length;
	}
 
	// Initially display the preloader
	const preloader = document.querySelector('.preloader');
	preloader.style.display = 'flex';
 
	// Set an interval to update the text every second (1000 milliseconds)
	const textUpdateInterval = setInterval(updateText, 1000);
 
	// After a certain duration, hide the preloader and reveal the content with a transition
	setTimeout(function() {
		preloader.style.opacity = '0';
		
		// Display the content
		const content = document.querySelector('.content');
		content.style.display = 'block';
		content.style.opacity = '1';
 
		// Clear the text update interval
		clearInterval(textUpdateInterval);
	}, 3100); // Adjust the total duration as needed (5 seconds in this example)
 }

let navbar = document.querySelector('.nav-bar');

document.querySelector('#menu-btn').onclick = () => {
	navbar.classList.toggle('active');
	searchForm.classList.remove('active');
	cartItem.classList.remove('active');
	toggleMenu.classList.remove('active');
}

let searchForm = document.querySelector('.search-form');

document.querySelector('#search-btn').onclick = () => {
	searchForm.classList.toggle('active');
	navbar.classList.remove('active');
	cartItem.classList.remove('active');
	toggleMenu.classList.remove('active');
}

let cartItem = document.querySelector('.cart-item-container');

document.querySelector('#cart-btn').onclick = () => {
	cartItem.classList.toggle('active');
	navbar.classList.remove('active');
	searchForm.classList.remove('active');
	toggleMenu.classList.remove('active');
}

let toggleMenu = document.querySelector('.profile-menu');

document.querySelector('#profile-btn').onclick = () => {
	toggleMenu.classList.toggle('active')
	navbar.classList.remove('active');
	searchForm.classList.remove('active');
	cartItem.classList.remove('active');
}

window.onscroll = () => {
	navbar.classList.remove('active');
	searchForm.classList.remove('active');
	cartItem.classList.remove('active');
	toggleMenu.classList.remove('active');
}


// function addToCartConfirmation(itemId) {
//     // Display a confirmation dialog
//     var userConfirmed = window.confirm("To add this item to your cart, please log in. Do you want to log in now?");
//     if (userConfirmed) {
//         // User clicked "OK," redirect to login page
//         window.location.href = 'login.php';
//     } else {
        
//     }
// }

document.querySelector('.dropdown').addEventListener('mouseover', function() {
	this.classList.add('hovered');
});

// Remove the class when not hovering
document.querySelector('.dropdown').addEventListener('mouseout', function() {
	this.classList.remove('hovered');
});

    function showContent(tabName) {
            var contents = document.getElementsByClassName('content');
            for (var i = 0; i < contents.length; i++) {
                contents[i].classList.remove('active');
            }

            document.getElementById(tabName).classList.add('active');
        }

function redirectToLink() {
            window.location.href = 'single.php?product_id=<?php echo $itemId; ?>'; 
        }
