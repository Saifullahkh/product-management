<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="subscription-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2 text-dark">Choose Your Inventory Plan</h2>
            <p class="text-muted">Scale your business seamlessly. Upgrade or downgrade anytime.</p>
        </div>

        <div class="pricing-grid style-table">
            <table style="width: 100%; border-collapse: separate; border-spacing: 20px 0; table-layout: fixed;">
                <tr>
                    <td style="vertical-align: top; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eef2f5; padding: 40px 30px; text-align: center;">
                        <div class="plan-header mb-4">
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 mb-2 fw-semibold small" style="background-color: #f1f3f5; color: #495057;">Starter</span>
                            <h3 class="fw-bold text-dark my-2">Basic</h3>
                            <div class="price-block my-3">
                                <span class="display-5 fw-bold text-dark" style="font-size: 2.5rem;">$19</span>
                                <span class="text-muted small">/ month</span>
                            </div>
                            <p class="text-muted small">Perfect for new sellers getting started.</p>
                        </div>
                        <hr style="border-top: 1px solid #f1f3f5; margin: 25px 0;">
                        <div class="plan-features text-start mb-4">
                            <ul class="list-unstyled m-0 p-0" style="line-height: 2.2;">
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i>Analytics Dashboard </li>
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i>Total Stock</li>
                                <li class="small text-muted text-decoration-line-through"><i class="bi bi-x-circle-fill text-danger me-2"></i>Products</li>
                                <li class="small text-muted text-decoration-line-through"><i class="bi bi-x-circle-fill text-danger me-2"></i>Categories</li>
                            </ul>
                        </div>
                        <div class="plan-action mt-4">
                            @if(auth()->user() && auth()->user()->subscribedToPrice('price_1Tl0cP5TaCf50YADJPdhkbHQ', 'default'))
                                <button class="btn btn-success w-100 rounded-3 py-2 fw-semibold" disabled>✓ Current Plan</button>
                            @else
                                <a href="{{ route('checkout', 'Basic') }}" class="btn btn-outline-primary w-100 rounded-3 py-2 fw-semibold" style="border-color: #0d6efd; color: #0d6efd;">Get Started</a>
                            @endif
                        </div>
                    </td>

                    <td style="vertical-align: top; background: #ffffff; border-radius: 16px; box-shadow: 0 15px 35px rgba(13, 110, 253, 0.1); border: 2px solid #0d6efd; padding: 40px 30px; text-align: center; position: relative;">
                        <div class="ribbon" style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #0d6efd; color: #fff; padding: 4px 20px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Most Popular</div>
                        <div class="plan-header mb-4 mt-2">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 mb-2 fw-semibold small" style="background-color: #e7f1ff; color: #0d6efd;">Growth</span>
                            <h3 class="fw-bold text-dark my-2">Pro Business</h3>
                            <div class="price-block my-3">
                                <span class="display-5 fw-bold text-dark" style="font-size: 2.5rem;">$49</span>
                                <span class="text-muted small">/ month</span>
                            </div>
                            <p class="text-muted small">Best fit for your current dashboard metrics.</p>
                        </div>
                        <hr style="border-top: 1px solid #f1f3f5; margin: 25px 0;">
                        <div class="plan-features text-start mb-4">
                            <ul class="list-unstyled m-0 p-0" style="line-height: 2.2;">
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Max 5</strong> Products</li>
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Unlimited</strong> Categories</li>
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> Up to 500 Stock Items</li>
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> Full Inventory Analytics</li>
                            </ul>
                        </div>
                        <div class="plan-action mt-4">
                            @if(auth()->user() && auth()->user()->subscribedToPrice('price_1Tl0dp5TaCf50YADcqrJRwsG', 'default'))
                                <button class="btn btn-success w-100 rounded-3 py-2 fw-semibold" disabled>✓ Current Plan</button>
                            @else
                                <a href="{{ route('checkout', 'Pro Business') }}" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold shadow-sm" style="background-color: #0d6efd; color: #fff; border: none;">Get Started</a>
                            @endif
                        </div>
                    </td>

                    <td style="vertical-align: top; background: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eef2f5; padding: 40px 30px; text-align: center;">
                        <div class="plan-header mb-4">
                            <span class="badge bg-dark-subtle text-dark rounded-pill px-3 py-1 mb-2 fw-semibold small" style="background-color: #e2e3e5; color: #1c1f23;">Scale</span>
                            <h3 class="fw-bold text-dark my-2">Enterprise</h3>
                            <div class="price-block my-3">
                                <span class="display-5 fw-bold text-dark" style="font-size: 2.5rem;">$99</span>
                                <span class="text-muted small">/ month</span>
                            </div>
                            <p class="text-muted small">For large inventories and high volume store.</p>
                        </div>
                        <hr style="border-top: 1px solid #f1f3f5; margin: 25px 0;">
                        <div class="plan-features text-start mb-4">
                            <ul class="list-unstyled m-0 p-0" style="line-height: 2.2;">
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> Everything in Pro</li>
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> <strong>Unlimited</strong> Product</li>
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> Dedicated Account Manager</li>
                                <li class="small text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i> 24/7 Phone & Chat Support</li>
                            </ul>
                        </div>
                        <div class="plan-action mt-4">
                            @if(auth()->user() && auth()->user()->subscribedToPrice('price_1Tl0ex5TaCf50YAD6FZs8a54', 'default'))
                                <button class="btn btn-success w-100 rounded-3 py-2 fw-semibold" disabled>✓ Current Plan</button>
                            @else
                                <a href="{{ route('checkout', 'Enterprise') }}" class="btn btn-outline-primary w-100 rounded-3 py-2 fw-semibold" style="border-color: #0d6efd; color: #0d6efd;">Get Started</a>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>