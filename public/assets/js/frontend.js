// SubPilot Frontend JavaScript

document.addEventListener('DOMContentLoaded', function() {
    console.log('SubPilot Platform Initialized');

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Enhanced item checkbox row interactions
    const itemSelectRows = document.querySelectorAll('.item-select-row');
    itemSelectRows.forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = this.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            }
        });
    });

    // Add number input validation
    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(input => {
        input.addEventListener('input', function() {
            const min = parseInt(this.min) || 1;
            const max = parseInt(this.max) || 999;
            let value = parseInt(this.value);

            if (value < min) this.value = min;
            if (value > max) this.value = max;
        });

        // Prevent scroll wheel from changing value
        input.addEventListener('wheel', function(e) {
            e.preventDefault();
        });
    });

    // Add loading state to checkout button
    const checkoutBtn = document.getElementById('proceed-checkout');
    if (checkoutBtn) {
        const originalClickHandler = checkoutBtn.onclick;
        
        checkoutBtn.addEventListener('click', function(e) {
            if (!this.disabled) {
                const originalText = this.innerHTML;
                this.disabled = true;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Processing...';

                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = originalText;
                }, 1500);
            }
        });
    }

    // Add keyboard navigation for item rows
    itemSelectRows.forEach(row => {
        row.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const checkbox = this.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            }
        });
    });

    // Auto-focus on duration input when items are selected
    const itemCheckboxes = document.querySelectorAll('.item-selector');
    const durationInput = document.getElementById('duration');
    
    if (itemCheckboxes.length > 0 && durationInput) {
        let firstSelection = true;
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked && firstSelection) {
                    firstSelection = false;
                    setTimeout(() => {
                        durationInput.focus();
                        durationInput.select();
                    }, 200);
                }
            });
        });
    }

    // Add tooltip for truncated features
    const featureBadges = document.querySelectorAll('.feature-badge');
    featureBadges.forEach(badge => {
        if (badge.scrollWidth > badge.clientWidth) {
            badge.title = badge.textContent;
        }
    });

    // Console branding
    console.log('%c SubPilot ', 'background: #7c8db5; color: white; font-size: 14px; font-weight: 600; padding: 6px 12px; border-radius: 3px;');
    console.log('%c Subscription Management System ', 'color: #6c757d; font-size: 12px;');
});

// Format currency helper
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-BD', {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

// Validate form before submission
function validateCheckoutForm() {
    const selectedItems = document.querySelectorAll('.item-selector:checked');
    const duration = document.getElementById('duration');
    
    if (selectedItems.length === 0) {
        return { valid: false, message: 'Please select at least one item.' };
    }
    
    if (!duration || duration.value < 1) {
        return { valid: false, message: 'Please enter a valid duration.' };
    }
    
    return { valid: true };
}

// Export for use in other scripts if needed
if (typeof window !== 'undefined') {
    window.SubPilot = {
        formatCurrency: formatCurrency,
        validateCheckoutForm: validateCheckoutForm
    };
}