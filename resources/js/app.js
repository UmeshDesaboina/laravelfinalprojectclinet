import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Add to Cart function
window.addToCart = function(productId, variant = null, quantity = 1) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ variant: variant, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in nav
            const navElement = document.querySelector('nav[x-data]');
            if (navElement && data.count !== undefined) {
                Alpine.store('cartCount', data.count);
                // Try to update via Alpine
                const alpineData = Alpine.$data;
                if (alpineData && alpineData.cartCount !== undefined) {
                    alpineData.cartCount = data.count;
                }
            }
            
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: data.message || 'Added to cart!',
                showConfirmButton: false,
                timer: 1500
            });
        } else if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: data.message || 'Error adding to cart',
                showConfirmButton: false,
                timer: 2000
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Please login to add items to cart',
            showConfirmButton: false,
            timer: 2000
        });
    });
};

// Toggle Wishlist function
window.toggleWishlist = function(productId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/wishlist/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 1500
            });
        } else if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: data.message || 'Please login',
                showConfirmButton: false,
                timer: 2000
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Please login to use wishlist',
            showConfirmButton: false,
            timer: 2000
        });
    });
};

// Global toast notification function
window.showToast = function(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-xl text-white font-bold transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
    }`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' : 
                  type === 'error' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' : 
                  '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>'}
            </svg>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

// Confirm delete helper
window.confirmDelete = function(message = 'Are you sure?') {
    return confirm(message);
};

// Format number as currency
window.formatCurrency = function(amount) {
    return '₹' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
};

// Debounce function
window.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    // Compare functionality
    window.compareItems = JSON.parse(localStorage.getItem('compareItems') || '[]');
    
    // Update compare badge
    updateCompareBadge();
});

// Compare functionality
window.toggleCompare = function(productId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const index = window.compareItems.indexOf(productId);
    
    if (index > -1) {
        window.compareItems.splice(index, 1);
    } else {
        if (window.compareItems.length >= 4) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'You can compare up to 4 products',
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }
        window.compareItems.push(productId);
    }
    
    localStorage.setItem('compareItems', JSON.stringify(window.compareItems));
    updateCompareBadge();
    
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: index > -1 ? 'Removed from compare' : 'Added to compare',
        showConfirmButton: false,
        timer: 1500
    });
};

function updateCompareBadge() {
    const badge = document.getElementById('compare-count');
    if (badge) {
        badge.textContent = window.compareItems.length;
        badge.classList.toggle('hidden', window.compareItems.length === 0);
    }
}

window.getCompareItems = function() {
    return window.compareItems;
};

// Handle AJAX errors globally
document.addEventListener('ajaxError', function(event) {
    if (event.detail && event.detail.response && event.detail.response.message) {
        window.showToast(event.detail.response.message, 'error');
    }
});
