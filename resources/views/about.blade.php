@extends('layouts.app')

@section('title', 'About Us - Meatology')

@section('content')
<div class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="hero-background">
            <img src="{{ asset('images/carrusel1.png') }}" alt="Premium Uruguayan Beef" class="hero-bg-image">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="hero-title">About Meatology</h1>
                    <p class="hero-subtitle">A Legacy of Humane Farming</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="about-content">
        <div class="container">
            <!-- Legacy Section -->
            <div class="content-section">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="content-text">
                            <h2 class="section-title">A Legacy of Humane Farming</h2>
                            <p class="section-description">
                                In Uruguay and Argentina, cattle roam freely on lush, open ranges, living as nature intended. 
                                Unlike factory farms, where animals are often confined in cramped conditions, our farmers prioritize 
                                animal welfare at every stage. Our beef is certified by programs like <strong>Certified Humane®</strong>, 
                                ensuring no cages, no hormones, and no antibiotics.
                            </p>
                            <p class="section-description">
                                Animals graze on grass their entire lives, resulting in healthier, happier livestock and nutrient-rich 
                                meat for you.
                            </p>
                            <blockquote class="farming-quote">
                                "Take a moment to picture it: vast green fields under a wide South American sky, where cattle move 
                                freely, undisturbed by the stress of industrial systems. This isn't just farming—it's a way of life 
                                rooted in respect for animals and the land."
                            </blockquote>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-image">
                            <img src="{{ asset('images/carrusel2.png') }}" alt="Grass-Fed Cattle" class="section-img">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quality Section -->
            <div class="content-section bg-light-green">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                        <div class="content-text">
                            <h2 class="section-title">Strict Regulations, Uncompromising Quality</h2>
                            <p class="section-description">
                                Uruguay and Argentina are global leaders in ethical meat production, with laws that set a high bar 
                                for animal welfare and environmental stewardship. Uruguay, for instance, mandates full traceability, 
                                meaning we can tell you exactly where your steak came from, down to the ranch.
                            </p>
                            <p class="section-description">
                                Hormones and anabolic steroids are banned, and cattle are raised on natural pastures, not grain-heavy 
                                feedlots that can harm their health. Argentina's regulations are equally rigorous, ensuring small-batch 
                                harvesting that minimizes stress and prioritizes animal comfort.
                            </p>
                            <div class="quality-badges">
                                <span class="badge-item">✓ Hormone Free</span>
                                <span class="badge-item">✓ Antibiotic Free</span>
                                <span class="badge-item">✓ 100% Grass-Fed</span>
                                <span class="badge-item">✓ Full Traceability</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="content-image">
                            <img src="{{ asset('images/carrusel3.png') }}" alt="Sustainable Farming" class="section-img">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passion Section -->
            <div class="content-section">
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="content-text">
                            <h2 class="section-title">The Passion Behind the Pasture</h2>
                            <p class="section-description">
                                Our farmers aren't just producers; they're stewards of tradition. Many come from families who have 
                                raised cattle for generations, passing down knowledge of sustainable, humane practices. They know 
                                every animal, every field, and every season.
                            </p>
                            <p class="section-description">
                                This passion translates into meat that's not only delicious but also carries the pride of craftsmanship.
                            </p>
                            <div class="farmer-quote">
                                <div class="quote-content">
                                    <p>"We don't just raise cattle—we raise them with respect, like part of our family."</p>
                                    <cite>- Third-generation rancher, Tacuarembó, Uruguay</cite>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-image">
                            <img src="{{ asset('images/carrusel4.png') }}" alt="Culinary Excellence" class="section-img">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why It Matters Section -->
            <div class="content-section bg-dark-green">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center">
                        <h2 class="section-title text-white">Why It Matters to You</h2>
                        <p class="section-description text-white mb-4">
                            Choosing Meatology means choosing meat that's better for you, the animals, and the planet. 
                            Grass-fed beef is leaner, richer in omega-3s, and free of the additives found in factory-farmed products.
                        </p>
                        <p class="section-description text-white mb-5">
                            It's also a vote for sustainability—our regenerative farming practices help sequester carbon and 
                            restore soil health. Plus, every purchase supports farmers who share your values of compassion and responsibility.
                        </p>
                        <div class="benefits-grid">
                            <div class="benefit-item">
                                <div class="benefit-icon">🌱</div>
                                <h4>Better for You</h4>
                                <p>Leaner, richer in omega-3s, additive-free</p>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">🐄</div>
                                <h4>Better for Animals</h4>
                                <p>Humane treatment, natural lifestyle</p>
                            </div>
                            <div class="benefit-item">
                                <div class="benefit-icon">🌍</div>
                                <h4>Better for Planet</h4>
                                <p>Carbon sequestration, soil restoration</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="content-section">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2 class="section-title">Join Our Mission</h2>
                        <p class="section-description mb-4">
                            We invite you to be part of this story. Explore our selection of grass-fed beef from Uruguay and Argentina, 
                            and taste the difference that care and craftsmanship make.
                        </p>
                        <a href="{{ route('shop.index') }}" class="cta-button">
                            Shop Now & Join the Mission
                        </a>
                        <p class="cta-question">What's your reason for choosing humane meat?</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.about-page {
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
}

