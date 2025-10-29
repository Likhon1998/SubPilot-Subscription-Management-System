@extends('layouts.frontend.front')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <!-- Page Header -->
            <div class="page-header mb-3">
                <h5 class="mb-1">{{ $product->name }}</h5>
                <p class="text-muted small mb-0">{{ $product->description }}</p>
            </div>

            <!-- Product Details Card -->
            <div class="details-card">
                <div class="details-card-header">
                    <h6 class="mb-0">Select Items</h6>
                </div>
                
                <div class="details-card-body">
                    <!-- Items Selection -->
                    @if($product->items && $product->items->count() > 0)
                        <div class="items-selection mb-3">
                            @foreach($product->items as $item)
                            <label class="item-select-row" for="item-{{ $item->id }}">
                                <input 
                                    class="form-check-input item-selector" 
                                    type="checkbox" 
                                    name="items[]" 
                                    value="{{ $item->id }}" 
                                    data-price="{{ $item->price }}"
                                    id="item-{{ $item->id }}">
                                <div class="item-select-info">
                                    <div class="item-select-name">{{ $item->name }}</div>
                                    @if($item->features)
                                        <div class="item-select-features">
                                            @php
                                                $features = is_array($item->features) ? $item->features : json_decode($item->features, true);
                                            @endphp
                                            @if(is_array($features) && count($features) > 0)
                                                {{ implode(', ', array_slice($features, 0, 2)) }}
                                                @if(count($features) > 2)
                                                    <span>...</span>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="item-select-price">৳{{ number_format($item->price, 2) }}<span class="price-unit">/mo</span></div>
                            </label>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning small">No items available for this product.</div>
                    @endif

                    <!-- Duration Input -->
                    <div class="duration-input mb-3">
                        <label for="duration" class="form-label small mb-1">Duration (months)</label>
                        <input 
                            type="number" 
                            class="form-control form-control-sm" 
                            id="duration" 
                            name="duration" 
                            value="1" 
                            min="1" 
                            max="36"
                            placeholder="1-36">
                    </div>

                    <!-- Total Display -->
                    <div class="total-display">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small text-muted">Total Amount</span>
                            <span class="total-amount">৳<span id="total-amount">0.00</span></span>
                        </div>
                        <div class="calculation-info">
                            <span id="selected-items-count">0</span> item(s) × 
                            <span id="duration-display">1</span> month(s)
                        </div>
                    </div>
                </div>

                <div class="details-card-footer">
                    <a href="" class="btn btn-sm btn-outline">Back</a>
                    <button type="button" class="btn btn-sm btn-primary" id="proceed-checkout">Proceed to Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemCheckboxes = document.querySelectorAll('.item-selector');
    const durationInput = document.getElementById('duration');
    const totalAmountDisplay = document.getElementById('total-amount');
    const selectedItemsCount = document.getElementById('selected-items-count');
    const durationDisplay = document.getElementById('duration-display');
    const checkoutBtn = document.getElementById('proceed-checkout');

    // 🧮 Calculate total and update UI
    function calculateTotal() {
        let selectedTotal = 0;
        let selectedCount = 0;

        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedTotal += parseFloat(checkbox.dataset.price);
                selectedCount++;
            }
        });

        const duration = parseInt(durationInput.value) || 1;
        const total = selectedTotal * duration;

        totalAmountDisplay.textContent = total.toFixed(2);
        selectedItemsCount.textContent = selectedCount;
        durationDisplay.textContent = duration;
    }

    itemCheckboxes.forEach(checkbox => checkbox.addEventListener('change', calculateTotal));
    durationInput.addEventListener('input', calculateTotal);

    // 🛒 Proceed to checkout
    checkoutBtn.addEventListener('click', function() {
        const selectedItems = Array.from(itemCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selectedItems.length === 0) {
            alert('Please select at least one item to proceed.');
            return;
        }

        const duration = parseInt(durationInput.value);
        if (isNaN(duration) || duration < 1) {
            alert('Please enter a valid duration (minimum 1 month).');
            return;
        }

        const total = parseFloat(totalAmountDisplay.textContent);

        // Build checkout URL dynamically
        const productId = "{{ $product->id }}";
        const checkoutUrl = `{{ route('checkout.form', ':product') }}`
            .replace(':product', productId)
            + `?items=${encodeURIComponent(JSON.stringify(selectedItems))}`
            + `&duration=${duration}`
            + `&total=${total}`;

        // Redirect to checkout form
        window.location.href = checkoutUrl;
    });

    calculateTotal();
});
</script>

@endsection