.about-hero {
    position: relative;
    height: 60vh;
    min-height: 400px;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(45, 80, 22, 0.8) 0%, rgba(45, 80, 22, 0.6) 100%);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 900;
    color: white;
    margin-bottom: 20px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 2;
    line-height: 1.1;
}

.hero-subtitle {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.9);
    position: relative;
    z-index: 2;
    font-weight: 300;
    line-height: 1.4;
}

.about-content {
    padding: 80px 0;
}

.content-section {
    padding: 60px 0;
    margin-bottom: 40px;
}

.bg-light-green {
    background: rgba(45, 80, 22, 0.05);
    border-radius: 20px;
    margin: 0 20px;
    padding: 40px 30px;
}

.bg-dark-green {
    background: linear-gradient(135deg, #2d5016 0%, #3d6b1f 100%);
    border-radius: 20px;
    margin: 0 20px;
    color: white;
    padding: 40px 30px;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2d5016;
    margin-bottom: 30px;
    line-height: 1.2;
}

.section-title.text-white {
    color: white;
}

.section-description {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #555;
    margin-bottom: 25px;
}

.section-description.text-white {
    color: rgba(255, 255, 255, 0.9);
}

.content-image {
    display: flex;
    justify-content: center;
    align-items: center;
}

.section-img {
    width: 100%;
    max-width: 500px;
    height: auto;
    border-radius: 15px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.section-img:hover {
    transform: scale(1.02);
}

.farming-quote {
    background: rgba(45, 80, 22, 0.05);
    border-left: 4px solid #c41e3a;
    padding: 25px 30px;
    margin: 30px 0;
    font-style: italic;
    font-size: 1.1rem;
    line-height: 1.6;
    border-radius: 0 10px 10px 0;
}

.quality-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 30px;
}

.badge-item {
    background: #c41e3a;
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    white-space: nowrap;
}

.farmer-quote {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
}

.quote-content p {
    font-size: 1.2rem;
    font-style: italic;
    color: #2d5016;
    margin-bottom: 15px;
    line-height: 1.5;
}

.quote-content cite {
    color: #c41e3a;
    font-weight: 600;
    font-style: normal;
    font-size: 0.95rem;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-top: 50px;
}

.benefit-item {
    text-align: center;
    padding: 20px;
}

.benefit-icon {
    font-size: 3rem;
    margin-bottom: 20px;
    display: block;
}

.benefit-item h4 {
    color: white;
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.benefit-item p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    line-height: 1.5;
}

.cta-button {
    display: inline-block;
    background: #c41e3a;
    color: white;
    padding: 18px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(196, 30, 58, 0.3);
    margin-bottom: 30px;
    text-align: center;
}

.cta-button:hover {
    background: #e74c3c;
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(196, 30, 58, 0.4);
    color: white;
    text-decoration: none;
}

.cta-question {
    font-style: italic;
    color: #666;
    font-size: 1.1rem;
    margin-top: 20px;
}

/* RESPONSIVE STYLES */

/* Large Desktop */
@media (max-width: 1200px) {
    .hero-title {
        font-size: 3.2rem;
    }
    
    .section-title {
        font-size: 2.3rem;
    }
    
    .section-img {
        max-width: 450px;
    }
}

/* Desktop and Large Tablets */
@media (max-width: 992px) {
    .hero-title {
        font-size: 3rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .content-section {
        padding: 40px 0;
    }
    
    .about-content {
        padding: 60px 0;
    }
    
    .bg-light-green,
    .bg-dark-green {
        margin: 0 15px;
        padding: 35px 25px;
    }
    
    .benefits-grid {
        gap: 30px;
        margin-top: 40px;
    }
    
    .farming-quote {
        padding: 20px 25px;
    }
    
    .farmer-quote {
        padding: 25px;
    }
}

/* Tablets */
@media (max-width: 768px) {
    .about-hero {
        height: 50vh;
        min-height: 350px;
    }
    
    .hero-title {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
        margin-bottom: 25px;
        text-align: center;
    }
    
    .section-description {
        font-size: 1rem;
        margin-bottom: 20px;
    }
    
    .content-section {
        padding: 35px 0;
    }
    
    .about-content {
        padding: 40px 0;
    }
    
    .bg-light-green,
    .bg-dark-green {
        margin: 0 10px;
        padding: 30px 20px;
        border-radius: 15px;
    }
    
    .quality-badges {
        justify-content: center;
        gap: 12px;
    }
    
    .badge-item {
        font-size: 0.85rem;
        padding: 6px 14px;
    }
    
    .benefits-grid {
        grid-template-columns: 1fr;
        gap: 25px;
        margin-top: 35px;
    }
    
    .benefit-item {
        padding: 15px;
    }
    
    .benefit-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }
    
    .benefit-item h4 {
        font-size: 1.2rem;
        margin-bottom: 12px;
    }
    
    .cta-button {
        padding: 15px 35px;
        font-size: 1rem;
    }
    
    .content-image {
        margin-top: 25px;
        margin-bottom: 25px;
    }
    
    .section-img {
        max-width: 100%;
    }
    
    /* Row reordering for mobile */
    .row .col-lg-6.order-lg-2 {
        order: 1;
    }
    
    .row .col-lg-6.order-lg-1 {
        order: 2;
    }
}

/* Mobile Landscape and Large Mobile */
@media (max-width: 576px) {
    .about-hero {
        height: 45vh;
        min-height: 300px;
    }
    
    .hero-title {
        font-size: 2rem;
        margin-bottom: 12px;
        line-height: 1.2;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1.8rem;
        margin-bottom: 20px;
    }
    
    .section-description {
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 18px;
    }
    
    .content-section {
        padding: 30px 0;
        margin-bottom: 30px;
    }
    
    .about-content {
        padding: 30px 0;
    }
    
    .bg-light-green,
    .bg-dark-green {
        margin: 0 5px;
        padding: 25px 15px;
        border-radius: 12px;
    }
    
    .farming-quote {
        padding: 18px 20px;
        font-size: 1rem;
        margin: 25px 0;
        border-radius: 0 8px 8px 0;
    }
    
    .farmer-quote {
        padding: 20px;
        margin-top: 25px;
    }
    
    .quote-content p {
        font-size: 1.1rem;
        margin-bottom: 12px;
    }
    
    .quote-content cite {
        font-size: 0.9rem;
    }
    
    .quality-badges {
        gap: 10px;
        margin-top: 25px;
    }
    
    .badge-item {
        font-size: 0.8rem;
        padding: 5px 12px;
    }
    
    .benefits-grid {
        gap: 20px;
        margin-top: 30px;
    }
    
    .benefit-item {
        padding: 12px;
    }
    
    .benefit-icon {
        font-size: 2.2rem;
        margin-bottom: 12px;
    }
    
    .benefit-item h4 {
        font-size: 1.1rem;
        margin-bottom: 10px;
    }
    
    .benefit-item p {
        font-size: 0.9rem;
    }
    
    .cta-button {
        padding: 12px 30px;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        width: 100%;
        max-width: 300px;
    }
    
    .cta-question {
        font-size: 1rem;
        margin-top: 15px;
        line-height: 1.4;
    }
}

/* Small Mobile */
@media (max-width: 480px) {
    .about-hero {
        height: 40vh;
        min-height: 280px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 0.95rem;
    }
    
    .section-title {
        font-size: 1.6rem;
    }
    
    .section-description {
        font-size: 0.9rem;
    }
    
    .bg-light-green,
    .bg-dark-green {
        margin: 0;
        padding: 20px 10px;
        border-radius: 10px;
    }
    
    .farming-quote {
        padding: 15px 18px;
        font-size: 0.95rem;
    }
    
    .farmer-quote {
        padding: 18px;
    }
    
    .quote-content p {
        font-size: 1rem;
    }
    
    .quality-badges {
        gap: 8px;
    }
    
    .badge-item {
        font-size: 0.75rem;
        padding: 4px 10px;
    }
    
    .benefit-icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    
    .benefit-item h4 {
        font-size: 1rem;
    }
    
    .benefit-item p {
        font-size: 0.85rem;
    }
    
    .cta-button {
        padding: 10px 25px;
        font-size: 0.9rem;
    }
}

/* Extra Small Mobile */
@media (max-width: 360px) {
    .hero-title {
        font-size: 1.6rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .container {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .bg-light-green,
    .bg-dark-green {
        padding: 15px 8px;
    }
}

/* Landscape Mode for Mobile */
@media (max-height: 500px) and (orientation: landscape) {
    .about-hero {
        height: 60vh;
        min-height: 250px;
    }
    
    .hero-title {
        font-size: 2.2rem;
        margin-bottom: 10px;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
}

/* High DPI / Retina displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .hero-bg-image,
    .section-img {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }
}

/* Reduced motion for accessibility */
@media (prefers-reduced-motion: reduce) {
    .section-img {
        transition: none;
    }
    
    .cta-button {
        transition: none;
    }
    
    .section-img:hover {
        transform: none;
    }
    
    .cta-button:hover {
        transform: none;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .farming-quote {
        background: rgba(45, 80, 22, 0.1);
    }
    
    .farmer-quote {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
    }
}
</style>
@endsection